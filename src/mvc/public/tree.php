<?php

/** @var $ctrl \bbn\Mvc\Controller */

$id_appui = $ctrl->db->selectOne([
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
$id_root = $ctrl->inc->options->fromCode(false);

if ( $ctrl->inc->user->isAdmin() && !empty($ctrl->arguments) && ($ctrl->arguments[0] === 'typeTree') ){
  $ctrl->obj->data = ['id_cat' => !!$ctrl->post['appuiTree'] ? $id_appui : $id_root]; 
}
else{
  if ( !isset($ctrl->post['data']['id']) && !empty($id_root) ){
    $ctrl->addData([
      'cat' => $id_root,
      'is_dev' => $ctrl->inc->user->isDev(),
      'is_admin' => $ctrl->inc->user->isAdmin(),
      'lng' => [
        'problem_while_moving' => _("Sorry, a problem occured while moving this item, and although the tree says otherwise the item has not been moved."),
        'please_refresh' => _("Please refresh the tab in order to see the awful truth..."),
        'confirm_move' => _("Are you sure you want to move this option? Although the configuration will remain the same, the access path will be changed.")
      ]
    ]);
    $ctrl->obj->bcolor = '#1D481F';
    $ctrl->obj->fcolor = '#FFF';
    $ctrl->obj->icon = 'nf nf-mdi-file_tree';
    $ctrl->setUrl(APPUI_OPTION_ROOT . 'tree')->combo(_("Options' tree"), $ctrl->data);
  }
  else{
    /** @var \bbn\Appui\Option $o */
  /*  $o =& $ctrl->inc->options;
    $res = $o->fullOptions($ctrl->post['id']);
    $ctrl->obj->data = $res ?: [];*/
    $ctrl->obj = $ctrl->getObjectModel($ctrl->post['data']);
  }
}
