<?php
use bbn\X;

/** @var bbn\Mvc\Controller $ctrl */
$ctrl->obj->success = false;
if ( isset($ctrl->post['id']) && (!empty($ctrl->post['id_alias']) || !empty($ctrl->post['text'])) ){
  $cfg = $ctrl->inc->options->getParentCfg($ctrl->post['id']);
  if (!empty($cfg['schema'])) {
    if (is_array($cfg['schema'])) {
      $schema = $cfg['schema'];
    }
    elseif (is_string($cfg['schema'])) {
      $schema = json_decode($cfg['schema'], true);
    }

    if (!empty($schema)) {
      foreach ( $ctrl->post as $i => $d ){
        if (
          (($idx = X::search($schema, ['field' => $i])) !== null) &&
          isset($schema[$idx]['type']) &&
          is_string($d) &&
          (strtolower($schema[$idx]['type']) === 'json')
        ){
          $ctrl->post[$i] = json_decode($d, true);
        }
      }
    }
  }

  if ( $ctrl->obj->res = $ctrl->inc->options->set($ctrl->post['id'], $ctrl->post) ){
    $ctrl->obj->success = true;
    $ctrl->obj->data = X::mergeArrays($ctrl->inc->options->nativeOption($ctrl->post['id']), $ctrl->inc->options->option($ctrl->post['id']));
    //$ctrl->obj->data = $ctrl->inc->options->nativeOption($ctrl->post['id']);
    $ctrl->obj->post = $ctrl->post;
  }
}
