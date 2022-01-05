<?php

/** @var $ctrl \bbn\Mvc\Controller */

use bbn\X;

$id_list = $ctrl->inc->options->fromCode("list", "bookmarks", "note", "appui");
$id_cat = $ctrl->inc->options->fromCode("cat", "bookmarks", "note", "appui");
$my_list = $ctrl->inc->pref->getByOption($id_list);
$tree = $my_list ? $ctrl->inc->pref->getTree($my_list['id']) : false;


$ctrl->action();