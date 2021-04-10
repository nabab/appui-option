<?php
/** @var $model \bbn\Mvc\Model */

// Root
if (empty($model->data['id'])) {
  $model->data['id'] = $model->inc->options->fromCode(false);
  $arr               = [$model->inc->options->option($model->data['id'])];
}
else {
  $arr = $model->inc->options->fullOptions($model->data['id']);
}

if (is_array($arr)) {
  if (empty($arr)) {
    return [
      'success' => true,
      'data'    => []
    ];
  }

  $cfg = $model->inc->options->getCfg($model->data['id']);
  $arr = $model->inc->options->fullOptions($model->data['id']);

  return [
    'success' => true,
    'data' => array_map(
      function ($o) use ($cfg) {
        $icon = $o['icon'] ?? '';
        if (!$icon && !empty($o['alias']) && !empty($o['alias']['icon'])) {
          $icon = $o['alias']['icon'];
        }

        return [
          'text' => $o['text'],
          'icon' => $icon,
          'numChildren' => $o['num_children'],
          'sortable' => !empty($cfg['sortable']),
          'data' => $o
        ];
      },
      $arr
    )
  ];
}

return ['success' => false];
