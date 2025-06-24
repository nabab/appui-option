<?php

/** @var bbn\Mvc\Model $model */
if ($model->hasData('id', true)) {
  $res = [
    'res' => 0,
    'success' => false
  ];
  $o =& $ctrl->inc->options;
  $res['res'] = $o->fixOrder($model->data['id']);
  $res['data'] = $o->fullOptions($model->data['id']);
  $res['success'] = !empty($res['data']);
}

return $res;
