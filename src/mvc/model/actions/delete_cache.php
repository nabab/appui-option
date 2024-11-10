<?php

/** @var bbn\Mvc\Model $model */
//die(var_dump($model->inc->options->deleteCache($model->data['id'])));
$model->inc->options->deleteCache($model->data['id'] ?? null);
return ['success' => true];