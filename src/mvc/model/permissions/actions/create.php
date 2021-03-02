<?php
/**
 * What is my purpose?
 *
 **/

/** @var $model \bbn\Mvc\Model*/
$res = ['success' = false];
if (!empty($model->data['id_parent']) &&
    !empty($model->data['code'])  &&
    !empty($model->data['text'])
) {
  $id_option = $model->inc->options->add([
    'id_parent' => $model->data['id_parent'],
    'code' => $model->data['code'],
    'text' => $model->data['text'],
    'help' => $model->data['help'],
    'public' => !empty($model->data['public']),
    'cascade' => !empty($model->data['cascade']),
    'type' => 'permission'
  ]);
  $res['success'] = true;
  $res['id_option'] = $id_option;
}

return $res;
