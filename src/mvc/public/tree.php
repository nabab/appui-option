<?php
/*
 * Describe what it does to show you're not that dumb!
 *
 **/

/** @var $ctrl \bbn\mvc\controller */

$id_appui = $ctrl->db->select_one([
  'table' => 'bbn_options',
  'fields' => ['id'],
  'where' => [
    'conditions' => [[
      'field' => 'id_parent',
      'operator' => 'isnull'
    ], [
      'field' => 'code',
      'value' => 'appui'
    ]]
  ]
]);
$id_root = $ctrl->inc->options->from_code(false);

if ( $ctrl->inc->user->is_admin() && !empty($ctrl->arguments) && ($ctrl->arguments[0] === 'typeTree') ){
  $ctrl->obj->data = ['id_cat' => !!$ctrl->post['appuiTree'] ? $id_appui : $id_root]; 
}
else{
  if ( !isset($ctrl->post['data']['id']) && !empty($id_root) ){
    $ctrl->add_data([
      'cat' => $id_root,
      'is_dev' => $ctrl->inc->user->is_dev(),
      'is_admin' => $ctrl->inc->user->is_admin(),
      'lng' => [
        'problem_while_moving' => _("Sorry, a problem occured while moving this item, and although the tree says otherwise the item has not been moved."),
        'please_refresh' => _("Please refresh the tab in order to see the awful truth..."),
        'confirm_move' => _("Are you sure you want to move this option? Although the configuration will remain the same, the access path will be changed.")
      ]
    ]);
    $ctrl->obj->bcolor = '#1D481F';
    $ctrl->obj->fcolor = '#FFF';
    $ctrl->obj->icon = 'nf nf-mdi-file_tree';
    $ctrl->set_url(APPUI_OPTIONS_ROOT . 'tree')->combo(_("Options' tree"), $ctrl->data);
  }
  else{
    /** @var \bbn\appui\options $o */
  /*  $o =& $ctrl->inc->options;
    $res = $o->full_options($ctrl->post['id']);
    $ctrl->obj->data = $res ?: [];*/
    $ctrl->obj = $ctrl->get_object_model($ctrl->post['data']);
  }
}
