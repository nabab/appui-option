<?php

if ($ctrl->hasArguments()) {
  $ctrl->addData(['action' => $ctrl->arguments[0]]);
}

$ctrl->action();
