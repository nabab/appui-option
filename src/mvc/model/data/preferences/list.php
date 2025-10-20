<?php

use bbn\Appui\Grid;

/** @var bbn\Mvc\Model $model */
if ($model->hasData(['limit', 'data'], true) && isset($model->data['data']['id'])) {
  $where = [
    'conditions' => [
      [
        'field' => 'bbn_users_options.id_option',
        'operator' => 'eq',
        'value' => $model->data['data']['id']
      ]
    ]
  ];
  if (!$model->inc->user->isAdmin()) {
    $where['conditions'][] = [
      'logic' => 'OR',
      'conditions' => [
        [
          'field' => 'bbn_users_options.id_user',
          'operator' => 'eq',
          'value' => $model->inc->user->getId()
        ],
        [
          'field' => 'bbn_users_options.id_group',
          'operator' => 'eq',
          'value' => $model->inc->user->getIdGroup()
        ],
        [
          'field' => 'bbn_users_options.public',
          'operator' => 'eq',
          'value' => 1
        ]
      ]
    ];
  }
  $grid = new Grid($model->db, $model->data, [
    'table' => 'bbn_users_options',
    'fields' => [
      'bbn_users_options.id',
      'bbn_users_options.id_option',
      'bbn_users_options.id_alias',
      'bbn_users_options.public',
      'id_link' => 'IFNULL(aliases.id_link, bbn_users_options.id_link)',
      'text' => 'IFNULL(aliases.text, bbn_users_options.text)',
      'id_user' => 'IFNULL(aliases.id_user, bbn_users_options.id_user)',
      'id_group' => 'IFNULL(aliases.id_group, bbn_users_options.id_group)',
      'public' => 'IFNULL(aliases.public, bbn_users_options.public)'
    ],
    'join' => [
      [
        'table' => 'bbn_users_options',
        'alias' => 'aliases',
        'type' => 'left',
        'on' => [
          'conditions' => [
            [
              'field' => 'aliases.id',
              'operator' => '=',
              'exp' => 'bbn_users_options.id_alias'
            ]
          ]
        ]
      ]
    ],
    'where' => $where
  ]);
  if ($grid->check()) {
    $data = $grid->getDatatable(true);
    $id_perm = $model->inc->options->fromCode('permission', 'appui');
    foreach ($data['data'] as $i => $d) {
      $data['data'][$i]['permission'] = $model->inc->options->isParent($d['id_option'], $id_perm);
    }
    $data['id_perm'] = $id_perm;
    return $data;
  }
}
return [];
