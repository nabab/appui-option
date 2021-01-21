<?php
/** @var $ctrl \bbn\mvc\controller */
$ctrl->data['root'] = $ctrl->plugin_url('appui-option').'/';
if ( !\defined('APPUI_OPTION_ROOT') ){
  define('APPUI_OPTION_ROOT', $ctrl->data['root']);
}
