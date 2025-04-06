<?php

use bbn\X;

/** @var bbn\Mvc\Model $model */
if ($model->hasData('id', true)) {
  $res = ['success' => false];
  
  $success = 0;
  if ( !isset($model->data['history']) ){
    $success += (int)$model->inc->options->remove($model->data['id']);
  }
  else if ( !empty($model->data['history']) && $model->inc->user->isAdmin()){
    if (!empty($model->inc->options->items($model->data['id']))) {
      bbn\Appui\History::disable();
      $full = $model->inc->options->fullTree($model->data['id']);
      $db = $model->db;
      $remove_history = function ($arr, $db) use (&$remove_history): int
      {
        $num = 0;
        if (!empty($arr['id'])) {
          $num += (int)bbn\Appui\History::delete($arr['id']);
          //have to manually remove the row from bbn_history because it's not automatic basing on the configuration of the table bbn_histort_uids
          $db->delete('bbn_history', ['uid' => $arr['id']], true);
        }

        if( !empty($arr['items']) ){
          foreach($arr['items'] as $item ){
            $num += (int)$remove_history($item, $db);
          }
        }

        return $num;
      };
      
      $success = $remove_history($full, $db);
      bbn\Appui\History::enable();
    }
    else{
      $success = (int)bbn\Appui\History::delete($model->data['id']);
    }

    $model->inc->options->deleteCache();
  }  

  $res['success'] = $success;
  return $res;
}
