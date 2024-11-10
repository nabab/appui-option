<?php

/** @var bbn\Mvc\Controller $ctrl */
$ctrl->obj->res = 0;
if ( !empty($ctrl->arguments[0]) ){
  /** @var \bbn\Appui\Option $o */
  $o =& $ctrl->inc->options;
  $ctrl->obj->res = $o->fixOrder($ctrl->arguments[0]);
  $ctrl->obj->data = $o->fullOptions($ctrl->arguments[0]);
}
