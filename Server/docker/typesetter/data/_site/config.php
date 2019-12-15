<?php
defined('is_running') or die('Not an entry point...');
$fileVersion = '5.1.1-b1';
$fileModTime = '1560095015';
$file_stats = array (
  'created' => 1558305167,
  'gpversion' => '5.1.1-b1',
  'modified' => 1560095015,
  'username' => 'admin',
);

$config = array (
  'language' => 'en',
  'toemail' => 'admin@t-race.de',
  'gpLayout' => 'default',
  'title' => 'T-Race',
  'keywords' => '',
  'desc' => 'The T-Race project.',
  'timeoffset' => '0',
  'langeditor' => 'inherit',
  'dateformat' => '%m/%d/%y - %I:%M %p',
  'gpversion' => '5.1.1-b1',
  'passhash' => 'sha512',
  'gpuniq' => 'ZuuWgsmw8qYj430mqykr',
  'combinecss' => false,
  'combinejs' => false,
  'minifyjs' => false,
  'etag_headers' => false,
  'gallery_legacy_style' => false,
  'addons' => 
  array (
    'trace-gadgets' => 
    array (
      'code_folder_part' => '/addons/trace-gadgets',
      'data_folder' => 'trace-gadgets',
      'name' => 'T-Race Gadgets',
      'version' => '1.02',
      'id' => '100',
      'About' => 'Provides all gadgets for T-Race.',
    ),
  ),
  'file_count' => 5,
  'maximgarea' => '2073600',
  'preserve_icc_profiles' => true,
  'preserve_image_metadata' => true,
  'maxthumbsize' => '300',
  'maxthumbheight' => '',
  'check_uploads' => false,
  'colorbox_style' => 'example1',
  'customlang' => 
  array (
  ),
  'showgplink' => false,
  'showsitemap' => true,
  'showlogin' => true,
  'auto_redir' => '90',
  'history_limit' => '30',
  'resize_images' => true,
  'themes' => 
  array (
  ),
  'gadgets' => 
  array (
    'Contact' => 
    array (
      'class' => '\\gp\\special\\ContactGadget',
    ),
    'Search' => 
    array (
      'method' => 
      array (
        0 => '\\gp\\special\\Search',
        1 => 'gadget',
      ),
    ),
    'TRaceGadget_Vouchers' => 
    array (
      'addon' => 'trace-gadgets',
      'script' => '/addons/trace-gadgets/TRaceGadgets.php',
      'method' => 'TRaceGadget_Vouchers',
    ),
    'TRaceGadget_PlayerRegistration' => 
    array (
      'addon' => 'trace-gadgets',
      'script' => '/addons/trace-gadgets/TRaceGadgets.php',
      'method' => 'TRaceGadget_PlayerRegistration',
    ),
    'TRaceGadget_PlayerLogin' => 
    array (
      'addon' => 'trace-gadgets',
      'script' => '/addons/trace-gadgets/TRaceGadgets.php',
      'method' => 'TRaceGadget_PlayerLogin',
    ),
    'TRaceGadget_PlayerStatus' => 
    array (
      'addon' => 'trace-gadgets',
      'script' => '/addons/trace-gadgets/TRaceGadgets.php',
      'method' => 'TRaceGadget_PlayerStatus',
    ),
    'TRaceGadget_PlayerResult' => 
    array (
      'addon' => 'trace-gadgets',
      'script' => '/addons/trace-gadgets/TRaceGadgets.php',
      'method' => 'TRaceGadget_PlayerResult',
    ),
    'TRaceGadget_Webshop' => 
    array (
      'addon' => 'trace-gadgets',
      'script' => '/addons/trace-gadgets/TRaceGadgets.php',
      'method' => 'TRaceGadget_Webshop',
    ),
  ),
  'hooks' => 
  array (
    'GetHead' => 
    array (
      'trace-gadgets' => 
      array (
        'addon' => 'trace-gadgets',
        'script' => '/addons/trace-gadgets/TRaceGadgets.php',
        'method' => 'add_head_tags',
      ),
    ),
  ),
  'space_char' => '-',
  'cdn' => '',
  'thumbskeepaspect' => false,
  'homepath_auto' => false,
  'homepath_key' => 'a',
  'homepath' => 'T-Race',
  'HTML_Tidy' => '',
  'Report_Errors' => false,
  'toname' => '',
  'from_address' => 'AutomatedSender@localhost',
  'from_name' => 'Automated Sender',
  'from_use_user' => false,
  'require_email' => '',
  'mail_method' => 'mail',
  'sendmail_path' => '',
  'smtp_hosts' => '',
  'smtp_user' => '',
  'smtp_pass' => '',
  'recaptcha_public' => '',
  'recaptcha_private' => '',
  'recaptcha_language' => 'inherit',
  'admin_links' => 
  array (
  ),
);

$meta_data = array (
);