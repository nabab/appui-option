<?php
/** @var bbn\Mvc\Model $model */
use bbn\X;

$res = ['success' => false];
if ($model->hasData('id')
    && ($o = $model->inc->options->export($model->data['id'], $model->data['mode']))
) {
  $res['export'] = json_encode($o, JSON_PRETTY_PRINT);
  $res['success'] = true;
}

return $res;
