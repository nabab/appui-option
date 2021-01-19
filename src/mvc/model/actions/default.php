<?php
/* @var \bbn\mvc\model $model */
if ( 
  !empty($model->data['id']) &&
  $model->inc->options->unset_cfg($model->data['id'])
){
  return ['success' => true];
}
return ['success' => false];