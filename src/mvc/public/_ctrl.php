<?php
/** @var $ctrl \bbn\mvc\controller */
$ctrl->data['root'] = $ctrl->plugin_url('appui-options').'/';
if ( !\defined('APPUI_OPTIONS_ROOT') ){
  define('APPUI_OPTIONS_ROOT', $ctrl->data['root']);
}
