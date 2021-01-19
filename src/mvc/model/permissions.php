<?php
/** @var $model \bbn\mvc\model*/
if ( !empty($model->data['action']) ){
  if ( $model->data['action'] === 'insert' ){
    if ( !empty($model->data['id_parent']) &&
      !empty($model->data['code'])  &&
      !empty($model->data['text'])
    ){
      if ( $model->inc->options->add([
        'id_parent' => $model->data['id_parent'],
        'code' => $model->data['code'],
        'text' => $model->data['text'],
        'help' => $model->data['help'],
        'public' => !empty($model->data['public']),
        'cascade' => !empty($model->data['cascade']),
        'type' => 'permission'
      ]) ){
        return [
          'success' => 1
        ];
      }
    }
    return false;
  }
  else if ( $model->data['action'] === 'update' ){
    if ( !empty($model->data['text']) ){
      $cfg= [
        'text' => $model->data['text'],
        'help' => $model->data['help'],
        'public' => $model->data['public'],
        'cascade' => $model->data['cascade']
      ];
      if ( !empty($model->data['code']) ){
        $cfg['code'] = $model->data['code'];
      }
      if ( $model->inc->options->set($model->data['id'], $cfg) ){
        return [
          'success' => 1
        ];
      }
    }
    return false;
  }
  else if ( $model->data['action'] === 'delete' ){
    if ( !empty($model->data['id']) &&
      $model->inc->options->remove($model->data['id'])
    ){
      return [
        'success' => 1
      ];
    }
    return false;
  }
  else if ( $model->data['action'] === 'add' ){
    if ( isset($model->data['id_option']) &&
      (!empty($model->data['id_user']) || !empty($model->data['id_group']))
    ){
      return [
        'res' => $model->db->insert_ignore('bbn_users_options', [
          'id_option' => $model->data['id_option'],
          'id_user' => !empty($model->data['id_user']) ? $model->data['id_user'] : null,
          'id_group' => empty($model->data['id_user']) ? $model->data['id_group'] : null
        ])
      ];
    }
  }
  else if ( $model->data['action'] === 'remove' ){
    if (
      isset($model->data['id_option']) &&
      (!empty($model->data['id_user']) || !empty($model->data['id_group']))
    ){
      return [
        'res' => $model->db->delete('bbn_users_options', [
          'id_option' => $model->data['id_option'],
          (empty($model->data['id_user']) ? 'id_group' : 'id_user') => empty($model->data['id_user']) ? $model->data['id_group'] : $model->data['id_user'],
        ])
      ];
    }
  }
}
else if ( isset($model->data['id']) &&
  !empty($model->data['full'])
){
  $row = $model->inc->options->option($model->data['id']);
  $mgr = new \bbn\user\manager($model->inc->user);
  $groups = $mgr->groups();
  $users = $mgr->get_list();
  $is_file = substr($row['code'], -1) !== '/';
  // Check if it's an option
  $is_option = $model->inc->options->is_parent($model->data['id'], $model->inc->options->from_root_code('options', 'permissions', 'appui'));
  $res = [
    'id' => $row['id'],
    'text' => !empty($row['text']) ? $row['text'] : '',
    'code' => $row['code'],
    'path' => empty($is_option) ?
      $model->inc->options->to_path($model->data['id'], '', \bbn\user\permissions::get_option_id('page')) :
      'options/list/'.$row['id'],
    'help' => !empty($row['help']) ? $row['help'] : '',
    'public' => !empty($row['public']) ? $row['public'] : 0,
    'cascade' => !empty($row['cascade']) ? $row['cascade'] : 0,
    'is_parent' => !empty($row['num_children']),
    'exist' => false
  ];
  foreach ( $groups as $g ){
    $res['group'.$g['id']] = $model->inc->pref->group_has($row['id'], $g['id']);
  }
  foreach ( $users as $u ){
    $res['user'.$u['id']] = $model->inc->pref->user_has($row['id'], $u['id']);
  }

  // Check if it's a real file/dir (page)
  $id_page = $model->inc->options->from_root_code('page', 'permissions', 'appui');
  if ( $model->inc->options->is_parent($model->data['id'], $id_page) ){
    $id_parent = $row['id_parent'];
    $p = [];
    while ( $id_parent !== $id_page ){
      $o = $model->inc->options->option($id_parent);
      array_push($p, $o['code']);
      $id_parent = $o['id_parent'];
    }
    $p = array_reverse($p);
    $path = implode('', $p).$row['code'].($is_file ? '.php' : '');
    $tried = [[$model->app_path().'mvc/public/'.$path, 'really']];
    if ( file_exists($model->app_path().'mvc/public/'.$path) ){
      $res['exist'] = true;
      $res['type'] = $is_file ? 'file' : 'folder';
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
              $res['exist'] = true;
              $res['type'] = $is_file ? 'file' : 'folder';
              break;
            }
          }
        }
      }
    }
  }
  return $res;
}
else if ( isset($model->data['id']) ){
  $rows = $model->inc->options->full_options($model->data['id']) ?: [];
  $res = [
    'folders' => [],
    'files' => []
  ];
  foreach ( $rows as $r ){
    $is_folder = false;
    if ( empty($r['icon']) ){
      if ( substr($r['code'], -1) === '/' ){
        $is_folder = true;
        $r['icon'] = 'nf nf-fa-folder';
      }
      else {
        $real = false;
        $path_to_file = $model->inc->options->to_path($r['id'], '', \bbn\user\permissions::get_option_id('page'));
        if ( file_exists($model->app_path().'mvc/public/'.$path_to_file.'.php') ){
          $real = true;
        }
        if ( empty($real) ){
          foreach ( $model->data['routes'] as $n => $route ){
            if ( file_exists($route['path'].'src/mvc/public/'.substr($path_to_file, \strlen($n)+1).'.php') ){
              $real = true;
              break;
            }
          }
        }
        $r['icon'] = !empty($real) ? 'nf nf-fa-file' : 'nf nf-fa-key';
      }
    }
    if (
      $model->inc->perm->has($r['id']) ||
      (!empty($r['num_children']) && $model->inc->perm->has_deep($r['id']))
    ){
      $res[!empty($is_folder) ? 'folders' : 'files'][$r['code']] = [
        'id' => $r['id'],
        'text' => $r['text'],
        'code' => $r['code'],
        'icon' => $r['icon'],
        'numChildren' => $r['num_children'] ?: 0
      ];
    }
  }

  ksort($res['folders'], SORT_STRING | SORT_FLAG_CASE);
  ksort($res['files'], SORT_STRING | SORT_FLAG_CASE);

  return array_merge(array_values($res['folders']), array_values($res['files']));

}
else{
  $mgr = $model->inc->user->get_manager();
  $model->data['groups'] = $mgr->groups();
  $model->data['users'] = $mgr->get_list();
  $cfg = $model->inc->user->get_class_cfg();
  $model->data['users_table'] = $cfg['arch']['users'];
  $model->data['groups_table'] = $cfg['arch']['groups'];
  return $model->data;
}
