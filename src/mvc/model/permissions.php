<?php
/**
 * What is my purpose?
 *
 **/

/** @var $model \bbn\Mvc\Model*/

$mgr    = $model->inc->user->getManager();
$cfg    = $model->inc->user->getClassCfg();
$src    = $model->inc->perm->getSources();
$access = $model->inc->options->fromCode('access', 'permissions', 'appui');
$options = $model->inc->options->fromCode('options', 'permissions', 'appui');
return $model->addData([
  'sources' => $src,
  'groups' => $mgr->groups(),
  'users' => $mgr->getList(),
  'users_table' => $cfg['arch']['users'],
  'groups_table' => $cfg['arch']['groups'],
  'rootAccess' => $access,
  'rootOptions' => $options
])->data;

