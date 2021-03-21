<?php

use bbn\X;
/** @var $ctrl \bbn\Mvc\Controller */
if ($ctrl->hasArguments() && !empty($ctrl->post)) {
  $ctrl->addToObj('./permissions/'.X::join($ctrl->arguments, '/'), $ctrl->post, true);
}
else {
  $ctrl->combo(_("Access control"), true);
}
