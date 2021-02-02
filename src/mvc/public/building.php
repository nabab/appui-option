<?php
if ( !isset($ctrl->arguments[0]) ){
  $ctrl->addData([
    'cat' => '0',
    'is_dev' => $ctrl->inc->user->isDev(),
    'lng' => [
      'problem_while_moving' => _("Sorry, a problem occured while moving this item, and although the tree says otherwise the item has not been moved."),
      'please_refresh' => _("Please refresh the tab in order to see the awful truth..."),
      'confirm_move' => _("Are you sure you want to move this option? Although the configuration will remain the same, the access path will be changed.")
    ]
  ]);
  $ctrl->combo(_("building"), $ctrl->data);
}
else{
  /** @var \bbn\Appui\Option $o */
  $o =& $ctrl->inc->options;
  $res = $o->fullOptionsCfg($ctrl->arguments[0]);
  $res2 = $res;
  //die(\bbn\X::hdump($res2));
  $ctrl->obj->data = $res2 ?: [];
}