<?php
/**
 * What is my purpose?
 *
 **/

/** @var bbn\Mvc\Model $model */

if ($model->hasData('id', true)) {
  $model->data['res']['success'] = true;
  $model->data['res']['data'] =$model->inc->options->textValueOptions($model->data['id']);
}
return $model->data['res'];
