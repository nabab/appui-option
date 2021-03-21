<?php
if ($model->hasData(['id', 'cfg'], true)) {
  return ['res' => $model->inc->options->setCfg($model->data['id'], $model->data['cfg'])];
}

