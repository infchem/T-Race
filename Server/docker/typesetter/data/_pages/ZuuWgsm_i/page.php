<?php
defined('is_running') or die('Not an entry point...');
$fileVersion = '5.1.1-b1';
$fileModTime = '1560094812';
$file_stats = array (
  'created' => 1558305167,
  'gpversion' => '5.1.1-b1',
  'modified' => 1560094812,
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
    'content' => '<h1>Auswertung</h1>
',
    'resized_imgs' => 
    array (
    ),
    'modified' => 1560094811,
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
    'modified' => 1558808751,
    'modified_by' => 'admin',
    'gp_label' => 'File Include',
  ),
  3 => 
  array (
    'type' => 'include',
    'content' => 'TRaceGadget_PlayerResult',
    'attributes' => 
    array (
    ),
    'include_type' => 'gadget',
    'modified' => 1560094607,
    'modified_by' => 'admin',
    'gp_label' => 'File Include',
  ),
);

$meta_data = array (
  'file_number' => 1,
  'file_type' => 'text',
);