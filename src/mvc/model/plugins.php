<?php
/** @var bbn\Mvc\Model $model */
$plugins = $model->getPlugins();
$fs = new \bbn\File\System();
$res = [];
array_unshift($plugins, [
  'url' => '',
  'path' => $model->appPath()
]);
foreach ( $plugins as $name => $cfg ){
  if ( $fs->cd($cfg['path'].'plugins/appui-option') ){
    $all = $fs->scan('.', 'file');
    foreach ( $all as $a ){
      $bits = \bbn\X::split($a, '/');
      $fn = basename($bits[1], '.'.\bbn\Str::fileExt($bits[1]));
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
    'text' => $n.' ('.\bbn\X::join($re['elements'], ',').')',
    'value' => ($re['plugin'] ? $re['plugin'].'/' : '').$re['fn']
  ];
}
return ['controllers' => $r];