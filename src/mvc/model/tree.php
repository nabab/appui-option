<?php

/** @var bbn\Mvc\Model $model */
/** @var bbn\Appui\Option $model->inc->options */


if ($model->hasData('main')) {
  if ($model->hasData('id_option', true)) {
    $model->addData([
      'option' => [
        'info' => $model->inc->options->option($model->data['id_option']),
        'cfg' => $model->inc->options->getCfg($model->data['id_option'])
      ]
    ]);
  }

  return $model->addData([
    'cat' => $model->inc->options->fromCode(false),
    'is_dev' => $model->inc->user->isDev(),
    'is_admin' => $model->inc->user->isAdmin(),
    'lng' => [
      'problem_while_moving' => _("Sorry, a problem occured while moving this item, and although the tree says otherwise the item has not been moved."),
      'please_refresh' => _("Please refresh the tab in order to see the awful truth..."),
      'confirm_move' => _("Are you sure you want to move this option? Although the configuration will remain the same, the access path will be changed.")
    ]
  ])->data;
}

if ($model->hasData('data', true)) {
  $data = $model->data['data'];
  if (isset($data['appuiTree'])) {
    $root = $data['appuiTree'] && $model->inc->user->isAdmin() ? $model->inc->options->getRoot() : $model->inc->options->fromCode(false);
  }
  else {
    $root = !empty($data['id']) ? $data['id'] : ($model->inc->user->isAdmin() ? $model->inc->options->getRoot() : $model->inc->options->fromCode(false));
  }

  $cfg = $model->inc->options->getCfg($root);
  $arr = $model->inc->options->fullOptions($root);
  if (is_array($arr)) {
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
}

return ['success' => false];
