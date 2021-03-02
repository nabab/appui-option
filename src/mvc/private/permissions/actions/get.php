<?php

/** @var $ctrl \bbn\Mvc\Controller */

$ctrl->addData([
    'id' => $ctrl->post['id'] ?? null,
    'full' => $ctrl->post['full'] ?? false,
    'routes' => $ctrl->getRoutes()
  ])
  ->action();
