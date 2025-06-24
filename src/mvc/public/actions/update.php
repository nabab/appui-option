<?php
use bbn\X;

/** @var bbn\Mvc\Controller $ctrl */
unset($ctrl->data['root']);
$ctrl->action();
