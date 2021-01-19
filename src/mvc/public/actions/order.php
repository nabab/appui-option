<?php
/*
 * Describe what it does to show you're not that dumb!
 *
 **/

/** @var $ctrl \bbn\mvc\controller */
$ctrl->obj->success = false;
if ( isset($ctrl->post['id'], $ctrl->post['num']) ){
  $o =& $ctrl->inc->options;
  $o->order($ctrl->post['id'], $ctrl->post['num']);
  $ctrl->obj->data = $o->full_options($ctrl->inc->options->get_id_parent($ctrl->post['id']));
  $ctrl->obj->success = true;
}
