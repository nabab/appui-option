<?php
/**
 * What is my purpose?
 *
 **/

use bbn\X;

/** @var bbn\Mvc\Model $model */
if ($model->hasData('data', true)
    && X::hasProps($model->data['data'], ['id', 'mode'], true)
    && ($opt = $model->inc->options->option($model->data['data']['id']))
) {
  $appui = $model->inc->options->fromCode('appui');
  $root = $model->inc->options->fromCode('permissions');
  $mode = $model->data['data']['mode'] === 'options' ? 'options' : 'access';
  $from = $model->inc->options->fromCode($mode, $root);

  $options = $model->inc->options->fromCode('options', $root);
  $access = $model->inc->options->fromCode('access', $root);
  $plugins = $model->inc->options->fromCode('plugins');
  if ($opt['id'] === $root) {
    $rows = [$model->inc->options->option($from)];
    $rows[0]['text'] = _("Main application");
    $rows[0]['numChildren'] = $rows[0]['num_children'];
    unset($rows[0]['num_children']);
    $all = array_merge(
      $model->inc->options->fullOptions($appui),
      $model->inc->options->fullOptions($plugins)
    );
    foreach ($all as $o) {
      if (!empty($o['plugin'])
         && ($id_perm = $model->inc->options->fromCode($mode, 'permissions', $o['id']))
      ) {
        $tmp = $model->inc->options->option($id_perm);
        if (!empty($tmp['num_children'])) {
          $tmp['text'] = $o['text'];
          $tmp['code'] = $o['code'];
          $tmp['numChildren'] = $tmp['num_children'];
          unset($tmp['num_children']);
          $rows[] = $tmp;
        }
      }
    }

    return ['data' => $rows];
  }
  else {
    $rows = $model->inc->options->fullOptions($model->data['data']['id']) ?: [];
    if ($mode === 'options') {
      $data = [];
      foreach ( $rows as $r ){
        $data[] = [
          'id' => $r['id'],
          'alias' => [
            'text' => $r['alias']['text'],
            'code' => $r['alias']['code'],
            'icon' => $r['alias']['icon']
          ],
          'text' => '',
          'code' => null,
          'numChildren' => $r['num_children'] ?? 0
        ];
      }

      return ['data' => $data];
  	}
    else {
      $res = [
        'folders' => [],
        'files' => []
      ];

      foreach ( $rows as $r ){
        $is_folder = false;
        if (empty($r['icon'])) {
          if ( substr($r['code'], -1) === '/' ){
            $is_folder = true;
            $r['icon'] = 'nf nf-fa-folder';
          }
          else {
            $real = false;
            $parents = array_reverse($model->inc->options->parents($r['id']));
            if (in_array($access, $parents, true)) {
              $path_to_file = $model->inc->options->toPath($r['id'], '', $access);
              if (file_exists($model->appPath().'mvc/public/'.$path_to_file.'.php')) {
                $real = true;
              }
            }
            else {
              $plugin_name = $model->inc->options->code($parents[2]);
              if ($model->inc->options->code($parents[1]) === 'appui') {
                $plugin_name = 'appui-'.$plugin_name;
              }
              $path_to_file = $model->inc->options->toPath($r['id'], '', $parents[4]);
              $url = $model->pluginUrl($plugin_name);
              if (file_exists($model->pluginPath($plugin_name).'mvc/public/'.$path_to_file.'.php')) {
                $real = true;
              }
            }

            $r['icon'] = empty($real) ? 'nf nf-fa-key' : 'nf nf-fa-file';
          }
        }
        if (
          $model->inc->perm->has($r['id']) ||
          (!empty($r['num_children']) && $model->inc->perm->hasDeep($r['id']))
        ){
          $res[!empty($is_folder) ? 'folders' : 'files'][$r['code']] = [
            'id' => $r['id'],
            'text' => $r['text'],
            'code' => $r['code'],
            'icon' => $r['icon'],
            'numChildren' => $r['num_children'] ?? 0
          ];
        }
      }

      ksort($res['folders'], SORT_STRING | SORT_FLAG_CASE);
      ksort($res['files'], SORT_STRING | SORT_FLAG_CASE);
      return [
        'data' => array_merge(array_values($res['folders']), array_values($res['files']))
      ];
    }
  }
}

return $model->addData(['success' => false])->data;
