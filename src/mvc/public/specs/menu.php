<?php
/*
 * Describe what it does to show you're not that dumb!
 *
 **/

/** @var $ctrl \bbn\mvc\controller */

if ( !isset($ctrl->arguments[0]) ){
  $ctrl->add_data([
    'cat' => '0'
  ]);
  $ctrl->combo("Options' tree", $ctrl->data);
}
else{
  $res = $ctrl->inc->options->full_options($ctrl->arguments[0]);
  $ctrl->obj->data = $res ?: [];
}
