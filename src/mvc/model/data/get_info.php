<?php
use bbn\X;

if (isset($model->inc->options)) {
  /** @var bbn\Appui\Option */
  $o = $model->inc->options;
  //info option for spliter
  if (!empty($model->data['id'])) {
    $all = $o->option($model->data['id']);
    if (
      !empty($all) &&
      ($option = $o->nativeOption($model->data['id']))
    ) {
      $cfg = $o->getCfg($model->data['id']) ?: [];
      if ($all['id_alias']) {
        $realCfg = $model->db->selectOne('bbn_options', 'cfg', ['id' => $all['id']]);
        if (is_string($realCfg)) {
          $realCfg = json_decode($realCfg, true);
        }
      }
      else {
        $realCfg = $cfg;
      }

      $aliases = $o->getAliases($model->data['id']);
      $prefs = new \bbn\User\Preferences($model->db);
      $permissions = $model->inc->perm->getParentCfg($model->data['id']);
      $pub = array_map(
        function ($a) {
          if (!empty($a['value']) && \bbn\Str::isJson($a['value'])) {
            $a = array_merge(json_decode($a['value'], true), $a);
            unset($a['value']);
          }
          return $a;
        },
        $model->db->rselectAll('bbn_users_options', [], [
          'id_option' => $model->data['id'],
          'public' => 1
        ])
      );

      if (!empty($all['id_alias'])) {
        $option['alias'] = $o->option($all['id_alias']);
      }

      $template = null;
      $idParentTemplate = $o->getParentTemplateId($model->data['id']);
      $isInTemplate = (bool)$idParentTemplate;
      $isTemplate = $idParentTemplate === $model->data['id'];
      $usedTemplate = null;
      if ($isInTemplate) {
        $template = $o->option($idParentTemplate);
      }
      elseif ($usedTemplate = $o->usedTemplate($model->data['id'])) {
        $template = $o->option($usedTemplate);
      }

      $plugin = null;
      if ($isPlugin = $option['id_alias'] === $o->getPluginTemplateId()) {
        $suboptions = $o->fullOptions($model->data['id']);
        $plugin = [
          'options' => X::getField($suboptions, ['id_alias' => $o->getOptionsTemplateId()], 'id'),
          'plugins' => X::getField($suboptions, ['id_alias' => $o->getPluginsTemplateId()], 'id'),
          'permissions' => X::getField($suboptions, ['id_alias' => $o->getPermissionsTemplateId()], 'id'),
          'templates' => X::getField($suboptions, ['id_alias' => $o->getTemplatesTemplateId()], 'id'),
        ];
      }

      $pcfg = $o->getParentCfg($model->data['id']);
      $parents = $o->parents($model->data['id']);
      $breadcrumb = array_reverse(array_map(function($a) use (&$o) {
        return $o->option($a);
      }, $parents));
      array_shift($breadcrumb);
      array_push($breadcrumb, $option);
      return [
        'success' => true,
        'value' => $option['value'],
        'info' => json_encode($all),
        'option' => $pcfg['show_value'] ? $option : $all,
        'cfg' => $cfg,
        'realCfg' => $realCfg,
        'parentCfg' => $pcfg,
        'cfg_inherit_from_text' => !empty($cfg['inherit_from']) ? $model->inc->options->text($cfg['inherit_from']) : '',
        'aliases' => $aliases,
        'permissions' => $permissions,
        'id_permission' => $model->inc->perm->optionToPermission($model->data['id']),
        'public' => $pub,
        'parents' => $parents,
        'breadcrumb' => $breadcrumb,
        'prefs' => $prefs->getAll($model->data['id']),
        'isPlugin' => $isPlugin,
        'plugin' => $plugin,
        'isSubplugin' => $option['id_alias'] === $o->getSubpluginTemplateId(),
        'isApp' => ($option['code'] !== 'templates') && ($option['id_parent'] === $model->inc->options->getRoot()),
        'parent' => $o->parent($model->data['id']),
        'template' => $template,
        'usedTemplate' => $usedTemplate,
        'isInTemplate' => $isInTemplate,
        'isTemplate' => $isTemplate,
        'parentPlugin' => $o->getParentPlugin($model->data['id']),
        'parentSubplugin' => $o->getParentSubplugin($model->data['id']),
        'appId' => array_slice($parents, -2, 1)[0]
      ];
    }
  }
}

return [
  'success' => false
];
