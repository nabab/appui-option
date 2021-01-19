<?php
/** @var $model \bbn\mvc\model */
$plugins = $model->get_plugins();
$fs = new \bbn\file\system();
$res = [];
array_unshift($plugins, [
  'url' => '',
  'path' => $model->app_path()
]);
foreach ( $plugins as $name => $cfg ){
  if ( $fs->cd($cfg['path'].'plugins/appui-options') ){
    $all = $fs->scan('.', 'file');
    foreach ( $all as $a ){
      $bits = \bbn\x::split($a, '/');
      $fn = basename($bits[1], '.'.\bbn\str::file_ext($bits[1]));
      $st = $fn.' <em>'._('from').' '.
            ($name ?: _('Application')).
            '</em>';
      if ( !isset($res[$st]) ){
        $res[$st] = [
          'plugin' => $name ?: '',
          'fn' => $fn,
          'title' => $st,
          'elements' => []
        ];
      }
      $res[$st]['elements'][] = $bits[0];
    }
  }
}
//return
$r = [];
foreach ( $res as $n => $re ){
  $r[] = [
    'text' => $n.' ('.\bbn\x::join($re['elements'], ',').')',
    'value' => ($re['plugin'] ? $re['plugin'].'/' : '').$re['fn']
  ];
}
return ['controllers' => $r];