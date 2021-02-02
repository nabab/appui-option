<?php
/** @var $model \bbn\Mvc\Model */

if ( empty($model->data['id']) ){
  $model->data['id'] = $model->inc->options->fromCode(false);
}
if ( isset($model->data['id']) ){
  $cfg = $model->inc->options->getCfg($model->data['id']);
  $res = [
    'success' => false,
    'data' => array_map(function($o) use($cfg){
      return [
        'text' => $o['text'],
        'icon' => $o['icon'] ?? '',
        'numChildren' => $o['num_children'],
        'sortable' => !empty($cfg['sortable']),
        'data' => $o
      ];
    }, empty($model->data['id']) ? [$model->inc->options->option(false)] : $model->inc->options->fullOptions($model->data['id'])),
    'sql' => $model->db->last()
  ];
  if ( \is_array($res['data']) ){
    $res['success'] = true;
  }
  return $res;
}