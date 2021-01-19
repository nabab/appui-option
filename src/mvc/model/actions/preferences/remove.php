<?php
/* @var \bbn\mvc\model $model */
$pref = new \bbn\user\preferences($model->db);
if ( !empty($model->data['id']) ){
  return ['success' => !!$pref->delete($model->data['id'])];
}
else if ( !empty($model->data['ids']) ){
  $err = 0;
  foreach ( $model->data['ids'] as $id ){
    if ( !$pref->delete($id) ){
      $err++;
    }
  }
  return ['success' => !$err];
}
return ['success' => false];