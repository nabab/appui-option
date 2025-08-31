<?php
/* @var bbn\Mvc\Model $model */
if ( 
  ($pref = new \bbn\User\Preferences($model->db)) &&
  !empty($model->data['id'])
){
  return [
    'success' => true,
    'bits' => $pref->getBits($model->data['id'])
  ];
}
return ['success' => false];