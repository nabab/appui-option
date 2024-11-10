<?php
/**
 * What is my purpose?
 *
 **/

/** @var bbn\Mvc\Model $model */

$res = ['success' => false];
if (!empty($model->data['id'])) {
  $res['success'] = $model->inc->options->remove($model->data['id']);
}

return $res;
