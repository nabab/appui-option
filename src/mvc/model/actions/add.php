<?php

if ($model->hasData('id_parent', true) 
  && ($model->hasData('text', true) || $model->hasData('id_alias', true))
) {

  $res = ['success' => false];
  $newOpt = [
    'text' => $model->data['text'] ?? null,
    'code' => $model->data['code'] ?? null,
    'id_alias' => $model->data['id_alias'] ?? null,
    'id_parent' => $model->data['id_parent']
  ];
  $template = false;

  if ($model->hasData('__bbnExtraParam__', true)) {
    switch ($model->data['__bbnExtraParam__']) {
      case 'plugin':
        if (!empty($model->data['prefix'])) {
          if (!($newOpt['id_parent'] = $model->inc->options->fromCode($model->data['prefix'], 'plugins'))) {
            $newOpt['id_parent'] = $model->inc->options->add([
              'text' => $model->data['prefix'],
              'code' => $model->data['prefix'],
              'id_parent' => $model->inc->options->fromCode('plugins')
            ]);
          }
        }

        $newOpt['id_alias'] = $model->inc->options->getPluginTemplateId();
        $template = true;

        break;

      case 'subplugin':
        break;

      case 'app':
        break;

    }
    
  }

  if ($id = $model->inc->options->add($newOpt)) {
    $res['success'] = true;
    $res['data'] = $model->inc->options->option($id);
    if ($template) {
      $model->inc->options->applyTemplate($id);
    }
  }


  return $res;
}
