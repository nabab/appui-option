<?php
$perm =& $model->inc->perm;
$appui =  $model->db->selectOne('bbn_options', 'id', ['id_parent' => null, 'code'=> 'appui']);
//$id_root = $model->inc->options->fromRootCode('appui');

return  $model->inc->options->map(function($a)use($perm){
      if ( $perm->readOption($a['id']) ){
        $a['write'] = $perm->writeOption($a['id']);
        return $a;
      }
    }, $appui);
