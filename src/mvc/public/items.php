<?php
/*
 * Describe what it does to show you're not that dumb!
 *
 **/

/** @var $ctrl \bbn\mvc\controller */
$perm =& $ctrl->inc->perm;
$o =& $ctrl->inc->options;
$cf = $o->get_class_cfg();
$c = $cf['arch']['options'];
$ctrl->data['categories'] = $o->map_cfg(function($a) use($perm, $c){
  if ( $perm->read_option($a[$c['id']]) ){
    $a['has_desc'] = !empty($a[$c['cfg']]['desc']);
    if ( $a['has_desc'] ){
      $a['desc'] = nl2br($a[$c['cfg']]['desc']);
    }
    return $a;
  }
}, false);

$ctrl->obj->icon = 'nf nf-fa-cogs';
$ctrl->combo("Categories", true);