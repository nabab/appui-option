<?php
/* @var bbn\Mvc\Model $model */
$res = ['success' => false];
if ($model->hasData('id', true) && $model->inc->options->remove($model->data['id'])) {
  $res['success'] = true;
  $res['res'] = $model->data;
}

return $res;
