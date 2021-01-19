<?php
/*
 * Describe what it does to show you're not that dumb!
 *
 **/

/** @var $ctrl \bbn\mvc\controller */
// Case for the whole page
if ( !isset($ctrl->post['id']) && empty($ctrl->arguments[0]) ){
  $id_perm = $ctrl->inc->perm->get_option_root();
  //$perm =& $ctrl->inc->perm;
  $ctrl->add_data([
    'cat' => $id_perm,
    'lng' => [
      'refresh_all_permissions' => _("Refresh all permissions"),
      'confirm_update_permissions' => _("Are you sure you wanna update all permissions? It might take a while..."),
      'total_updated' => _("A total of {0} permissions has been added"),
      'no_permission_updated' => _("No permission has been added")
    ],
    /*'tree' => $ctrl->inc->options->map(function($r)use($perm){
      if ( empty($r['icon']) ){
        if ( substr($r['code'], -1) === '/' ){
          $r['icon'] = 'nf nf-fa-folder';
        }
        else {
          $r['icon'] = 'nf nf-fa-file';
        }
      }
      if ( $perm->has($r['id']) ){
        $o = [
          'id' => $r['id'],
          'text' => $r['text'],
          'code' => $r['code'],
          'icon' => $r['icon'],
          'is_parent' => empty($r['num_children']) ? false : true
        ];
        if ( $o['is_parent'] ){
          $o['items'] = $r['items'];
        }
        return $o;
      }
    }, $id_perm, true)*/
  ]);
  $ctrl->combo(_("Permissions"), true);
}/*
else if (\bbn\str::is_integer($ctrl->post['id']) && empty($ctrl->arguments[0]) ){
  $ctrl->add_data([
    'id' => $ctrl->post['id'],
    'full' => isset($ctrl->post['full']) ? $ctrl->post['full'] : false,
    'routes' => $ctrl->get_routes()
  ]);
  $ctrl->obj->data = $ctrl->get_model();
}
else{
  $ctrl->add_data([
    'action' => $ctrl->arguments[0]
  ], $ctrl->post);
  $ctrl->obj->data = $ctrl->get_model();
}*/

else if ( !empty($ctrl->post['id']) && empty($ctrl->arguments[0]) ){
  $ctrl->obj->data = $ctrl
    ->add_data([
      'id' => $ctrl->post['id'],
      'full' => isset($ctrl->post['full']) ? $ctrl->post['full'] : false,
      'routes' => $ctrl->get_routes()
    ])
    ->get_model();
}
else{
  $ctrl->add_data([
    'action' => $ctrl->arguments[0]
  ], $ctrl->post);
  //$ctrl->obj->css = $ctrl->get_less();
  $ctrl->obj->data = $ctrl->get_model();
}