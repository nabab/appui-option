<?php
/**
 * What is my purpose?
 *
 **/

/** @var bbn\Mvc\Model $model */

if ($model->hasData('id')) {
  return ['data' => $model->inc->options->option($model->data['id'])];
}
