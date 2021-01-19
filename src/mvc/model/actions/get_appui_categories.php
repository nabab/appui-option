<?php
$perm =& $model->inc->perm;
$appui =  $model->db->select_one('bbn_options', 'id', ['id_parent' => null, 'code'=> 'appui']);
//$id_root = $model->inc->options->from_root_code('appui');

return  $model->inc->options->map(function($a)use($perm){
      if ( $perm->read_option($a['id']) ){
        $a['write'] = $perm->write_option($a['id']);
        return $a;
      }
    }, $appui);
