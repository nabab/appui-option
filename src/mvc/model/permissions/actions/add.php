<?php
use bbn\User;

/** @var bbn\Mvc\Model $model */
$res = ['success' => false, 'data' => []];
if ($model->hasData('id_option', true)
&& ($mgr = $model->inc->user->getManager())
) {
  $res['success'] = $mgr->addPermission(
    $model->data['id_option'],
    $model->data['id_user'] ?? null,
    $model->data['id_group'] ?? null,
    $model->data['public'] ?? 0
  );
}

return $res;
