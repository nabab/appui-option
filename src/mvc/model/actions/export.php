<?php
/** @var $model \bbn\Mvc\Model */
use bbn\X;
$res = ['success' => false];
$o = false;
if ($model->hasData('id')) {
  $modes = ['children', 'full', 'sfull', 'schildren', 'simple', 'single'];
  if (!$model->hasData('mode') || !in_array($model->data['mode'], $modes)) {
    $model->data['mode'] = 'single';
  }

  $simple = false;
  switch ($model->data['mode']) {
    case 'single':
      $o = $model->inc->options->rawOption($model->data['id']);
      break;
    case 'simple':
      $o = $model->inc->options->option($model->data['id']);
      $simple = true;
      break;
    case 'schildren':
      $o = $model->inc->options->fullOptions($model->data['id']);
      $simple = true;
      break;
    case 'children':
      $o = $model->inc->options->export($model->data['id'], false, true);
      break;
    case 'full':
      $o = $model->inc->options->export($model->data['id'], true, true);
      break;
    case 'sfull':
      $o = $model->inc->options->fullTree($model->data['id']);
      $simple = true;
      break;
  }

  if ($o) {
    if ($simple) {
      $fn = function ($o) use (&$model) {

        $cfg = $model->inc->options->getCfg($o['id']);
        if (!is_array($cfg) || !empty($cfg['inherit_from'])) {
          $cfg = [];
        }
        elseif (!empty($cfg['schema']) && is_string($cfg['schema'])) {
          $cfg['schema'] = json_decode($cfg['schema'], true);
        }
        if (isset($cfg['scfg']) && !empty($cfg['scfg']['schema']) && is_string($cfg['scfg']['schema'])) {
          $cfg['scfg']['schema'] = json_decode($cfg['scfg']['schema'], true);
        }

        if (!empty($cfg['id_root_alias'])) {
          if ($codes = $model->inc->options->getCodePath($o['id_root_alias'])) {
            $cfg['id_root_alias'] = $codes;
          }
          else {
            unset($cfg['id_root_alias']);
          }
        }

        unset($o['id_parent']);
        unset($o['id']);
        if (isset($o['num_children'])) {
          unset($o['num_children']);
        }

        if (isset($o['alias'])) {
          unset($o['alias']);
        }

        foreach ($o as $n => $v) {
          if (!$v) {
            unset($o[$n]);
          }
        }

        if ($o['id_alias'] && ($codes = $model->inc->options->getCodePath($o['id_alias']))) {
          $o['id_alias'] = $codes;
        }
        else {
          unset($o['id_alias']);
        }

        if (!empty($cfg)) {
          foreach ($cfg as $n => $v) {
            if (!$v) {
              unset($cfg[$n]);
            }
          }
          if (!empty($cfg)) {
            $o['cfg'] = $cfg;
          }
        }

        return $o;
      };

      switch ($model->data['mode']) {
        case 'simple':
          $o = $fn($o);
          break;
        case 'schildren':
          $o = X::map($fn, $o, 'items');
          $simple = true;
          break;
        case 'sfull':
          $o = $fn($o);
          $o['items'] = X::map($fn, $o['items'], 'items');
          break;
      }
    }

    $res['export'] = json_encode($o, JSON_PRETTY_PRINT);
    $res['success'] = true;
  }
}

return $res;
