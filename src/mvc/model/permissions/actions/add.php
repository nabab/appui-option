<?php
/**
 * What is my purpose?
 *
 **/

/** @var $model \bbn\Mvc\Model*/
$res = ['success' => false, 'data' => []];
if ($model->hasData('id_option', true)) {
  $mgr = new bbn\User\Manager($model->inc->user);
  $res['success'] = $mgr->addPermission(
    $model->data['id_option'],
    $model->data['id_user'] ?? null,
    $model->data['id_group'] ?? null,
    $model->data['public'] ?? 0
  );
}

return $res;
