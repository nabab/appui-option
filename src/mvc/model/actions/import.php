<?php

/** @var bbn\Mvc\Model $model */
$res = ['success' => false];
if (
  isset($model->data['id'], $model->data['option']) &&
  ($data = json_decode($model->data['option'], true)) &&
  ($o = $model->inc->options->importAll($data, $model->data['id']))
){
  $res['success'] = $o;
}
return $res;