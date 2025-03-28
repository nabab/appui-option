<?php
/**
 * What is my purpose?
 *
 **/

/** @var bbn\Mvc\Model $model */

$mgr    = $model->inc->user->getManager();
$cfg    = $model->inc->user->getClassCfg();
$src    = $model->inc->perm->getSources(false);
$access = $model->inc->options->fromCode('access', 'permissions');
$options = $model->inc->options->fromCode('options', 'permissions');
return $model->addData([
  'sources' => $src,
  'groups' => $mgr->groups(),
  'users' => $mgr->getList(),
  'users_table' => $cfg['arch']['users'],
  'groups_table' => $cfg['arch']['groups'],
  'rootAccess' => $access,
  'rootOptions' => $options
])->data;

