<?php
/**
 * What is my purpose?
 *
 **/

use bbn\X;

/** @var $model \bbn\Mvc\Model*/

$res = ['success' => true, 'total' => 0, 'tested' => 0];
$src = $model->inc->perm->getSources();
$id_access = $model->inc->options->fromCode('access', 'permissions', 'appui');
foreach ($src as $s) {
  //$o = $model->inc->options->option($s['value']);
  $tree = $model->inc->options->fullTree($s['rootAccess']);
  if (!empty($tree['items'])) {
    $all = array_reverse(X::flatten($tree['items'], 'items'));
    $res['tested'] += count($all);
    foreach ($all as $i => $a) {
      if (!$model->inc->perm->accessExists($a['id'])) {
        if (!$model->db->count('bbn_users_options', ['id_option' => $a['id']])) {
          $res['total'] += (int)$model->db->delete('bbn_options', ['id' => $a['id']]);
        }
      }
    }
  }
}

$model->inc->options->deleteCache(null);
return $res;
