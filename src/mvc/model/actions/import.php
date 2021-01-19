<?php
/*
 * Describe what it does!
 *
 **/

/** @var $this \bbn\mvc\model */
$res = ['success' => false];
if (
  isset($model->data['id'], $model->data['option']) &&
  ($data = json_decode($model->data['option'], true)) &&
  ($o = $model->inc->options->import($data, $model->data['id'], true, true))
){
  $res['success'] = $o;
}
return $res;