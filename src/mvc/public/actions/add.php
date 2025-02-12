<?php

if ($ctrl->hasArguments()) {
  $ctrl->addData(['__bbnExtraParam__' => $ctrl->arguments[0]]);
}

$ctrl->action();
