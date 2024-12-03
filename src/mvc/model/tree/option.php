<?php
/* @var \bbn\Mvc\Model $model */
$r = $model->getModel(APPUI_OPTION_ROOT.'data/get_info', ['id' => $model->data['id']]);
if (!empty($r['cfg']) && is_string($r['cfg'])) {
  $r['cfg'] = json_decode($r['cfg'], true);
}

$i81nCls = new \bbn\Appui\I18n($model->db);
$r['languages'] = $i81nCls->getPrimariesLangs();
if (($t = $model->getModel(APPUI_OPTION_ROOT.'data/text', $model->data))
  && !empty($t['success'])
) {
  $r['option']['text'] = $t['text'];
  $r['translations'] = $t['translations'];
}

return $r;
