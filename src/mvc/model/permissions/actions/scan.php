<?php
/** @var $model \bbn\Mvc\Model*/
$routes = array_values($model->getRoutes());
$todo = [];
$parents = [];
foreach ($model->data as $id => $v) {
  if (bbn\Str::isUid($id) && $v) {
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
        if ($name && ($row = bbn\X::getRow($routes, ['name' => $name]))) {
          $todo[$row['url']] = $row;
        }
      }
    }
  }
}

return ['res' => $model->inc->perm->updateAll($todo)];