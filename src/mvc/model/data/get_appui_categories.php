<?php
$perm =& $model->inc->perm;

return  $model->inc->options->map(function($a)use($perm){
  if ( $perm->readOption($a['id']) ){
    $a['write'] = $perm->writeOption($a['id']);
    return $a;
  }
}, $model->inc->options->fromCode('appui'));
