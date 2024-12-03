<?php
$perm =& $model->inc->perm;
$id_root = $model->inc->options->fromCode(false);
return  $model->inc->options->map(function($a)use($perm){
      if ( $perm->readOption($a['id']) ){
        $a['write'] = $perm->writeOption($a['id']);
        return $a;
      }
    }, $id_root);
