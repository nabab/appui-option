<?php

use bbn\X;
use bbn\Str;
/** @var bbn\Mvc\Model $model */

if ($model->hasData(['id', 'mode'], true)) {
  $res = ['success' => 0];
  switch ($model->data['mode']) {
    case 'parent':
      $cfg = $model->inc->options->getCfg($model->data['id']);
      $res['cfg'] = $cfg;
      if (!empty($cfg['id_template']) && $model->inc->options->exists($cfg['id_template'])) {
        $os = $model->inc->options->fullOptions($model->data['id']);
        foreach ($os as $o) {
          if (empty($o['id_alias'])) {
            $res['success'] += (int)$model->inc->options->setAlias($o['id'], $cfg['id_template']);
            $o['id_alias'] = $cfg['id_template'];
          }

          if ($o['id_alias'] === $cfg['id_template']) {
            $res['success'] += (int)$model->inc->options->applyTemplate($o['id']);
          }
        }
      }

      break;
  }

  return $res;
}
