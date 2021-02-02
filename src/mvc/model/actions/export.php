<?php
/** @var $model \bbn\Mvc\Model */
$res = ['success' => false];
$o = false;
if ($model->hasData('id')) {
  $modes = ['children', 'full'];
  if ($model->hasData('mode') && in_array($model->data['mode'], $modes)) {
    $o = $model->inc->options->export($model->data['id'], $model->data['mode'] === 'full', true);
  }
  elseif (!$model->hasData('mode') || ($model->data['mode'] === 'single')) {
    $o = $model->inc->options->rawOption($model->data['id']);
  }
  if ($o) {
    $res['export'] = json_encode($o, JSON_PRETTY_PRINT);
    $res['success'] = true;
  }
}

return $res;
