<?php
$perm =& $model->inc->perm;
$id_root = $model->inc->options->from_code(false);
return  $model->inc->options->map(function($a)use($perm){
      if ( $perm->read_option($a['id']) ){
        $a['write'] = $perm->write_option($a['id']);
        return $a;
      }
    }, $id_root);
