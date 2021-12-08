<?php

/** @var $ctrl \bbn\Mvc\Controller */
$perm =& $ctrl->inc->perm;
$o =& $ctrl->inc->options;
$cf = $o->getClassCfg();
$c = $cf['arch']['options'];
$ctrl->data['categories'] = $o->mapCfg(function($a) use($perm, $c){
  if ( $perm->readOption($a[$c['id']]) ){
    $a['has_desc'] = !empty($a[$c['cfg']]['desc']);
    if ( $a['has_desc'] ){
      $a['desc'] = nl2br($a[$c['cfg']]['desc']);
    }
    return $a;
  }
}, false);

$ctrl->obj->icon = 'nf nf-fa-cogs';
$ctrl->combo("Categories", true);