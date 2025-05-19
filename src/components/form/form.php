<!-- HTML Document -->
<div>
  <div class="bbn-padding bbn-centered-block">
    <div class="bbn-card bbn-vlmargin">
      <bbn-form :action="root + 'actions/' + (currentSource.id ? 'update' : 'insert')"
                :source="currentSource"
                @success="success"
                :validation="beforeSend"
                :scrollable="false"
                mode="big">
        <div class="bbn-grid-fields bbn-padding">
          <div bbn-if="parentCfg.show_id"><?= _('ID') ?></div>
          <div bbn-if="parentCfg.show_id"
               bbn-text="currentSource.id"/>

          <div bbn-if="!schemaHasField('text') && (!parentCfg.notext || !parentCfg.relations)"><?= _('Text') ?></div>
          <div bbn-if="!schemaHasField('text') && (!parentCfg.notext || !parentCfg.relations)">
            <bbn-input bbn-model="currentSource.text"
                      class="bbn-wide"
                      :nullable="!!currentSource.id_alias"/>
            <div bbn-if="currentTranslation !== false"
                class="bbn-iblock bbn-vmiddle bbn-left-space bbn-radius bbn-hspadding bbn-secondary bbn-unselectable bbn-p"
                :title="_('Current translations')"
                @click="openI18n">
              <i class="nf nf-fa-flag"/>
              <span bbn-text="currentTranslation"
                    class="bbn-left-sspace bbn-b"/>
            </div>
          </div>

          <div bbn-if="parentCfg.show_code && !schemaHasField('code')"><?= _('Code') ?></div>
          <bbn-input bbn-if="parentCfg.show_code && !schemaHasField('code')"
                    bbn-model="currentSource.code"
                    class="bbn-wide"
                    :nullable="!!currentSource.id_alias"/>

          <template bbn-for="sch in currentComp.schema"
                    bbn-if="currentComp.schema && showField(sch)">
            <div bbn-text="sch.label"/>
            <bbn-field mode="write"
                      bbn-bind="sch"
                      bbn-model="currentSource[sch.field]"/>
          </template>

          <div bbn-if="(parentCfg.relations === 'alias') && !schemaHasField('id_alias')"
              bbn-text="parentCfg.alias_name || '<?= bbn\Str::escapeSquotes(_('Alias')) ?>'">
          </div>
          <div bbn-if="(parentCfg.relations === 'alias') && !schemaHasField('id_alias')"
              class="bbn-flex-width">
            <appui-option-input-picker bbn-if="!parentCfg.root_alias || !parentCfg.root_alias.last_level"
                                      :nullable="true"
                                      :id_root="parentCfg.root_alias?.id || ''"
                                      bbn-model="currentSource.id_alias"/>
            <bbn-dropdown bbn-if="parentCfg.root_alias && parentCfg.root_alias.last_level"
                          :source="parentCfg.root_alias.last_level_children"
                          placeholder="Select Alias"
                          :nullable="true"
                          source-text="text"
                          source-value="id"
                          class="bbn-w-100"
                          bbn-model="currentSource.id_alias"/>
          </div>

          <div bbn-if="(parentCfg.categories || !!parentCfg.show_icon) && !schemaHasField('icon')"><?= _('Icon') ?></div>
          <div bbn-if="(parentCfg.categories || !!parentCfg.show_icon) && !schemaHasField('icon')"
              class="bbn-middle"
              style="justify-content: flex-start">
            <div class="bbn-box bbn-xspadding bbn-right-sspace">
              <i :class="['bbn-xxxlarge', 'bbn-block', currentSource.icon]"
                :title="currentSource.icon"
                bbn-if="currentSource.icon"/>
              <div style="width: 2em; height: 2em"/>
            </div>
            <bbn-button @click="selectIcon"><?= _("Browse") ?></bbn-button>
            <bbn-button bbn-if="currentSource.icon"
                        @click="currentSource.icon = ''"
                        class="bbn-left-sspace"
            ><?= _("Clear") ?></bbn-button>
          </div>

          <div bbn-if="parentCfg.categories && !schemaHasField('tekname')"><?= _('Tekname') ?></div>
          <bbn-input bbn-if="parentCfg.categories && !schemaHasField('tekname')"
                    bbn-model="currentSource.tekname"/>

          <div bbn-if="parentCfg.show_value"><?= _('Value') ?></div>
          <div bbn-if="parentCfg.show_value"
              style="height: 300px"
              class="bbn-widest">
            <bbn-json-editor bbn-model="currentSource.value"/>
          </div>
        </div>
      </bbn-form>
    </div>
  </div>
</div>
