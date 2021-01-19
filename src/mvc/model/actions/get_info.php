<?php
if ( isset($model->inc->options) ){
  //info option for spliter
  if ( !empty($model->data['id']) ){
    $all = $model->inc->options->option($model->data['id']);
    $cfg = $model->inc->options->get_cfg($model->data['id']);
    $aliases = $model->inc->options->get_aliases($model->data['id']);
    $prefs = new \bbn\user\preferences($model->db);
    $pub = array_map(function($a){
      if ( !empty($a['value']) && \bbn\str::is_json($a['value']) ){
        $a = array_merge(json_decode($a['value'], true), $a);
        unset($a['value']);
      }
      return $a;
    }, $model->db->rselect_all('bbn_users_options', [], [
      'id_option' => $model->data['id'],
      'public' => 1
    ]));
    /* $prefs = array_map(function($a){
      if ( !empty($a['value']) && (\bbn\str::is_json($a['value'])) ){
        $a = array_merge(json_decode($a['value'], true), $a);
        unset($a['value']);
      }
      return $a;
    }, $model->db->rselect_all([
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
            'value' => $model->inc->user->get_id()
          ], [
            'field' => 'id_group',
            'value' => $model->inc->user->get_group()
          ]]
        ]]
      ]
    ])); */
    if ( 
      !empty($all) &&
      ($option = $model->inc->options->native_option($model->data['id']))
    ){
      if ( !empty($all['id_alias']) ){
        $option['alias'] = $model->inc->options->option($all['id_alias']);
      }
      return[
        'success' => true,
        'info' => json_encode($all),
        'option' => $option,
        'cfg' => json_encode($cfg),
        'aliases' => $aliases,
        'public' => $pub,
        'prefs' => $prefs->get_all($model->data['id']),
        'uprefs' => $prefs->get_all_not_mine($model->data['id'])
      ];
    }
  }
}
return [
  'success' => false
];