<?php

/** @var $model \bbn\Mvc\Model*/
//die(var_dump($model->inc->options->deleteCache($model->data['id'])));
$model->inc->options->deleteCache($model->data['id'] ?? null);
return ['success' => true];