<?php
/** @var $ctrl \bbn\Mvc\Controller */


/** @var bbn\Appui\Option $o */
$o =& $ctrl->inc->options;
// Option ID and option exists
$id = empty($ctrl->arguments[0]) ? $o->fromCode(false) : $ctrl->arguments[0];
if (!empty($id)) {
  if ($option = $o->option($id)) {
    // Does the user has the right to read this option's list?
    if ($ctrl->inc->perm->readOption($option['id'])) {
      $translation = new \bbn\Appui\I18n($ctrl->db);
      // Option's data + config
      $ctrl->addData($option)->addData(
        [
          'cfg' => $o->getCfg($option['id']),
          'languages' => $translation->getPrimariesLangs(),
          'parents' => [],
          'id_root_opt' => $o->fromCode(false)
          ]
      );
      //  die(\bbn\X::dump($ctrl->data['cfg']));
      if (!empty($ctrl->data['cfg']['id_root_alias'])) {
        $ctrl->data['cfg']['root_alias'] = $o->option($ctrl->data['cfg']['id_root_alias']);
        if (!empty($ctrl->data['cfg']['root_alias']['num_children'])
            && ($ch = $o->items($ctrl->data['cfg']['id_root_alias']))
        ) {
          $ctrl->data['cfg']['root_alias']['last_level'] = true;
          foreach ($ch as $c){
            if ($o->items($c)) {
              $ctrl->data['cfg']['root_alias']['last_level'] = false;
              break;
            }
          }

          if ($ctrl->data['cfg']['root_alias']['last_level']
              && ($last_level_children = $o->fullOptions($ctrl->data['cfg']['id_root_alias']))
          ) {
            \bbn\X::sortBy($last_level_children, 'text');
            $ctrl->data['cfg']['root_alias']['last_level_children'] = $last_level_children;
          }
        }
      }

      if (!empty($ctrl->data['cfg']['inherit_from'])) {
        $ctrl->data['cfg']['inherit_from_text'] = $o->text($ctrl->data['cfg']['inherit_from']);
      }

      // Does the user has the right to modify this option's list?
      $ctrl->data['cfg']['write'] = $ctrl->inc->perm->writeOption($option['id']);
      // List of parents
      $tmp = $ctrl->inc->options->parents($option['id']);
      foreach ($tmp as $t){
        if ($t !== $o->getRoot()) {
          $ctrl->data['parents'][] = [
            'value' => $t,
            'text' => $o->text($t)
          ];
        }
      }

      // Direct parent
      if (\count($ctrl->data['parents'])) {
        $ctrl->data['parent']      = $ctrl->data['parents'][0]['value'];
        $ctrl->data['parent_text'] = $ctrl->data['parents'][0]['text'];
      }

      if (empty($ctrl->data['tekname'])) {
        $ctrl->data['tekname'] = false;
      }

      $ctrl->data['is_dev'] = $ctrl->inc->user->isDev();

      /** @todo redo all the processs below */


      // Does this option has a special controller?
      $controller = false;
      if (!empty($ctrl->data['cfg']['controller'])) {
        $controller = $ctrl->data['cfg']['controller'];
      }

      // Adding the options' list
      /** @todo Paginate if not orderable & count > 100 */
      //$ctrl->addData(['options' => $ctrl->inc->options->fullOptions($ctrl->data['id'])]);
      if (!empty($ctrl->data['cfg']['show_value'])) {
        $ctrl->addData(['options' => $o->nativeOptions($ctrl->data['id'])]);
      }
      else {
        $ctrl->addData(['options' => $o->fullOptions($ctrl->data['id'])]);
      }
      


      /*if ( $controller ){
        $ctrl2 = $ctrl->add($controller, $ctrl->data, substr($controller, 0, 2) === './' ? false : true);
        $ctrl->obj = $ctrl2->get();
      }*/

      /** @todo From here we get a complete config telling us also which bits of the current code we use and which views from the plugin dir we should use */
      /*

      $ctrl->addData(['options' => $o->fullOptions($ctrl->data['id'])]);

      if ( !empty($ctrl->data['cfg']['controller']) ){
        $ctrl->addData($ctrl->getPluginModel($ctrl->data['cfg']['controller'], $this->data));
      }
      if ( !empty($ctrl->data['cfg']['model']) ){
        $ctrl->addData($ctrl->getPluginModel($ctrl->data['cfg']['model'], $this->data));
      }
      */

      $ctrl->obj->data = $ctrl->data;
      // Case of special controller
      $views = [];
      if (!empty($ctrl->data['cfg']['controller'])) {
        if ($model = $ctrl->getPluginModel($ctrl->data['cfg']['controller'], $ctrl->data)) {
          $ctrl->addData($model);
        }

        $ctrl->obj->data = $ctrl->data;
        $views           = $ctrl->getPluginViews($ctrl->data['cfg']['controller'], $ctrl->data, $ctrl->obj->data);
      }

      if (!empty($views['html'])) {
        echo $views['html'];
      }
      else{
        echo $ctrl->getView($ctrl->data);
      }

      if (!empty($views['js'])) {
        $ctrl->addScript($views['js']);
      }
      else{
        $ctrl->addJs(
          '',
          //empty($ctrl->data['cfg']['categories']) ? '' : './categories',
          $ctrl->obj->data
        );
      }

      if (!empty($views['css'])) {
        echo $views['css'];
      }

      if (empty($ctrl->obj->title)) {
        $ctrl->setTitle($ctrl->data['text']);
        $ctrl->obj->icon = empty($option['icon']) ? 'nf nf-fa-cog' : $option['icon'];
      }
    }
    else{
      $ctrl->obj->error = _("You don't have the permission to access this option");
    }
  }

  if (!isset($ctrl->obj->url) && !empty($id)) {
    $ctrl->obj->url = APPUI_OPTION_ROOT.'list/'.$id;
  }
}
