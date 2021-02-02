<?php
$id_root = $model->inc->options->fromCode(false);
return [
  'is_dev' => $model->inc->user->isDev(),
  'root' => $model->data['root'],
  'id_root' => $id_root,
  'lng' => [
    'update_of_option_category' => _("Update of options' category"),
    'new_option_category' => _("New options' category"),
    'impossible_to_add_category' => _("Impossible to add the category"),
    'impossible_to_update_category' => _("Impossible to update the category"),
    'impossible_to_delete_category' => _("Impossible to delete the category"),
    'are_you_sure_to_delete_category' => _("Are you sure you want to delete this category and all its items"),
    'id' => _("ID"),
    'name' => _("Name"),
    'code' => _("Code"),
    'icon' => _("Icon"),
    'accessible' => _("Accessible"),
    'actions' => _("Actions"),
    'parent' => _("Parent"),
    'icon' => _("Icon"),
    'subcategories' => "#"
  ]
];
/*$perm =& $model->inc->perm;
$id_root = $model->inc->options->fromCode(false);
return [
  'is_dev' => $model->inc->user->isDev(),
  'root' => $model->data['root'],
  'id_root' => $id_root,
  'options' => $model->inc->options->map(function($a)use($perm){
      if ( $perm->readOption($a['id']) ){
        $a['write'] = $perm->writeOption($a['id']);
        return $a;
      }
    }, $id_root),
  'lng' => [
    'update_of_option_category' => _("Update of options' category"),
    'new_option_category' => _("New options' category"),
    'impossible_to_add_category' => _("Impossible to add the category"),
    'impossible_to_update_category' => _("Impossible to update the category"),
    'impossible_to_delete_category' => _("Impossible to delete the category"),
    'are_you_sure_to_delete_category' => _("Are you sure you want to delete this category and all its items"),
    'id' => _("ID"),
    'name' => _("Name"),
    'code' => _("Code"),
    'icon' => _("Icon"),
    'accessible' => _("Accessible"),
    'actions' => _("Actions"),
    'parent' => _("Parent"),
    'icon' => _("Icon"),
    'subcategories' => "#"
  ]
];*/
