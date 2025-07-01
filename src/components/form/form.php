<!-- HTML Document -->
<div>
  <div class="bbn-card">
    <bbn-form :action="root + 'actions/' + (source.id ? 'update' : 'insert')"
              :source="source"
              @success="success"
              :validation="beforeSend"
              :scrollable="false"
              mode="big">
      <div class="bbn-grid-fields bbn-padding">
        <div bbn-if="cfg.show_id"><?= _('ID') ?></div>
        <div bbn-if="cfg.show_id"
              bbn-text="source.id"/>

        <div bbn-if="!schemaHasField('text') && (!cfg.notext || !cfg.relations)"><?= _('Text') ?></div>
        <div bbn-if="!schemaHasField('text') && (!cfg.notext || !cfg.relations)">
          <bbn-input bbn-model="source.text"
                    class="bbn-wide"
                    :nullable="!!source.id_alias"/>
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
                  bbn-model="source.code"
                  class="bbn-wide"
                  :nullable="!!source.id_alias"/>

        <template bbn-for="sch in cfg.schema"
                  bbn-if="cfg.schema && showField(sch)">
          <div bbn-text="sch.label"/>
          <bbn-field mode="write"
                    bbn-bind="sch"
                    bbn-model="source[sch.field]"/>
        </template>

        <div bbn-if="(cfg.relations === 'alias') && !schemaHasField('id_alias')"
            bbn-text="cfg.alias_name || '<?= bbn\Str::escapeSquotes(_('Alias')) ?>'">
        </div>
        <div bbn-if="(cfg.relations === 'alias') && !schemaHasField('id_alias')"
            class="bbn-flex-width">
          <appui-option-input-picker bbn-if="!cfg.root_alias || !cfg.root_alias.last_level"
                                    :nullable="true"
                                    :id_root="cfg.root_alias?.id || ''"
                                    bbn-model="source.id_alias"/>
          <bbn-dropdown bbn-if="cfg.root_alias && cfg.root_alias.last_level"
                        :source="cfg.root_alias.last_level_children"
                        placeholder="Select Alias"
                        :nullable="true"
                        source-text="text"
                        source-value="id"
                        class="bbn-w-100"
                        bbn-model="source.id_alias"/>
        </div>

        <div bbn-if="cfg.show_icon && !schemaHasField('icon')"><?= _('Icon') ?></div>
        <div bbn-if="cfg.show_icon && !schemaHasField('icon')"
            class="bbn-middle"
            style="justify-content: flex-start">
          <div class="bbn-box bbn-xspadding bbn-right-sspace">
            <i :class="['bbn-xxxlarge', 'bbn-block', currentIcon]"
              :title="currentIcon"
              bbn-if="currentIcon"/>
            <div bbn-else style="width: 2em; height: 2em"/>
          </div>
          <bbn-button @click="selectIcon"><?= _("Browse") ?></bbn-button>
          <bbn-button bbn-if="currentIcon"
                      @click="currentIcon = ''"
                      class="bbn-left-sspace"><?= _("Clear") ?></bbn-button>
        </div>

        <div bbn-if="cfg.categories && !schemaHasField('tekname')"><?= _('Tekname') ?></div>
        <bbn-input bbn-if="cfg.categories && !schemaHasField('tekname')"
                  bbn-model="source.tekname"/>

        <div bbn-if="cfg.show_value"><?= _('Value') ?></div>
        <div bbn-if="cfg.show_value"
            style="height: 300px"
            class="bbn-widest">
          <bbn-json-editor bbn-model="source.value"/>
        </div>
      </div>
    </bbn-form>
  </div>
</div>
