<?php
/**
 * What is my purpose?
 *
 **/

/** @var $model \bbn\Mvc\Model*/

if ($model->hasData('id')) {
  return ['data' => $model->inc->options->option($model->data['id'])];
}
