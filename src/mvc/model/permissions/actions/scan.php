<?php

use bbn\X;
use bbn\Str;
use bbn\Mvc;

/** @var bbn\Mvc\Model $model */
$todo = [];
$parents = [];
$id_page = $model->inc->options->fromCode('access', 'permissions');
$withApp = false;
$routes = array_values($model->getRoutes());
foreach ($model->data['plugins'] as $id => $v) {
  if (Str::isUid($id) && $v) {
    $opt = $model->inc->options->option($id);
    if ($opt['code'] === 'access') {
      $plugin = $model->inc->options->parent($opt['id_parent']);
      if (!empty($plugin['plugin'])) {
        if (!isset($parents[$plugin['id_parent']])) {
          $parents[$plugin['id_parent']] = $model->inc->options->option($plugin['id_parent']);
        }

        $parent =& $parents[$plugin['id_parent']];
        if ($parent['code'] === 'appui') {
          $name = 'appui-'.$plugin['code'];
        }
        elseif ($parent['code'] === 'plugins') {
          $name = $plugin['code'];
        }
        if ($name && ($row = X::getRow($routes, ['name' => $name]))) {
          $todo[$row['url']] = $row;
          $todo[$row['url']]['path'] .= 'src/';
        }
      }
      elseif ($id === $id_page) {
        $url = Mvc::getCurPath();
        $todo[$url] = [
          'url' => $url,
          'root' => 'app',
          'name' => BBN_APP_NAME,
          'path' => $model->appPath()
        ];
      }
    }
  }
}

return ['res' => $model->inc->perm->updateAll($todo, $withApp)];
