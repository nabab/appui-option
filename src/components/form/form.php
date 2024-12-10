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
          <div bbn-if="cfg.show_id"><?= _('ID') ?></div>
          <div bbn-if="cfg.show_id"
              bbn-text="currentSource.id"/>

          <div bbn-if="!schemaHasField('text') && (!cfg.notext || !cfg.show_alias)"><?= _('Text') ?></div>
          <div bbn-if="!schemaHasField('text') && (!cfg.notext || !cfg.show_alias)">
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

          <div bbn-if="cfg.show_code && !schemaHasField('code')"><?= _('Code') ?></div>
          <bbn-input bbn-if="cfg.show_code && !schemaHasField('code')"
                    bbn-model="currentSource.code"
                    class="bbn-wide"
                    :nullable="!!currentSource.id_alias"/>

          <template bbn-for="sch in currentComp.schema"
                    bbn-if="currentComp.schema && showField(sch)">
            <div bbn-text="sch.title"/>
            <bbn-field mode="write"
                      bbn-bind="sch"
                      bbn-model="currentSource[sch.field]"/>
          </template>

          <div bbn-if="cfg.show_alias && !schemaHasField('id_alias')"
              bbn-text="cfg.alias_name || '<?= bbn\Str::escapeSquotes(_('Alias')) ?>'">
          </div>
          <div bbn-if="cfg.show_alias && !schemaHasField('id_alias')"
              class="bbn-flex-width">
            <appui-option-input-picker bbn-if="!cfg.root_alias || !cfg.root_alias.last_level"
                                      :nullable="true"
                                      bbn-model="currentSource.id_alias"/>
            <bbn-dropdown bbn-if="cfg.root_alias && cfg.root_alias.last_level"
                          :source="cfg.root_alias.last_level_children"
                          placeholder="Select Alias"
                          :nullable="true"
                          source-text="text"
                          source-value="id"
                          class="bbn-w-100"
                          bbn-model="currentSource.id_alias"/>
          </div>

          <div bbn-if="(cfg.categories || !!cfg.show_icon) && !schemaHasField('icon')"><?= _('Icon') ?></div>
          <div bbn-if="(cfg.categories || !!cfg.show_icon) && !schemaHasField('icon')"
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

          <div bbn-if="cfg.categories && !schemaHasField('tekname')"><?= _('Tekname') ?></div>
          <bbn-input bbn-if="cfg.categories && !schemaHasField('tekname')"
                    bbn-model="currentSource.tekname"/>

          <div bbn-if="cfg.show_value"><?= _('Value') ?></div>
          <div bbn-if="cfg.show_value"
              style="height: 300px"
              class="bbn-widest">
            <bbn-json-editor bbn-model="currentSource.value"/>
          </div>
        </div>
      </bbn-form>
    </div>
  </div>
</div>
