<?php
if (isset($model->inc->options)) {
  /** @var bbn\Appui\Option */
  $o = $model->inc->options;
  //info option for spliter
  if (!empty($model->data['id'])) {
    $all = $o->option($model->data['id']);
    $cfg = $o->getCfg($model->data['id']);
    $aliases = $o->getAliases($model->data['id']);
    $prefs = new \bbn\User\Preferences($model->db);
    $permissions = $model->inc->perm->getParentCfg($model->data['id']);
    $pub = array_map(
      function ($a) {
        if (!empty($a['value']) && \bbn\Str::isJson($a['value'])) {
          $a = array_merge(json_decode($a['value'], true), $a);
          unset($a['value']);
        }
        return $a;
      },
      $model->db->rselectAll('bbn_users_options', [], [
        'id_option' => $model->data['id'],
        'public' => 1
      ])
    );

    if (
      !empty($all) &&
      ($option = $o->nativeOption($model->data['id']))
    ) {
      if (!empty($all['id_alias'])) {
        $option['alias'] = $o->option($all['id_alias']);
      }

      $parents = $o->parents($model->data['id']);
      return [
        'success' => true,
        'info' => json_encode($all),
        'option' => $option,
        'cfg' => json_encode($cfg),
        'cfg_inherit_from_text' => !empty($cfg['inherit_from']) ? $model->inc->options->text($cfg['inherit_from']) : '',
        'aliases' => $aliases,
        'permissions' => $permissions,
        'id_permission' => $model->inc->perm->optionToPermission($model->data['id']),
        'public' => $pub,
        'parents' => $parents,
        'prefs' => $prefs->getAll($model->data['id']),
        'isTemplate' => $o->isInTemplate($model->data['id']),
        'isApp' => ($option['code'] !== 'templates') && ($option['id_parent'] === $model->inc->options->getRoot()),
        'parent' => $o->parent($model->data['id']),
        'template' => $o->getOptionTemplate($model->data['id']),
        'parentTemplate' => $o->parentTemplate($model->data['id']),
        'parentPlugin' => $o->getParentPlugin($model->data['id']),
        'appId' => array_slice($parents, -2, 1)[0]
      ];
    }
  }
}

return [
  'success' => false
];
