<?php
/* @var \bbn\Mvc\Model $model */
if ( !empty($model->data['id']) ){
  $res = [];
  $tree = [];
  $result = 0;
  $tables = $model->db->getForeignKeys('id', 'bbn_options');
  foreach( $tables as $table => $cols ){
    foreach ( $cols as $col ){
      if ( $c = $model->db->count($table, [$col => $model->data['id'] ]) ){
        if ( !isset($res[$table]) ){
          $res[$table] = [];
        }
        $res[$table][$col] = $c;
      }
    }
  }
  if ( !empty($res) ){
    foreach ( $res as $tab =>  $val ){
      $partial = 0;
      $ele = [];
      $ele['text'] = $tab;
      $ele['num'] = count($res[$tab]);
      $ele['numChildren'] = count($res[$tab]);
      $ele['icon'] = 'nf nf-fa-table';
      $ele['items'] = [];
      foreach ( $res[$tab] as $ix => $num ){
        $partial = $partial + $num;
        $item = [];
        $item['text'] = $ix . " ( $num )";
        $item['num'] = 0;
        $item['numChildren'] = 0;
        $item['icon'] = 'nf nf-fa-columns';
        $ele["items"][] = $item;
      }
      $result += $partial;
      $ele['text'] .= " ( $partial )";
      $tree[] = $ele;
    }
  }
  return[
    'success' => true,
    'tables' => $res,
    'tree' => $tree,
    'totalReferences' => $result
  ];
}
return [
  'success' => false
];