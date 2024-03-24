<?php

/** @var $ctrl \bbn\Mvc\Controller */
if (empty($ctrl->post)) {
  $ctrl->setColor('#1D481F', '#FFF')
    ->addData(['main' => 1])
    ->setIcon('nf nf-mdi-file_tree')
    ->setUrl(APPUI_OPTION_ROOT . 'tree')
    ->combo(_("Options' tree"), true);
} else {
  $ctrl->action();
}
