<?php
defined('is_running') or die('Not an entry point...');

global $config,$addonFolderName,$langmessage,$gp_index,$gp_titles,$page, $addonPathCode;

$page->head_js[] = '/data/_addoncode/'.$addonFolderName.'/refresh.js';

if (isset($_POST['save'])) //settings
{
	$config['addons'][$addonFolderName]['t1']=htmlspecialchars($_POST['t1']);
	$config['addons'][$addonFolderName]['t2']=htmlspecialchars($_POST['t2']);
	$config['addons'][$addonFolderName]['t3']=htmlspecialchars($_POST['t3']);
	$config['addons'][$addonFolderName]['t4']=htmlspecialchars($_POST['t4']);
	$config['addons'][$addonFolderName]['cookies']=isset($_POST['cookies'])?true:false;
	if (admin_tools::SaveConfig())
		message($langmessage['SAVED']);
}

if (isset($_POST['savep'])) //passwords
{
	if (!class_exists('rc4crypt'))
		include($addonPathCode.'/class.rc4crypt.php'); //rc4 algorythm
	foreach ($gp_index as $t=>$i) {
		if (isset($_POST['p_'.$t])) {
			$pw=$_POST['p_'.$t]; //echo $t.$pw.'<br/>'; //new posted password
			$opw = isset($gp_titles[$i]['ppp'])? $gp_titles[$i]['ppp']:''; //old password
			//handle crypted text
			if (isset($gp_titles[$i]['pppe'])) //if page is already encrypted
			{
				if (isset($_POST['e_'.$t]) && $pw!=$opw) // if stay encrypted and change pw
				{
					//decrypt
					$file = gpFiles::PageFile($t);
					include($file);
					$rc4 = new rc4crypt;
					foreach ($file_sections as $j=>$section)
					{
						if ($section['type']=='text')
						{
							$plain_text = $rc4->decrypt($opw, $section['content'], 0); //decrypt using old pw
							$file_sections[$j]['content'] = $rc4->encrypt($pw, $plain_text, 0); //encrypt using new pw
						}
					}
					unset($rc4);
					gpFiles::SaveArray($file, 'meta_data',$meta_data,'file_sections',$file_sections);
				}
				if (!isset($_POST['e_'.$t])) //if we only wanna decrypt it
				{
					//decrypt
					$file = gpFiles::PageFile($t);
					include($file);
					$rc4 = new rc4crypt;
					foreach ($file_sections as $j=>$section)
					{
						if ($section['type']=='text')
							$file_sections[$j]['content'] = $rc4->decrypt($opw, $section['content'], 0); //encrypt with old pw
					}
					unset($rc4);
					gpFiles::SaveArray($file, 'meta_data',$meta_data,'file_sections',$file_sections);
				}
			}
			else //page is currently decrypted
			{
				if (isset($_POST['e_'.$t])) //but we will encrypt it
				{
					//encrypt
					$file = gpFiles::PageFile($t);
					include($file);
					$rc4 = new rc4crypt;
					foreach ($file_sections as $j=>$section)
					{
						if ($section['type']=='text')
							$file_sections[$j]['content'] = $rc4->encrypt($pw, $section['content'], 0); //encrypt using new pw
					}
					unset($rc4);
					gpFiles::SaveArray($file, 'meta_data',$meta_data,'file_sections',$file_sections);
				}
			}
			//set flags
			if (isset($_POST['e_'.$t]))
				$gp_titles[$i]['pppe'] = true;
			elseif (isset($gp_titles[$i]['pppe']))
				unset($gp_titles[$i]['pppe']);
			//set unset pw
			if ($pw=='')
			{
				if (isset($gp_titles[$i]['ppp']))
				{
					unset($gp_titles[$i]['ppp']); //remove old password
				}
			}
			else
			{
				$gp_titles[$i]['ppp']=$pw; //set new password
			}
		}
	}
	if (admin_tools::SavePagesPHP())  // update /data/_site/pages.php file (with passwords)
		message($langmessage['SAVED']);
}

$a = $config['addons'][$addonFolderName];
if (!isset($a['t1'])) {//use defaults
	$a['t1']='Password';
	$a['t2']='Enter';
	$a['t3']='Enter password to access this page.';
	$a['t4']='Wrong password';
	$a['cookies']=false;
}

