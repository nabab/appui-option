<?php
/* @var bbn\Mvc\Model $model */
if ( 
  !empty($model->data['id']) &&
  $model->inc->options->unsetCfg($model->data['id'])
){
  return ['success' => true];
}
return ['success' => false];