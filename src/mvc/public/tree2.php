<?php
/*
 * Describe what it does to show you're not that dumb!
 *
 **/

/** @var $ctrl \bbn\mvc\controller */
if ( !isset($ctrl->post['id']) ){
  $ctrl->add_data([
    'cat' => $ctrl->inc->options->from_code(false),
    'is_dev' => $ctrl->inc->user->is_dev(),
    'lng' => [
      'problem_while_moving' => _("Sorry, a problem occured while moving this item, and although the tree says otherwise the item has not been moved."),
      'please_refresh' => _("Please refresh the tab in order to see the awful truth..."),
      'confirm_move' => _("Are you sure you want to move this option? Although the configuration will remain the same, the access path will be changed.")
    ]
  ]);
  $ctrl->obj->bcolor = '#1D481F';
  $ctrl->obj->fcolor = '#FFF';
  $ctrl->obj->icon = 'nf nf-fa-tree';
  $ctrl->combo(_("Options' tree"), $ctrl->data);
}
else{
  /** @var \bbn\appui\option $o */
/*  $o =& $ctrl->inc->options;
  $res = $o->full_options($ctrl->post['id']);
    $ctrl->obj->data = $res ?: [];*/
  $ctrl->obj = $ctrl->get_object_model($ctrl->post);
}