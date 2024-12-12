<?php

use bbn\X;

/** @var bbn\Mvc\Model $model */
/** @var bbn\Appui\Option $opt */

$opt = $model->inc->options;
if ($model->hasData('main')) {
  if ($model->hasData('id_option', true)) {
    $model->addData([
      'info' => $model->getModel('./data/get_info', ['id' => $model->data['id_option']])
    ]);
  }

  if ($model->inc->user->isAdmin()) {
    $roots = $opt->getDefaults();
    foreach ($roots as &$r) {
      $r['plugins'] = $opt->getPlugins($r['id'], true, true);

      unset($p);
      $r['rootOptions'] = $opt->fromCode('options', $r['id']);
      $r['rootTemplates'] = $opt->fromCode('templates', $r['id']);
      $r['rootPermissions'] = $opt->fromCode('permissions', $r['id']);
      $r['rootPlugins'] = $opt->fromCode('plugins', $r['id']);
  }

    unset($r);
    $model->addData(['roots' => $roots]);
  }

  if ($model->hasData('id_option', true)) {
    $parents = $opt->parents($model->data['id_option']);
    $num = count($parents);
    if ($num === 1) {
      $model->addData(['appId' => $model->data['id_option']]);
    }
    elseif ($num) {
      foreach ($roots as $r) {
        if ($r['id'] === $parents[count($parents) - 2]) {
          $model->addData(['appId'  => $r['id']]);
        }
      }
    }
  }

  if (!$model->hasData('appId', true)) {
    $model->addData(['appId' => X::getField($roots, ['code' => BBN_APP_NAME], 'id')]);
  }

  if (!$model->hasData('appId', true)) {
    throw new Exception(X::_("Impossible to find the app's root"));
  }

  return $model->addData([
    'absoluteRoot' => $opt->getRoot(),
    'plugins' => $opt->getPlugins(),
    'rootTemplates' => $opt->fromCode('templates', $opt->getRoot()),
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
  if (empty($data['id']) && $model->inc->user->isAdmin()) {
    $root = empty($data['appuiTree']) ? $opt->fromCode(false) : $opt->getRoot();
  }
  elseif (!empty($data['id'])) {
    $root = $data['id'];
  }

  $cfg = $opt->getCfg($root);
  $arr = $opt->fullOptions($root);
  if (empty($arr)) {
    $info = $opt->option($root);
    if (!$info['text'] && !empty($info['alias'])) {
      $arr = $opt->fullOptions($info['id_alias']);
    }
  }

  if (is_array($arr)) {
    return [
      'success' => true,
      'data' => array_map(
        function ($o) use ($cfg, $opt) {
          $icon = $o['icon'] ?? '';
          if (!$icon && !empty($o['alias']) && !empty($o['alias']['icon'])) {
            $icon = $o['alias']['icon'];
          }

          return [
            'text' => $o['text'],
            'icon' => $icon,
            'template' => $opt->isInTemplate($o['id']),
            'plugin' => $opt->isPlugin($o['id']),
            'app' => $opt->isApp($o['id']),
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
