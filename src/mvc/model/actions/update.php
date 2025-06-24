<?php
use bbn\X;

/** @var bbn\Mvc\Model $model */
$res = ['success' => false];
if ($model->hasData('value') && ($model->data['value'] === null)) {
  $model->data['value'] = '';
}
unset($model->data['res']);
if ($model->hasData('id', true) && ($model->hasData('id_alias', true) || $model->hasData('text', true))) {
  $o =& $model->inc->options;
  $cfg = $o->getParentCfg($model->data['id']);
  if (!empty($cfg['schema'])) {
    if (is_array($cfg['schema'])) {
      $schema = $cfg['schema'];
    }
    elseif (is_string($cfg['schema'])) {
      $schema = json_decode($cfg['schema'], true);
    }

    if (!empty($schema)) {
      foreach ( $model->data as $i => $d ){
        if (
          (($idx = X::search($schema, ['field' => $i])) !== null) &&
          isset($schema[$idx]['type']) &&
          is_string($d) &&
          (strtolower($schema[$idx]['type']) === 'json')
        ){
          $model->data[$i] = json_decode($d, true);
        }
      }
    }
  }

  if ($o->set($model->data['id'], $model->data)) {
    $res['success'] = true;
    $res['data'] = X::mergeArrays($o->nativeOption($model->data['id']), $o->option($model->data['id']));
    //$ctrl->obj->data = $ctrl->inc->options->nativeOption($model->data['id']);
    $res['post'] = $model->data;
  }
}

return $res;
