<?php
/**
 * What is my purpose?
 *
 **/

use bbn\X;

/** @var bbn\Mvc\Model $model */
$res = ['success' => false];
if ($model->hasData('id', true)) {
  $o           =& $model->inc->options;
  $row         = $o->option($model->data['id']);
  $user        = bbn\User::getInstance();
  $mgr         = $model->inc->user->getManager();
  $groups      = $mgr->groups();
  $users       = $mgr->getList();
  $is_file     = substr($row['code'], -1) !== '/';
  $pluginTplId = $o->getPluginTemplateId();
  $permTplId   = $o->getPermissionsTemplateId();
  // Check if it's an option
  $optionTplId = $o->fromCode('options', $permTplId);
  $accessTplId = $o->fromCode('access', $permTplId);
  if (!$optionTplId) {
    throw new Exception(X::_("Impossible to find the options' permissions' template"));
  }

  $parents   = $o->parents($model->data['id']);
  $ok        = false;
  $is_option = false;
  $root      = null;
  $plugin    = null;
  foreach ($parents as $i => $p) {
    if ($alias = $o->getIdAlias($p)) {
      if ($alias === $optionTplId) {
        $is_option = true;
        $root      = $p;
      }
      elseif ($alias === $accessTplId) {
        $root = $p;
      }
      elseif ($alias === $pluginTplId) {
        $plugin = $p;
        break;
      }
    }
  }

  if (!$root) {
    throw new Exception(X::_("The given option is not a permission"));
  }

  $data = [
    'id' => $row['id'],
    'text' => !empty($row['text']) ? $row['text'] : '',
    'code' => $row['code'],
    'path' => empty($is_option) ?
      //$o->toPath($model->data['id'], '', \bbn\User\Permissions::getOptionId('page')) :
      $o->toPath($model->data['id'], '', $root) :
      'options/list/'.$row['id'],
    'help' => !empty($row['help']) ? $row['help'] : '',
    'public' => !empty($row['public']) ? $row['public'] : 0,
    'cascade' => !empty($row['cascade']) ? $row['cascade'] : 0,
    'is_parent' => !empty($row['num_children']),
    'exist' => false
  ];
  foreach ( $groups as $g ){
    $data['group'.$g['id']] = $model->inc->pref->groupHas($row['id'], $g['id']);
  }
  foreach ( $users as $u ){
    $data['user'.$u['id']] = $model->inc->pref->userHas($row['id'], $u['id']);
  }

  // Check if it's a real file/dir (page)
  //$id_page = $o->fromCode('page', 'permission', 'appui');
  if (!$is_option){
    $id_parent = $row['id_parent'];
    $p = [];
    while ( $id_parent !== $root ){
      $op = $o->option($id_parent);
      array_push($p, $op['code']);
      $id_parent = $op['id_parent'];
    }
    $p = array_reverse($p);
    $path = implode('', $p).$row['code'].($is_file ? '.php' : '');
    $tried = [[$model->appPath().'mvc/public/'.$path, 'really']];
    if ( file_exists($model->appPath().'mvc/public/'.$path) ){
      $data['exist'] = true;
      $data['type'] = $is_file ? 'file' : 'folder';
    }
    else{
      if ( !empty($p) ){
        $name = substr($p[0], 0, \strlen($p[0]));
      }
      else if ( !$is_file ) {
        $name = substr($row['code'], 0, \strlen($row['code']));
      }
      if ( !empty($name) ){
        foreach ( $model->data['routes'] as $n => $r ){
          array_push($tried, [$r['path'].'src/mvc/public/'.substr($path, \strlen($name))]);
          if ( $n.'/' === $name ){
            $tried[count($tried)-1][1] = 'really';
            if ( file_exists($r['path'].'src/mvc/public/'.substr($path, \strlen($name))) ){
              $data['exist'] = true;
              $data['type'] = $is_file ? 'file' : 'folder';
              break;
            }
          }
        }
      }
    }
  }
  $res['data'] = $data;
  $res['success'] = true;
}
return $res;
