<?php
/* @var \bbn\Mvc\Controller $ctrl */
if ( !empty($ctrl->arguments) && \bbn\Str::isUid($ctrl->arguments[0]) ){
  $ctrl->data['id'] = $ctrl->arguments[0];
}

$ctrl->action();
