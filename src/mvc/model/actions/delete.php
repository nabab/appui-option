<?php
/* @var $model \bbn\Mvc\Model */
$res = ['success' => false];
if ($model->hasData('id', true) && $model->inc->options->remove($model->data['id'])) {
  $res['success'] = true;
  $res['res'] = $model->data;
}

return $res;
