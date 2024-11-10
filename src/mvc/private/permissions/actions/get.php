<?php

/** @var bbn\Mvc\Controller $ctrl */

$ctrl->addData([
    'id' => $ctrl->post['id'] ?? null,
    'full' => $ctrl->post['full'] ?? false,
    'routes' => $ctrl->getRoutes()
  ])
  ->action();
