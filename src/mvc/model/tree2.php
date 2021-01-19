<?php
/** @var $model \bbn\mvc\model */

if ( isset($model->data['id']) ){
  $res = [
    'success' => false,
    'data' => empty($model->data['id']) ? [$model->inc->options->option(false)] : $model->inc->options->full_options($model->data['id']),
    'sql' => $model->db->last()
  ];
  if ( \is_array($res['data']) ){
    $res['success'] = true;
  }
  return $res;
}
