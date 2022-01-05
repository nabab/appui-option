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

return [
  'data' => $tree && $tree['items'] ? $tree['items'] : []
];