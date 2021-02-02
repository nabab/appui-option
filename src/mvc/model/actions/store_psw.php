<?php


if ( !empty($model->data['id_option']) &&
  !empty($model->data['new_password'])
 ){
   
  $psw = new \bbn\Appui\Passwords($model->db);

  $new_password = $psw->store($model->data['new_password'], $model->data['id_option']);
  if ( $new_password !== false ){
    return [
      'psw' => $model->data['new_password'],
      'success' => true
    ];
  }
}

return [
  'success' => false
];
