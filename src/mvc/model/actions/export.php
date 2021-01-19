<?php
/** @var $model \bbn\mvc\model */
$res = ['success' => false];
$o = false;
if ($model->has_data('id')) {
  $modes = ['children', 'full'];
  if ($model->has_data('mode') && in_array($model->data['mode'], $modes)) {
    $o = $model->inc->options->export($model->data['id'], $model->data['mode'] === 'full', true);
  }
  elseif (!$model->has_data('mode') || ($model->data['mode'] === 'single')) {
    $o = $model->inc->options->raw_option($model->data['id']);
  }
  if ($o) {
    $res['export'] = json_encode($o, JSON_PRETTY_PRINT);
    $res['success'] = true;
  }
}

return $res;
