<?php
use bbn\Str;

/** @var bbn\Mvc\Controller $ctrl */
if (empty($ctrl->post)) {
  if ($ctrl->hasArguments(2) && Str::isUid($ctrl->arguments[1])) {
    $ctrl->addData(['id_option' => $ctrl->arguments[1]]);
  }

  $ctrl->setColor('#1D481F', '#FFF')
    ->addData(['main' => 1])
    ->setObj(['scrollable' => false])
    ->setIcon('nf nf-mdi-file_tree')
    ->setUrl(APPUI_OPTION_ROOT . 'tree')
    ->combo(_("Options' tree"), true);
}
else {
  $ctrl->action();
}
