<?php
defined('is_running') or die('Not an entry point...');
$fileVersion = '5.1.1-b1';
$fileModTime = '1558812497';
$file_stats = array (
  'created' => 1558305167,
  'gpversion' => '5.1.1-b1',
  'modified' => 1558812497,
  'username' => 'admin',
);

$file_sections = array (
  0 => 
  array (
    'type' => 'wrapper_section',
    'content' => '',
    'contains_sections' => '2',
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
    'content' => '<h1>Login</h1>
',
    'resized_imgs' => 
    array (
    ),
    'modified' => 1558797379,
    'modified_by' => 'admin',
    'attributes' => 
    array (
      'class' => 'gpCol-10',
    ),
  ),
  2 => 
  array (
    'type' => 'include',
    'content' => 'TRaceGadget_PlayerStatus',
    'attributes' => 
    array (
      'class' => 'gpCol-2',
    ),
    'include_type' => 'gadget',
    'modified' => 1558812471,
    'modified_by' => 'admin',
    'gp_label' => 'File Include',
  ),
  3 => 
  array (
    'type' => 'include',
    'content' => 'TRaceGadget_PlayerLogin',
    'attributes' => 
    array (
    ),
    'include_type' => 'gadget',
    'modified' => 1558797430,
    'modified_by' => 'admin',
    'gp_label' => 'File Include',
  ),
);

$meta_data = array (
  'file_number' => 1,
  'file_type' => 'text',
);