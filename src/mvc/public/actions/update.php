<?php
use bbn\X;

/** @var $ctrl \bbn\Mvc\Controller */
$ctrl->obj->success = false;
if ( isset($ctrl->post['text'], $ctrl->post['id']) ){
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
          (($idx = X::find($schema, ['field' => $i])) !== null) &&
          isset($schema[$idx]['type']) &&
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
