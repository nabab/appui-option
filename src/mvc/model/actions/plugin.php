<?php
use bbn\X;

if ($model->hasData(['action', 'id_parent'])) {
  $res = ['success' => false];
  $o =& $model->inc->options;
  $idPlugins = $o->getMagicPluginsTemplateId();
  if ($o->getIdAlias($model->data['id_parent']) === $idPlugins) {
    switch ($model->data['action']) {
      case 'create':
        if ($model->hasData(['text', 'code'], true)) {
          $codes = X::split($model->data['code'], '-');
          if ((count($codes) > 1) && ($idPrefix = $o->fromCode($codes[0], $model->data['id_parent']))) {
            array_shift($codes);
            $model->data['code'] = X::join($codes, '-');
            $model->data['id_parent'] = $idPrefix;
          }

          $newParadigm = [
            'text' => $model->data['text'],
            'code' => $model->data['code'],
            'id_parent' => $model->data['id_parent'],
            'id_alias' => $o->getMagicPluginTemplateId()
          ];

          if ($id = $o->add($newParadigm)) {
            $o->applyTemplate($id);
            $res['success'] = true;
            $res['data'] = $o->option($id);
          }
        }
        break;
    }
  }

  return $res;
}
