<?php
if ($model->hasData('id', true)) {
  if ($locale = $model->inc->options->findI18nById($model->data['id'])) {
    $i81nCls = new \bbn\Appui\I18n($model->db);
    $text = $model->inc->options->rawtext($model->data['id']);
    return [
      'success' => true,
      'text' => $text,
      'translations' => $i81nCls->getNumTranslations($text, $locale)
    ];
  }
}
return ['success' => false];
