<?php
use bbn\X;
/* @var bbn\Mvc\Model $model */
$r = $model->getModel($model->pluginUrl('appui-option') . '/data/get_info', ['id' => $model->data['id']]);
if (!empty($r['success'])) {
  if (!empty($r['cfg']) && is_string($r['cfg'])) {
    $r['cfg'] = json_decode($r['cfg'], true);
  }

  $i18nCls = new \bbn\Appui\I18n($model->db);
  if ($r['option']['text']) {
    $r['languages'] = $i18nCls->getPrimariesLangs();
    if (($t = $model->getModel(APPUI_OPTION_ROOT.'data/text', $model->data))
      && !empty($t['success'])
    ) {
      $r['option']['text'] = $t['text'];
      $r['translations'] = $t['translations'];
    }
  }
}

return $r;
