<?php

use bbn\X;

/** @var $ctrl \bbn\mvc\ctrl */
X::adump("Hello from the updater...");
$appui = new bbn\Appui();
if ($res = $appui->importOptions()) {
  echo $res . _("options changed");
}

/*
$fs = new \bbn\File\System();
$file0 = BBN_LIB_PATH.'bbn/bbn/changes.json';
if (!is_file($file0)) {
  X::adump("Hello from the updater...");
  throw new \Exception("Impossible to find the file changes");
}
X::adump("File changes found...");

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

*/