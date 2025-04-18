<?php
/**
 * What is my purpose?
 *
 **/

/** @var bbn\Mvc\Model $model */

$res = ['success' => false];
if (isset($model->data['id_option'])
  && (!empty($model->data['id_user']) || !empty($model->data['id_group']))
  && ($mgr = $model->inc->user->getManager())
) {
  $res['success'] = $mgr->removePermission(
    $model->data['id_option'],
    $model->data['id_user'] ?? null,
    $model->data['id_group'] ?? null,
    $model->data['public'] ?? 0
  );
}

return $res;
