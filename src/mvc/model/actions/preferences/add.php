<?php
/* @var bbn\Mvc\Model $model */
if ( 
  ($pref = new \bbn\User\Preferences($model->db)) &&
  !empty($model->data['id_option']) &&
  $pref->add($model->data['id_option'], $model->data) 
){
  return [
    'success' => true,
    'prefs' => $pref->getAll($model->data['id_option'])
  ];
}
return ['success' => false];