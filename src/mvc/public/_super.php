<?php
/** @var bbn\Mvc\Controller $ctrl */
$ctrl->data['root'] = $ctrl->pluginUrl('appui-option').'/';
if ( !\defined('APPUI_OPTION_ROOT') ){
  define('APPUI_OPTION_ROOT', $ctrl->data['root']);
}
