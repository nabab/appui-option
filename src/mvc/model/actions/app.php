<?php
use bbn\X;

if ($model->hasData('action')) {
  $res = ['success' => false];
  switch ($model->data['action']) {
    case 'create':
      if ($model->hasData(['text', 'code'], true)) {
        $newParadigm = [
          'text' => $model->data['text'],
          'code' => $model->data['code'],
          'id_parent' => $model->inc->options->getRoot(),
          'id_alias' => $model->inc->options->getPluginTemplateId()
        ];
        if ($id = $model->inc->options->add($newParadigm)) {
          $model->inc->options->applyTemplate($id);
          $res['success'] = true;
          $res['data'] = $model->inc->options->option($id);
        }
      }
      break;
  }

  return $res;
}
