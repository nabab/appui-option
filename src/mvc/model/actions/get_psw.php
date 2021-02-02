<?php
if ( !empty($model->data['id_option']) ){
  $psw = new \bbn\Appui\Passwords($model->db);
  return [
    'psw' => $psw->get($model->data['id_option']),
    'success' => true
  ];
}
return [
  'success' => false
];
