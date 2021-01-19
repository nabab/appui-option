<?php
$grid = new \bbn\appui\grid($model->db, $model->data, [
  'table' => 'bbn_options',
  'fields' => [
    'id',
    'id_alias',
    'text',
    'code',
    'parent' =>  "CONCAT(parent_option.text, ' (', parent_option.code, ') ')",    
  ],
  'join' => [[
    'table' => 'bbn_options',
    'alias' => 'parent_option',  
    'type' =>'left', 
    'on' => [
      'conditions' => [[
        'field' => 'parent_option.id_parent',
        'exp' => 'bbn_options.id',        
      ]]
    ]
  ]],
  'order' => [
    'field' => 'bbn_options.text',
    'dir' => 'ASC'
  ],
]);
if ( $grid->check() ){
  return $grid->get_datatable();
}