<?php
/*
 * Describe what it does to show you're not that dumb!
 *
 **/

/** @var $ctrl \bbn\mvc\controller */
$ctrl->obj->res = 0;
if ( !empty($ctrl->arguments[0]) ){
  /** @var \bbn\appui\option $o */
  $o =& $ctrl->inc->options;
  $ctrl->obj->res = $o->fix_order($ctrl->arguments[0]);
  $ctrl->obj->data = $o->full_options($ctrl->arguments[0]);
}
