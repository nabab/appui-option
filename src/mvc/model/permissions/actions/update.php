<?php
/**
 * What is my purpose?
 *
 **/

/** @var $model \bbn\Mvc\Model*/

$res = ['success' => false];
if (!empty($model->data['id'])
  && ($old = $model->inc->options->option($model->data['id']))
) {
  $cfg = [
    'id_parent' => $old['id_parent'],
    'id_alias' => $old['id_alias'],
    'text' => $model->data['text'],
    'help' => $model->data['help'],
    'public' => $model->data['public'],
    'cascade' => $model->data['cascade']
  ];
  if (!empty($model->data['code'])) {
    $cfg['code'] = $model->data['code'];
  }
  if ($model->inc->options->set($model->data['id'], $cfg)) {
    $res['success'] = 1;
  }
}

return $res;
