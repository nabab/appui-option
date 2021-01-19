<?php
if ( !empty($model->data['id']) ){
  $res = [];
  $tables = $model->db->get_foreign_keys('id', 'bbn_options');
  $t = 0;
  foreach( $tables as $table => $cols ){
    foreach ( $cols as $col ){
      if ( $c = $model->db->count($table, [$col => $model->data['id'] ]) ){
        $t++;
        if ( !isset($res[$table]) ){
          $res[$table] = [];
        }
        $res[$table][$col] = $c;
      }
    }
  }
  if ( !empty($res) ){
    $tree = [];
    $ele = [
      'text' => '',
      'items' => [],
      'num' => 0,
      'numChildren' => 0
    ];
    $result = 0;
    $item = [];

    foreach($res as $tab =>  $val ){
      $ele['text'] = $tab;
      $ele['num'] = count($res[$tab]);
      $ele['numChildren'] = count($res[$tab]);
      $ele['icon'] = 'nf nf-fa-table';
      $ele['items'] = [];
      $partial = 0;
      foreach( $res[$tab] as $ix => $num ){
        $partial = $partial + $num;
        $result = $result + $num;
        $item['text'] = $ix." ( ".$num." )";
        $item['num'] = 0;
        $item['numChildren'] = 0;
        $item['icon'] = 'nf nf-fa-columns';
        array_push($ele["items"], $item);
      }
      $ele['text'] .= " ( ". $partial ." )";
      array_push($tree, $ele);
    }

    if ( !empty($tree) && !empty($result) ){
      return[
        'success' => true,
        'tables' => $res,
        'tree' => $tree,
        'totalReferences' => $result
      ];
    }
  }
  else if ( empty($t) ){
    return [
      'success' => true
    ];
  }   
}
return [
  'success' => false
];
