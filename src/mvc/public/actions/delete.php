<?php
/* @var $ctrl \bbn\Mvc\Controller */
$ctrl->obj->res = 0;
if ( isset($ctrl->post['id']) && $ctrl->inc->options->remove($ctrl->post['id']) ){
  $ctrl->obj->success = true;
  $ctrl->obj->res = $ctrl->post;
}
