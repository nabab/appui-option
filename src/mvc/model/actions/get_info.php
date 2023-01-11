<?php
if ( isset($model->inc->options) ){
  //info option for spliter
  if ( !empty($model->data['id']) ){
    $all = $model->inc->options->option($model->data['id']);
    $cfg = $model->inc->options->getCfg($model->data['id']);
    $aliases = $model->inc->options->getAliases($model->data['id']);
    $prefs = new \bbn\User\Preferences($model->db);
    $permissions = $model->inc->perm->getParentCfg($model->data['id']);
    $pub = array_map(
      function($a){
        if ( !empty($a['value']) && \bbn\Str::isJson($a['value']) ){
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
    /* $prefs = array_map(function($a){
      if ( !empty($a['value']) && (\bbn\Str::isJson($a['value'])) ){
        $a = array_merge(json_decode($a['value'], true), $a);
        unset($a['value']);
      }
      return $a;
    }, $model->db->rselectAll([
      'table' => 'bbn_users_options',
      'fields' => [],
      'where' => [
        'conditions' => [[
          'field' => 'id_option',
          'value' => $model->data['id']
        ], [
          'logic' => 'OR',
          'conditions' => [[
            'field' => 'id_user',
            'value' => $model->inc->user->getId()
          ], [
            'field' => 'id_group',
            'value' => $model->inc->user->getGroup()
          ]]
        ]]
      ]
    ])); */
    if ( 
      !empty($all) &&
      ($option = $model->inc->options->nativeOption($model->data['id']))
    ){
      if ( !empty($all['id_alias']) ){
        $option['alias'] = $model->inc->options->option($all['id_alias']);
      }
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
        'prefs' => $prefs->getAll($model->data['id']),
        'uprefs' => $prefs->getAllNotMine($model->data['id'])
      ];
    }
  }
}
return [
  'success' => false
];