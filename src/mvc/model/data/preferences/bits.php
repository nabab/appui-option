<?php
/* @var \bbn\mvc\model $model */
if ( 
  ($pref = new \bbn\user\preferences($model->db)) &&
  !empty($model->data['id'])
){
  return [
    'success' => true,
    'bits' => $pref->get_bits($model->data['id'])
  ];
}
return ['success' => false];