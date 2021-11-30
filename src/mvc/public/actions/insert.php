<?php
/*
 * Describe what it does to show you're not that dumb!
 *
 **/

/** @var $ctrl \bbn\Mvc\Controller */
$ctrl->obj->success = false;

if ( isset($ctrl->post['id_parent']) ){
  if ( !empty($ctrl->post['source_children']) ){
    $tree = $ctrl->inc->options->fullTree($ctrl->post['source_children']);
    if ( isset($tree['items']) ){
      $ctrl->post['items'] = $tree['items'];
    }
    unset($ctrl->post['source_children']);
  }

  $cfg = $ctrl->inc->options->getCfg($ctrl->post['id_parent']);
  if (!empty($cfg['schema'])) {
    $schema = $cfg['schema'];
    foreach ( $ctrl->post as $i => $d ){
      if (
        (($idx = \bbn\X::find($schema, ['field' => $i])) !== null) &&
        isset($schema[$idx]['type']) &&
        (strtolower($schema[$idx]['type']) === 'json')
      ){
        $ctrl->post[$i] = json_decode($d, true);
      }
    }
  }

  if ( $id = $ctrl->inc->options->add($ctrl->post) ){
    $data = $ctrl->inc->options->nativeOption($id);
    if (!empty($data['id_alias'])) {
      $data['alias'] = $ctrl->inc->options->nativeOption($data['id_alias']);
    }
    $ctrl->obj->success = true;
    $ctrl->obj->data = $data;
  }
}