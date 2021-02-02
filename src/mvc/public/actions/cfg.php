<?php
/*
 * Describe what it does to show you're not that dumb!
 *
 **/

/** @var $ctrl \bbn\Mvc\Controller */
$ctrl->obj->res = 0;
if ( isset($ctrl->post['id']) ){
  $ctrl->obj->res = $ctrl->inc->options->setCfg($ctrl->post['id'], $ctrl->post['cfg']);
}
