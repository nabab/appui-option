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

$ctrl->add_data([
   'cat' => $ctrl->inc->user->is_dev() ? $ctrl->inc->options->from_root_code($id) : $ctrl->inc->options->from_code($id)
  ]);

$ctrl->obj->data = $ctrl->data;
