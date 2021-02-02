<?php

if ( isset($ctrl->post['id']) ){
  $ctrl->obj->success = false;
  
  if ( !isset($ctrl->post['history']) ){
    $success = $ctrl->inc->options->remove($ctrl->post['id']);
  }
  else if ( !empty($ctrl->post['history']) && $ctrl->inc->user->isAdmin()){
   
    \bbn\Appui\History::disable();
    if( !empty($ctrl->post['num_children']) ){
      $full = $ctrl->inc->options->fullTree($ctrl->post['id']);
      $db = $ctrl->db;
      function remove_history($arr, $db){
        if(!empty($arr['id'])){
          \bbn\Appui\History::delete($arr['id']);
          //have to manually remove the row from bbn_history because it's not automatic basing on the configuration of the table bbn_histort_uids
          $db->delete('bbn_history', ['uid' => $arr['id']], true);
        }
        if( !empty($arr['items']) ){
          foreach($arr['items'] as $item ){
            remove_history($item, $db);            
          }
        }
        return true;
      };
      
      $success = remove_history($full, $db);
    }
    else{
      $success = \bbn\Appui\History::delete($ctrl->post['id']);
    }
    \bbn\Appui\History::enable();
    $ctrl->inc->options->deleteCache();
   
  }  
  $ctrl->obj->success = $success;
}
