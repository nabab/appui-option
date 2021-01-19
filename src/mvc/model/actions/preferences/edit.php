<?php
/* @var \bbn\mvc\model $model */
if ( 
  ($pref = new \bbn\user\preferences($model->db)) &&
  !empty($model->data['id']) &&
  ($c = $pref->get_class_cfg())
){
  $fields = $c['arch']['user_options'];
  $cfg = $pref->get_cfg(null, $model->data);
  if ( $model->db->update($c['table'], [
    $fields['text'] => $model->data[$fields['text']] ?? NULL,
    $fields['num'] => $model->data[$fields['num']] ?? NULL,
    $fields['id_link'] => $model->data[$fields['id_link']] ?? NULL,
    $fields['id_alias'] => $model->data[$fields['id_alias']] ?? NULL,
    $fields['id_user'] => $model->data[$fields['id_user']] ?? NULL,
    $fields['public'] => $model->data[$fields['public']] ?: 0,
    $fields['cfg'] => $cfg ? json_encode($cfg) : NULL
  ], [
    $fields['id'] => $model->data['id']
  ]) ){
    return [
      'success' => true,
      'prefs' => $pref->get_all($model->data['id_option'])
    ];
  }
}
return ['success' => false];