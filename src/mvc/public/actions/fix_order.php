<?php
/*
 * Describe what it does to show you're not that dumb!
 *
 **/

/** @var $ctrl \bbn\Mvc\Controller */
$ctrl->obj->res = 0;
if ( !empty($ctrl->arguments[0]) ){
  /** @var \bbn\Appui\Option $o */
  $o =& $ctrl->inc->options;
  $ctrl->obj->res = $o->fixOrder($ctrl->arguments[0]);
  $ctrl->obj->data = $o->fullOptions($ctrl->arguments[0]);
}
