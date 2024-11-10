<?php
/**
 * What is my purpose?
 *
 **/

use bbn\X;

/** @var bbn\Mvc\Model $model */
$res = ['success' => false];
if ($model->hasData('id', true)) {
  $row = $model->inc->options->option($model->data['id']);
  $mgr = new \bbn\User\Manager($model->inc->user);
  $groups = $mgr->groups();
  $users = $mgr->getList();
  $is_file = substr($row['code'], -1) !== '/';
  // Check if it's an option
  $is_option = $model->inc->options->isParent($model->data['id'], $model->inc->options->fromCode('options', 'permissions'));
  $data = [
    'id' => $row['id'],
    'text' => !empty($row['text']) ? $row['text'] : '',
    'code' => $row['code'],
    'path' => empty($is_option) ?
      //$model->inc->options->toPath($model->data['id'], '', \bbn\User\Permissions::getOptionId('page')) :
      $model->inc->options->toPath($model->data['id'], '', $model->inc->options->fromCode('access', 'permissions')) :
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
  //$id_page = $model->inc->options->fromCode('page', 'permission', 'appui');
  $id_page = $model->inc->options->fromCode('access', 'permissions');
  if ( $model->inc->options->isParent($model->data['id'], $id_page) ){
    $id_parent = $row['id_parent'];
    $p = [];
    while ( $id_parent !== $id_page ){
      $o = $model->inc->options->option($id_parent);
      array_push($p, $o['code']);
      $id_parent = $o['id_parent'];
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
