<?php

use bbn\X;
/** @var $ctrl \bbn\mvc\ctrl */
$fs = new \bbn\File\System();
$file = BBN_LIB_PATH.'bbn/bbn/options.json';
$file2 = BBN_LIB_PATH.'bbn/bbn/permissions.json';
$file3 = BBN_LIB_PATH.'bbn/bbn/plugins.json';
$appui_options = X::toArray($fs->decodeContents($file));
$permissions_options = X::toArray($fs->decodeContents($file2));
$plugins_options = X::toArray($fs->decodeContents($file3));
array_unshift($appui_options['items'], $permissions_options);
$permissions_options['id_alias'] = ['permissions', 'appui'];
$permissions_options['items'][0]['id_alias'] = ['access', 'permissions', 'appui'];
$permissions_options['items'][1]['id_alias'] = ['plugins', 'permissions', 'appui'];
$permissions_options['items'][2]['id_alias'] = ['options', 'permissions', 'appui'];
$root = $ctrl->inc->options->getDefault();
if ($res = $ctrl->inc->options->import($appui_options, $root)) {
  echo $res." options changed";
}
