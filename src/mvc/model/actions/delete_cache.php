<?php
/*
 * Describe what it does!
 *
 **/

/** @var $model \bbn\mvc\model*/
//die(var_dump($model->inc->options->delete_cache($model->data['id'])));
$model->inc->options->delete_cache($model->data['id'] ?? null);
return ['success' => true];