<?php

/** @var $ctrl \bbn\Mvc\Controller */
$ctrl->obj->success = false;
if ( isset($ctrl->post['id'], $ctrl->post['num']) ){
  $o =& $ctrl->inc->options;
  $o->order($ctrl->post['id'], $ctrl->post['num']);
  $ctrl->obj->data = $o->fullOptions($ctrl->inc->options->getIdParent($ctrl->post['id']));
  $ctrl->obj->success = true;
}
