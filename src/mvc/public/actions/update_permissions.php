<?php
/*
 * Creates new entries in the permissions (options table) according to the public controllers' structure
 *
 **/

/** @var bbn\Mvc\Controller $ctrl */

$ctrl->data['routes'] = $ctrl->getRoutes();
$ctrl->obj->res = $ctrl->getModel();