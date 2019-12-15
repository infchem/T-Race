<?php defined('is_running') or die('Not an entry point...');

function pphandle() //password protected page
{
	global $page,$gp_index,$title,$addonFolderName,$config,$langmessage,$gp_titles;
	//echo $title; var_export($page->TitleInfo); print_r($gp_titles);
	//$page->contentBuffer .= '<p>message</p>';
	if (!isset($gp_index[$title]))
		return;
	$p =& $gp_titles[$gp_index[$title]];//shortcut
	$in=common::LoggedIn();
	if ($in && !admin_tools::HasPermission('file_editing'))
		return;
	if (!$in && !isset($p['ppp']))
		return;
	$a = $config['addons'][$addonFolderName];
	if (!isset($a['t1'])) {//use defaults
		$a['t1']='Password: ';
		$a['t2']='Enter';
		$a['t3']='Enter password to access this page.';
		$a['t4']='Wrong password';
		$a['cookies']=false;
	}
	if($in)
	{
		$pass=isset($p['ppp'])? $p['ppp']:'';
		if ( isset($_POST['ppp']) && $_POST['ppp']!=$pass) //if posted form with new password
		{

			if (isset($p['pppe'])) //if page is encrypted
			{
				message('Attention! This page is encrypted with RC4. The password can be changed <a href="'.common::GetUrl('Admin_pppages').'" target="_blank">here</a>.');
			}
			else
			{
				//change password
				if ($_POST['ppp']=='')
				{
					if (isset($p['ppp']))
						unset($p['ppp']);
				}
				else
				{
					$p['ppp']=$_POST['ppp'];
				}
				//echo 'saving '.$p['ppp'];
				admin_tools::SavePagesPHP();
				$pass=isset($p['ppp'])? $p['ppp']:'';
			}
		}
	}
	else //not logged in
	{
		if ($a['cookies'])
		{
			if (isset($_POST['ppp']))
			{
				setcookie('ppp',$_POST['ppp'],0,'/');//expires on browser close
			}
			elseif (isset($_COOKIE['ppp']))
			{
				$_POST['ppp']=$_COOKIE['ppp'];
			}
		}
		$pass= isset($_POST['ppp'])? $_POST['ppp'] : '';
	}
	$s = '<form id="fppp" action="'.common::GetUrl($title).'" method="post" style="margin:1em 0">'.PHP_EOL;
	$s .= '<label for="ppp">'.$a['t1'].'</label><input type="'.($in?'text':'password').'" name="ppp" id="ppp" value="'.($in?$pass:'').'"/>'.PHP_EOL;
	$s .= '<input type="submit" name="Submit" value="'.($in?$langmessage['save']:$a['t2']).'"/>'.PHP_EOL;
	$s .= '</form><br/>'.PHP_EOL;
	if ($in)
	{//in
		if (isset($_GET['showpasswordform']))
			$page->contentBuffer = $s.$page->contentBuffer;
		$s = isset($p['ppp'])? $langmessage['Set']:$langmessage['Not_Set'];
		$page->admin_links[] = array($title,$langmessage['password'].':'.$s,'showpasswordform');
	}
	elseif (isset($p['ppp']))
	{//out+needs a password
		if ($pass!=$p['ppp'])
			$page->contentBuffer = isset($_POST['ppp'])? $s.$a['t4']: $s.$a['t3'];//access denied
	}
}

function SectionToContent($section_data,$section_num)
{
	global $gp_titles, $gp_index, $title, $addonPathCode;
	if ($section_data['type']=='text')
	{
		$p = $gp_titles[$gp_index[$title]];//shortcut
		if (isset($p['pppe'])) //if section is in encrypted page
		{
			if (!class_exists('rc4crypt'))
				include($addonPathCode.'/class.rc4crypt.php'); //rc4 algorythm
			$rc4 = new rc4crypt;
			$pass= isset($p['ppp'])? $p['ppp']:'';
			$section_data['content'] = $rc4->decrypt($pass, $section_data['content'], 0); //encrypt with pw;
			unset($rc4);
			if (common::LoggedIn())
			{
				message('<div>Attention: This page is handled as encrypted!<br/> To edit it, you must <a href="'.common::GetUrl('Admin_pppages').'">remove the RC4 encryption</a> first.</div>');
			}
		}
	}
	return $section_data;
}
