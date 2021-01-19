<?php
/*
 * Creates new entries in the permissions (options table) according to the public controllers' structure
 *
 **/

/** @var $ctrl \bbn\mvc\controller */

$ctrl->data['routes'] = $ctrl->get_routes();
$ctrl->obj->res = $ctrl->get_model();