echo '<i>'.$langmessage['Settings'].'</i><br/>';
echo '<form action="'.common::GetUrl('Admin_pppages').'" method="post" style="border:1px solid #ccc; padding:1em">'.PHP_EOL;
echo '<table style="width:100%">'.PHP_EOL;
echo '<tr><td><label for="t1">Password</label></td><td><input type="text" id="t1" name="t1" value="'.$a['t1'].'" style="width:99%"/></td></tr>';
echo '<tr><td><label for="t2">Enter</label></td><td><input type="text" id="t2" name="t2" value="'.$a['t2'].'" style="width:99%"/></td></tr>';
echo '<tr><td><label for="t3">Password Needed</label></td><td><input type="text" id="t3" name="t3" value="'.$a['t3'].'" style="width:99%"/></td></tr>';
echo '<tr><td><label for="t4">Access Denied</label></td><td><input type="text" id="t4" name="t4" value="'.$a['t4'].'" style="width:99%"/></td></tr>';
echo '<tr><td><label for="cookies">Enable cookies ?</label></td><td><input type="checkbox" id="cookies" name="cookies"'.($a['cookies']?' checked="checked"':'').'/></td></tr>';
echo '</table>'.PHP_EOL;
echo '<input type="submit" name="save" value="'.$langmessage['save'].'"/>';
echo '</form>';

$page->head.='<style type="text/css">#Password_protected_pages_list a:hover {color:red}</style>';
echo '<br/><i>'.$langmessage['Pages'].'</i><br/>';
echo '<form name="pppform" action="'.common::GetUrl('Admin_pppages').'" method="post">';
echo '<table id="Password_protected_pages_list" style="border:1px solid #aaa; padding:1em;">';
echo '<tr><td></td><td>'.$langmessage['password'].'</td><td>RC4</td><td></td></tr>';
foreach ($gp_index as $t=>$i) {
	$url=common::GetUrl($t);
	echo '<tr><td style="color:';
	echo isset($gp_titles[$i]['ppp'])?'red':'green';
	$e = isset($gp_titles[$i]['pppe']); //encrypted
	echo '" onclick="document.pppform.'.$t.'.select()">'.common::GetLabel($t).'</td>';
	$p = isset($gp_titles[$i]['ppp'])? $gp_titles[$i]['ppp']:''; //password
	echo '<td><input type="password" class="pppp" name="p_'.$t.'" value="'.$p.'"/></td>';
	if ($gp_titles[$i]['type']=='special' || $gp_titles[$i]['type']=='gallery')
		echo '<td></td>'; //special pages cannot be encrypted
	else
		echo '<td><input type="checkbox" name="e_'.$t.'"'.($e?' checked="checked"':'').' /></td>';
	echo '<td><a href="'.$url.'" title="'.$url.'" target="_blank">&#187;</a></td>';
	echo '</tr>';
}
echo '<tr><td><input type="submit" name="savep" value="'.$langmessage['save'].'"/></td><td><a onclick="$(\'#Password_protected_pages_list input.pppp\').each(function(i){var newtype=$(this).attr(\'type\')==\'text\'?\'password\':\'text\'; this.setAttribute(\'type\',newtype);});" style="pointer:hand">Show/hide passwords</a></td></tr>';
echo '</table>';
echo '</form>';

if( isset($_GET['cmd']) && ($_GET['cmd']=='refreshe' || $_GET['cmd']=='refreshd')){
	$pw = isset($_GET['pw'])? $_GET['pw']:'';
	if (!class_exists('rc4crypt'))
		include($addonPathCode.'/class.rc4crypt.php'); //rc4 algorythm
	$rc4 = new rc4crypt;
	$page->ajaxReplace = array();
	if ($_GET['cmd']=='refreshe')
	{
		//$refresh_content = $_GET['cmd'];
		$refresh_content = $rc4->encrypt($pw, $_GET['text'], 0); //encrypt text
		$page->ajaxReplace[] = array('inner','#tgtt',$refresh_content);
	}
	else
	{
		$refresh_content = $rc4->decrypt($pw, $_GET['text'], 0); //decrypt text
		$page->ajaxReplace[] = array('inner','#srct',$refresh_content);
	}
	unset($rc4);
	return;
}

echo '<br/><div onclick="$(this).next(\'div\').toggle()" style="cursor:pointer"> Encrypt / Decrypt Text with RC4 </div>';
echo '<div style="display:none"><br/>';
echo $langmessage['password'].': <input type="text" value="" id="pw" /><br/>';
echo 'Decrypted Text: /';
echo common::Link('Admin_pppages',' Encrypt ','cmd=refreshe','name="refresh_content"');
echo '/<br/><textarea cols="50" rows="10" id="srct"></textarea><br/>';
echo 'Encrypted Text: /';
echo common::Link('Admin_pppages',' Decrypt ','cmd=refreshd','name="refresh_content"');
echo '/<br/><textarea cols="50" rows="10" id="tgtt"></textarea><br/>';
echo '</div>';

