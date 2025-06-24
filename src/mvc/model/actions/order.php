<?php

/** @var bbn\Mvc\Model $model */
$res = ['success' => false];
if ($model->hasData(['id', 'num'])) {
  $o =& $model->inc->options;
  $o->order($model->data['id'], $model->data['num']);
  $res['data'] = $o->fullOptions($o->getIdParent($model->data['id']));
  $res['success'] = true;
}

return $res;
