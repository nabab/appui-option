<?php

use bbn\X;
use bbn\Str;
/** @var bbn\Mvc\Controller $ctrl */
if ($ctrl->hasArguments() && !empty($ctrl->post)) {
  $ok = true;
  foreach ($ctrl->arguments as $v) {
    if (Str::pos($v, '../') !== false) {
      $ok = false;
    }
  }

  if ($ok && $ctrl->controllerExists($ctrl->pluginUrl('appui-option').'/permissions/'.X::join($ctrl->arguments, '/'), true)) {
    $ctrl->addToObj('./permissions/'.X::join($ctrl->arguments, '/'), $ctrl->post, true);
  }
  else {
    $ctrl->obj->success = false;
    $ctrl->obj->error = _('Invalid path');
  }
}
else {
  $ctrl->obj->scrollable = false;
  $ctrl->combo(_("Access control"), true);
}
