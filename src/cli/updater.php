<?php

use bbn\X;
/** @var $ctrl \bbn\mvc\ctrl */
$fs = new \bbn\File\System();
$file0 = BBN_LIB_PATH.'bbn/bbn/changes.json';
// Changing codes
$changes = $fs->decodeContents($file0);
foreach ($changes as $ch) {
  if (is_array($ch)
      && isset($ch[0], $ch[1])
      && is_array($ch[0])
      && !empty($ch[0])
      && is_string($ch[1])
      && !empty($ch[1])
      && ($id = $ctrl->inc->options->fromCode(...$ch[0]))
  ) {
    $ctrl->inc->options->merge($id, ['code' => $ch[1]]);
  }
}


$file = BBN_LIB_PATH.'bbn/bbn/options.json';
$file2 = BBN_LIB_PATH.'bbn/bbn/permissions.json';
$file3 = BBN_LIB_PATH.'bbn/bbn/plugins.json';
$appui_options = X::toArray($fs->decodeContents($file));
$permissions_options = X::toArray($fs->decodeContents($file2));
$plugins_options = X::toArray($fs->decodeContents($file3));
array_unshift($appui_options[0]['items'], $permissions_options);
$permissions_options['id_alias'] = ['permissions', 'appui'];
$permissions_options['items'][0]['id_alias'] = ['access', 'permissions', 'appui'];
$permissions_options['items'][1]['id_alias'] = ['plugins', 'permissions', 'appui'];
$permissions_options['items'][2]['id_alias'] = ['options', 'permissions', 'appui'];
foreach ($appui_options[0]['items'] as $i => &$it) {
  if ($i) {
    if (!isset($it['items'])) {
      $it['items'] = [];
    }
    $it['items'][] = $plugins_options;
    $it['items'][] = $permissions_options;
  }
}
unset($it);
$root = $ctrl->inc->options->getDefault();
if ($res = $ctrl->inc->options->import($appui_options, $root)) {
  echo $res." options changed";
}
