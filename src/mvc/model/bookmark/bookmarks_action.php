<?php
/**
   * What is my purpose?
   *
   **/

/** @var $model \bbn\Mvc\Model*/
use bbn\X;

$id_list = $model->inc->options->fromCode("list", "bookmarks", "note", "appui");
$id_cat = $model->inc->options->fromCode("cat", "bookmarks", "note", "appui");
$my_list = $model->inc->pref->getByOption($id_list);
$tree = $my_list ? $model->inc->pref->getTree($my_list['id']) : false;
$parents[] = [
  'text' => 'None',
  'value' => ''
];
$all_id = [];

$mapper = function ($ar) use (&$parents, &$mapper) {
  foreach ($ar as $a) {
    if (empty($a['url'])) {
      $parents[] = [
        'text' => $a['text'],
        'value' => $a['id']
      ];
      if (!empty($a['items'])) {
        $mapper($a['items']);
      }
    }
  }
};

$map = function ($ar) use (&$all_id, &$map) {
  foreach($ar as $a) {
    $all_id[] = [
      'text' => $a['text'],
      'value' => $a['id']
    ];
    if (!empty($a['items'])) {
      $map($a['items']);
    }
  }
};

$map($tree['items']);
$mapper($tree['items']);


return [
  'parents' => $parents,
  'allId' => $all_id
];