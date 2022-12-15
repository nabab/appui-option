<?php
/* @var \bbn\Mvc\Model $model */
$r = $model->getModel(APPUI_OPTION_ROOT.'actions/get_info', ['id' => $model->data['id']]);
if (!empty($r['cfg']) && is_string($r['cfg'])) {
  $r['cfg'] = json_decode($r['cfg'], true);
}

$i81nCls = new \bbn\Appui\I18n($model->db);
$r['languages'] = $i81nCls->getPrimariesLangs();

return $r;
