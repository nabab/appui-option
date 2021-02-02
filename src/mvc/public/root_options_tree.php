<?php
/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 25/10/17
 * Time: 16.16
 */

$id = false;

if( !empty($ctrl->post['id']) ){
  $id = $ctrl->post['id'];
}

$ctrl->addData([
   'cat' => $ctrl->inc->user->isDev() ? $ctrl->inc->options->fromRootCode($id) : $ctrl->inc->options->fromCode($id)
  ]);

$ctrl->obj->data = $ctrl->data;
