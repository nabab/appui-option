<?php
/** @var $ctrl \bbn\mvc\controller */


/** @var bbn\appui\option $o */
$o =& $ctrl->inc->options;
// Option ID and option exists
$id = empty($ctrl->arguments[0]) ? $o->from_code(false) : $ctrl->arguments[0];
if ( !empty($id) ){
  if ( $option = $o->option($id) ){
    // Does the user has the right to read this option's list?
    if ( $ctrl->inc->perm->read_option($option['id']) ){
      $translation = new \bbn\appui\i18n($ctrl->db);
      // Option's data + config
      $ctrl
        ->add_data($option)
        ->add_data([
          'cfg' => $o->get_cfg($option['id']),
          'languages' => $translation->get_primaries_langs(),
          'parents' => [],
          'id_root_opt' => $o->from_code(false)
        ]);
      //  die(\bbn\x::dump($ctrl->data['cfg']));
        if ( !empty($ctrl->data['cfg']['id_root_alias']) ){
          $ctrl->data['cfg']['root_alias'] = $o->option($ctrl->data['cfg']['id_root_alias']);
          if (
            !empty($ctrl->data['cfg']['root_alias']['num_children'])  &&
            ($ch = $o->items($ctrl->data['cfg']['id_root_alias']))
          ){
            $ctrl->data['cfg']['root_alias']['last_level'] = true;
            foreach ( $ch as $c ){
              if ( $o->items($c) ){
                $ctrl->data['cfg']['root_alias']['last_level'] = false;
                break;
              }
            }
            if (
              $ctrl->data['cfg']['root_alias']['last_level'] &&
              ($last_level_children = $o->full_options($ctrl->data['cfg']['id_root_alias']))
            ){
              \bbn\x::sort_by($last_level_children, 'text');
              $ctrl->data['cfg']['root_alias']['last_level_children'] = $last_level_children;
            }
          }
        }

      if ( !empty($ctrl->data['cfg']['inherit_from']) ){
        $ctrl->data['cfg']['inherit_from_text'] = $o->text($ctrl->data['cfg']['inherit_from']);
      }
      // Does the user has the right to modify this option's list?
      $ctrl->data['cfg']['write'] = $ctrl->inc->perm->write_option($option['id']);
      // List of parents
      $tmp = $ctrl->inc->options->parents($option['id']);
      foreach ( $tmp as $t ){
        if ( $t !== $o->get_root() ){
          $ctrl->data['parents'][] = [
            'value' => $t,
            'text' => $o->text($t)
          ];
        }
      }
      // Direct parent
      if ( \count($ctrl->data['parents']) ) {
        $ctrl->data['parent'] = $ctrl->data['parents'][0]['value'];
        $ctrl->data['parent_text'] = $ctrl->data['parents'][0]['text'];
      }

      if ( empty($ctrl->data['tekname']) ){
        $ctrl->data['tekname'] = false;
      }
      $ctrl->data['is_dev'] = $ctrl->inc->user->is_dev();

      /** @todo redo all the processs below */


      // Does this option has a special controller?
      $controller = false;
      if ( !empty($ctrl->data['cfg']['controller']) ){
        $controller = $ctrl->data['cfg']['controller'];
      }

      // Adding the options' list
      /** @todo Paginate if not orderable & count > 100 */
      //$ctrl->add_data(['options' => $ctrl->inc->options->full_options($ctrl->data['id'])]);
      $options = $o->native_options($ctrl->data['id']);
      $ctrl->add_data(['options' => is_array($options) ? array_map(function($op) use($o){
        if ( !empty($op['id_alias']) && \bbn\str::is_uid($op['id_alias']) ){
          $op['alias'] = $o->native_option($op['id_alias']);
        }
        return $op;
      }, $options) : []]);


      /*if ( $controller ){
        $ctrl2 = $ctrl->add($controller, $ctrl->data, substr($controller, 0, 2) === './' ? false : true);
        $ctrl->obj = $ctrl2->get();
      }*/

      /** @todo From here we get a complete config telling us also which bits of the current code we use and which views from the plugin dir we should use */
      /*

      $ctrl->add_data(['options' => $o->full_options($ctrl->data['id'])]);

      if ( !empty($ctrl->data['cfg']['controller']) ){
        $ctrl->add_data($ctrl->get_plugin_model($ctrl->data['cfg']['controller'], $this->data));
      }
      if ( !empty($ctrl->data['cfg']['model']) ){
        $ctrl->add_data($ctrl->get_plugin_model($ctrl->data['cfg']['model'], $this->data));
      }
      */

      $ctrl->obj->data = $ctrl->data;
      // Case of special controller
      $views = [];
      if ( !empty($ctrl->data['cfg']['controller']) ){
        if ( $model = $ctrl->get_plugin_model($ctrl->data['cfg']['controller'], $ctrl->data) ){
          $ctrl->add_data($model);
        }
        $ctrl->obj->data = $ctrl->data;
        $views = $ctrl->get_plugin_views($ctrl->data['cfg']['controller'], $ctrl->data, $ctrl->obj->data);
      }
      if (!empty($views['html'])) {
        echo $views['html'];
      }
      else{
        echo $ctrl->get_view($ctrl->data);
      }
      if ( !empty($views['js']) ){
        $ctrl->add_script($views['js']);
      }
      else{
        $ctrl->add_js('',
          //empty($ctrl->data['cfg']['categories']) ? '' : './categories',
          $ctrl->obj->data
        );
      }
      if ( !empty($views['css']) ){
        echo $views['css'];
      }
      if ( empty($ctrl->obj->title) ){
        $ctrl->set_title($ctrl->data['text']);
        $ctrl->obj->icon = empty($option['icon']) ? 'nf nf-fa-cog' : $option['icon'];
      }

    }
    else{
      $ctrl->obj->error = _("You don't have the permission to access this option");
    }
  }
  if ( !isset($ctrl->obj->url) && !empty($id) ){
    $ctrl->obj->url = $ctrl->data['root'].'list/'.$id;
  }
}
