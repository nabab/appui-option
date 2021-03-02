<?php
/**
 * What is my purpose?
 *
 **/

/** @var $model \bbn\Mvc\Model*/

$res = ['success' => false];
if (!empty($model->data['id'])) {
  $res['success'] = $model->inc->options->remove($model->data['id']);
}

return $res;
