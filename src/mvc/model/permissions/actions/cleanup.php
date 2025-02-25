<?php
/**
 * What is my purpose?
 *
 **/

use bbn\X;
use bbn\Str;

/** @var bbn\Mvc\Model $model */

$res = ['success' => true, 'total' => 0, 'tested' => 0];
foreach ($model->data as $id => $v) {
  if (Str::isUid($id) && $v) {
    $opt = $model->inc->options->option($id);
    if ($opt['code'] === 'access') {
      $tree = $model->inc->options->fullTree($id);
      if (!empty($tree['items'])) {
        $all            = array_reverse(X::flatten($tree['items'], 'items'));
        $res['tested'] += count($all);
        foreach ($all as $i => $a) {
          if (!$model->inc->perm->accessExists($a['id'])) {
            if (!$model->db->count('bbn_users_options', ['id_option' => $a['id']])) {
              X::log(
                $model->inc->options->getPathArray($a['id_alias'] ?: $a['id']),
                'delPerm'
              );
              $res['total'] += (int)$model->db->delete('bbn_options', ['id' => $a['id']]);
            }
          }
        }
      }
    }
  }

  $model->inc->options->deleteCache($id, true);
}

return $res;
