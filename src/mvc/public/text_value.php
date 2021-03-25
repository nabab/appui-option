<?php
if (!$ctrl->hasData('id') && $ctrl->hasArguments()) {
  $ctrl->addData(['id' => $ctrl->arguments[0]]);
}
$ctrl->action();
