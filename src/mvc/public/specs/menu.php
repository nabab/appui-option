<?php

/** @var bbn\Mvc\Controller $ctrl */

if ( !isset($ctrl->arguments[0]) ){
  $ctrl->addData([
    'cat' => '0'
  ]);
  $ctrl->combo("Options' tree", $ctrl->data);
}
else{
  $res = $ctrl->inc->options->fullOptions($ctrl->arguments[0]);
  $ctrl->obj->data = $res ?: [];
}
