<div class="bbn-grid-fields">
  <!-- INTERNAL RELATIONS -->
  <div class="bbn-grid-full bbn-m bbn-b">
    <?= _('Internal relations') ?>
  </div>

  <div class="bbn-grid-full bbn-c">
    <bbn-radio class="bbn-options-relations"
              bbn-model="source.relations"
              :disabled="isFrozen"
              :source="aliasRelations"/>
  </div>
  <label bbn-if="source.relations === 'template'">
    <?= _('Template used by children') ?>
  </label>
  <bbn-dropdown bbn-if="source.relations === 'template'"
                bbn-model="source.id_template"
                :source="appui.plugins['appui-option'] + '/data/templates'"
                :disabled="isFrozen"/>
  
  <div class="bbn-grid-full bbn-c"
       bbn-if="(source.relations === 'template') && source.id_template && $origin.source?.option?.num_children">
    <bbn-button @click="applyTemplate"
                label="<?= _('Apply template to existing children') ?>"/>
  </div>

  <label bbn-if="source.relations === 'alias'">
    <?= _("Alias' root") ?>
  </label>
  <div class="bbn-flex-width"
        bbn-if="source.relations === 'alias'">
    <appui-option-input-picker :disabled="isFrozen"
                                bbn-model="source.id_root_alias"/>
  </div>

  <label bbn-if="source.relations === 'alias'">
    <?= _("Alias' name") ?>
  </label>
  <bbn-input bbn-if="source.relations === 'alias'"
            bbn-model="source.alias_name"
            :disabled="isFrozen"
            class="bbn-wide"/>

  <!-- DATA STRUCTURE -->
  <template bbn-if="source.relations !== 'template'">

    <div class="bbn-grid-full bbn-m bbn-b">
      <?= _('Data structure') ?>
    </div>
  
    <label>
      <?= _('Orderable') ?>
    </label>
    <bbn-checkbox bbn-model.number="source.sortable"
                  :disabled="isFrozen"
                  :value="1"/>
  
    <label>
      <?= _('Use') ?>
    </label>
    <div>
      <bbn-checkbox bbn-model.number="source.show_code"
                    :disabled="isFrozen"
                    :value="1"
                    label="<?= _('Code') ?>"
                    style="margin-right: 1.5em"/>
      <bbn-checkbox bbn-if="source.relations === 'alias'"
                    bbn-model.number="source.notext"
                    :disabled="isFrozen"
                    :value="1"
                    style="margin-right: 1.5em"
                    title="<?= _('Hide the text column') ?>"
                    label="<?= _('No text') ?>"/>
      <bbn-checkbox bbn-model.number="source.show_icon"
                    :disabled="isFrozen"
                    :value="1"
                    label="<?= _('Icon') ?>"
                    style="margin-right: 1.5em"/>
    </div>
  
    <div class="bbn-grid-full bbn-c">
      <bbn-radio class="bbn-options-structure-type"
                  bbn-model="structureType"
                  :disabled="isFrozen"
                  @beforechange=""
                  :source="structureTypes"/>
    </div>
  
    <div class="bbn-grid-full"
         bbn-if="structureType === 'schema'">
      <appui-option-config-schema :source="currentSchema"
                                  class="bbn-margin-top"
                                  :frozen="isFrozen"/>
    </div>
  
    <!-- PERMISSIONS -->
    <hr>
  
    <div class="bbn-grid-full bbn-m bbn-b">
      <?= _('Permissions') ?>
    </div>
    <div class="bbn-grid-full bbn-c"
          bbn-if="source.permissions !== 1">
      <div class="bbn-w-100">
        <bbn-radio class="bbn-options-inheritance"
                  bbn-model="source.permissions"
                  :disabled="isFrozen"
                  bbn-if="permissionsSource.length > 1"
                  :source="permissionsSource"/>
      </div>
      <div class="bbn-w-100 bbn-i"
          bbn-if="source.permissions"
          bbn-html="permissionsText">
      </div>
    </div>
  
    <label><?= _('Default value') ?></label>
    <bbn-dropdown :source="root + 'text_value/' + optionId"
                  :disabled="isFrozen"
                  source-value="id"
                  bbn-model="source.default_value"
                  placeholder=" - "
                  class="bbn-wide"/>
  
    <!-- UI PERSONALIZATION -->
    <hr>
    <div class="bbn-grid-full bbn-m bbn-b">
      <?= _('UI Personalization') ?>
    </div>
  
    <label bbn-if="!source.categories"><?= _('Hide parent') ?></label>
    <bbn-checkbox bbn-if="!source.categories"
                  bbn-model.number="source.noparent"
                  :value="1"
                  :disabled="isFrozen"/>
  
    <label><?= _('External MV') ?></label>
    <bbn-dropdown id="bbn_options_cfg_model"
                  :nullable="true"
                  :source="controllers"
                  bbn-model="source.controller"
                  :disabled="isFrozen"
                  placeholder=" - "
                  class="bbn-wide"/>
  
    <!--<label bbn-if="!data.categories"><?/*=_('Model')*/?></label>
    <bbn-dropdown id="bbn_options_cfg_model"
                  bbn-if="!data.categories"
                  class="bbn-wider"
                  name="model"
                  :source="models"
                  bbn-model="data.model"
                  :disabled="!!source.inherit_from"
                  placeholder=" - "/>
    <label bbn-if="!data.categories || !data.form"><?/*=_('View')*/?></label>
    <bbn-dropdown id="bbn_options_cfg_view"
                  bbn-if="!data.categories || !data.form"
                  class="bbn-wider"
                  name="view"
                  :source="views"
                  bbn-model="data.view"
                  :disabled="!!source.inherit_from"
                  placeholder=" - "/>-->
  
    <label bbn-if="!source.categories || !source.view"><?= _('Form') ?></label>
    <bbn-dropdown bbn-if="!source.categories || !source.view"
                  :source="views"
                  bbn-model="source.form"
                  :disabled="isFrozen"
                  placeholder=" - "
                  class="bbn-wide"/>
  
    <label bbn-if="!showSchema">
      <?= _('Show value') ?>
    </label>
    <bbn-checkbox bbn-if="!showSchema" 
                  bbn-model.number="source.show_value"
                  :disabled="isFrozen"
                  :value="1"/>
  
    <!-- INTERNATIONALIZATION -->
    <hr>
    <div class="bbn-grid-full bbn-m bbn-b">
      <?= _('Internationalization') ?>
    </div>
  
    <label><?= _('Language') ?></label>
    <bbn-dropdown :source="source.languages"
                  bbn-model="source.i18n"
                  placeholder=" - "
                  source-value="code"
                  :nullable="true"
                  :disabled="isFrozen"
                  class="bbn-wide"/>
  
    <label class="bbn-options-inheritance"
          bbn-if="source.allow_children && source.i18n">
      <?= _('Language inheritance') ?>
    </label>
    <bbn-radio class="bbn-options-inheritance"
              bbn-if="source.allow_children && source.i18n"
              bbn-model="source.i18n_inheritance"
              :disabled="isFrozen"
              :source="[{
                  text: '<?= st::escape(_('None')) ?>',
                  value: '',
                }, {
                  text: '<?= st::escape(_('Only children')) ?>',
                  value: 'children',
                }, {
                  text: '<?= st::escape(_('Cascade')) ?>',
                  value: 'cascade',
                }]"/>
  </template>
</div>
