<?php

/** @var $ctrl \bbn\Mvc\Controller */


if ( isset($ctrl->post['idNode'], $ctrl->post['idParentNode']) ){
  $ctrl->action();
}