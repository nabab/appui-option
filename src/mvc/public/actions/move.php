<?php
/*
 * Describe what it does to show you're not that dumb!
 *
 **/

/** @var $ctrl \bbn\mvc\controller */


if ( isset($ctrl->post['idNode'], $ctrl->post['idParentNode']) ){
  $ctrl->action();
}