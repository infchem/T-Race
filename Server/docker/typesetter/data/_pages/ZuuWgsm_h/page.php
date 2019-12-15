<?php
defined('is_running') or die('Not an entry point...');
$fileVersion = '5.1.1-b1';
$fileModTime = '1560096940';
$file_stats = array (
  'created' => 1558305167,
  'gpversion' => '5.1.1-b1',
  'modified' => 1560096940,
  'username' => 'admin',
);

$file_sections = array (
  0 => 
  array (
    'type' => 'wrapper_section',
    'content' => '',
    'contains_sections' => '3',
    'attributes' => 
    array (
      'class' => 'gpRow',
    ),
    'gp_label' => 'Section Wrapper',
    'gp_color' => '#555',
  ),
  1 => 
  array (
    'type' => 'text',
    'content' => '<h1>Spiel</h1>
',
    'resized_imgs' => 
    array (
    ),
    'modified' => 1560094403,
    'modified_by' => 'admin',
    'attributes' => 
    array (
      'class' => 'gpCol-8',
    ),
  ),
  2 => 
  array (
    'type' => 'include',
    'content' => 'TRaceGadget_Webshop',
    'attributes' => 
    array (
      'class' => 'gpCol-2',
    ),
    'gp_label' => 'File Include',
    'gp_hidden' => 'false',
    'include_type' => 'gadget',
    'modified' => 1560096937,
    'modified_by' => 'admin',
  ),
  3 => 
  array (
    'type' => 'include',
    'content' => 'TRaceGadget_PlayerStatus',
    'attributes' => 
    array (
      'class' => 'gpCol-2',
    ),
    'include_type' => 'gadget',
    'modified' => 1558808751,
    'modified_by' => 'admin',
    'gp_label' => 'File Include',
  ),
  4 => 
  array (
    'type' => 'include',
    'content' => 'TRaceGadget_Vouchers',
    'attributes' => 
    array (
    ),
    'include_type' => 'gadget',
    'modified' => 1558309325,
    'modified_by' => 'admin',
    'gp_label' => 'File Include',
  ),
);

$meta_data = array (
  'file_number' => 1,
  'file_type' => 'text',
);