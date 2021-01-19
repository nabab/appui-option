<?php
/* @var \bbn\mvc\model $model */
if ( 
  ($pref = new \bbn\user\preferences($model->db)) &&
  !empty($model->data['id_option']) &&
  $pref->add($model->data['id_option'], $model->data) 
){
  return [
    'success' => true,
    'prefs' => $pref->get_all($model->data['id_option'])
  ];
}
return ['success' => false];