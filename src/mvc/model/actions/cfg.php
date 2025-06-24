<?php
if ($model->hasData(['id', 'cfg'])) {
  return [
    'success' => $model->data['cfg'] ? 
                $model->inc->options->setCfg($model->data['id'], $model->data['cfg'])
                : $model->inc->options->unsetCfg($model->data['id'])
  ];
}

