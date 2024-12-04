<?php

if ($model->hasData('id_parent', true) 
  && ($model->hasData('text', true) || $model->hasData('id_alias', true))
) {
  $res = ['success' => false];
  $newOpt = [
    'text' => $model->data['text'] ?? null,
    'code' => $model->data['code'] ?? null,
    'id_alias' => $model->data['alias'] ?? null,
    'id_parent' => $model->data['id_parent']
  ];

  if ($id = $model->inc->options->add($newOpt)) {
    $res['success'] = true;
    $res['data'] = $model->inc->options->option($id);
  }

  return $res;
}
