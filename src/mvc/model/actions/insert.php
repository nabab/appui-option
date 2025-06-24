<?php

use bbn\X;

/** @var bbn\Mvc\Model $model */
$res = ['success' => false];
if ($model->hasData('id_parent', true)) {
  if (!empty($model->data['source_children'])) {
    $tree = $model->inc->options->fullTree($model->data['source_children']);
    if (isset($tree['items'])) {
      $model->data['items'] = $tree['items'];
    }

    unset($model->data['source_children']);
  }

  $cfg = $model->inc->options->getCfg($model->data['id_parent']);
  if (!empty($cfg['schema'])) {
    $schema = $cfg['schema'];
    if (is_string($schema)) {
      $schema = json_decode($schema, true);
    }

    foreach ($model->data as $i => $d) {
      if (
        (($idx = X::search($schema, ['field' => $i])) !== null) &&
        isset($schema[$idx]['type']) &&
        (strtolower($schema[$idx]['type']) === 'json') &&
        !is_array($d)
      ) {
        $model->data[$i] = json_decode($d, true);
      }
    }
  }

  if ($id = $model->inc->options->add($model->data)) {
    $data = $model->inc->options->nativeOption($id);
    if (!empty($data['id_alias'])) {
      $data['alias'] = $model->inc->options->nativeOption($data['id_alias']);
    }
    $res['success'] = true;
    $res['data'] = $data;
  }
}

return $res;