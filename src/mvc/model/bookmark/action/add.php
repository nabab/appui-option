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
$res = ["success" => false];
$parent = false;

if (!$my_list) {
  $model->inc->pref->add($id_list, []);
  $my_list = $model->inc->pref->getByOption($id_list);
}

//X::ddump($model->data, $model->data['id_parent']);

if (($tree['items']) /*&& ($model->data['url'] !== "")*/) {
  $tmp = $model->inc->pref->addBit($my_list['id'], [
    'text' => $model->data['title'],
    'url' => $model->data['url'] ?? null,
    'id_parent' => $model->data['id_parent'] ?: null,
    'cover' => $model->data['cover'] ?? null,
    'description' => $model->data['description'] ?? null
  ]);
  $res['success'] = true;
}

return $res;