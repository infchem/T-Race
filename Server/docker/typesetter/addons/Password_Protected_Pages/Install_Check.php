<?php 
defined('is_running') or die('Not an entry point...');

function GetAddonKey($addon_id)
{
	global $config;
	if(empty($config['addons']))
		return false;
	foreach($config['addons'] as $addon_key => $addon_info){
		if( isset($addon_info['id']) && $addon_info['id'] == $addon_id )
			return $addon_key;
	}
	return false;
}

function Install_Check()
{
	global $config, $dataDir, $gpversion, $gp_titles;
	//echo '<pre>'.var_export($config).'</pre>';
	$key=GetAddonKey(152);
	if ($key) //if plugin already installed
	{
		$ver = 0+$config['addons'][$key]['version'];
		if ($ver==1.1)
		{
			//check for possible RC4-encrypted pages
			$enc = array();
			foreach ($gp_titles as $a)
			{
				if (isset($a['pppe']))
					$enc[] = $a['label'];
			}
			if (count($enc))
			{
				echo '<p> Installer recognized, that the following pages are currently encrypted using old RC4 stream cipher: </p>';
				echo '<p style="color:red; background-color:white"> '.implode(', ',$enc).' </p>';
				echo '<p> This package contains updated RC4 algorythm, that is not compatible with the RC4 used in version 1.1. </p>';
				echo '<p><b> Please <a href="'.common::GetUrl('Admin_pppages').'" target="_blank">unencrypt your pages first</a> (uncheck their checkboxes) and then you can continue with this update. </b> </p>';
				return false;
			}
		}
	}
	return true;
}

