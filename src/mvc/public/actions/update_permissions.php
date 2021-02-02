<?php
/*
 * Creates new entries in the permissions (options table) according to the public controllers' structure
 *
 **/

/** @var $ctrl \bbn\Mvc\Controller */

$ctrl->data['routes'] = $ctrl->getRoutes();
$ctrl->obj->res = $ctrl->getModel();