<?php

/** @var bbn\Mvc\Controller $ctrl */


if ( isset($ctrl->post['idNode'], $ctrl->post['idParentNode']) ){
  $ctrl->action();
}