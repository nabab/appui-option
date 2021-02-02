<!-- HTML Document -->

<bbn-form :action="root + 'actions/' + (currentSource.id ? 'update' : 'insert')"
          :class="['appui-option-form', {'bbn-overlay': !inPopup}]"
          :source="currentSource"
          @success="success"
          :validation="beforeSend"
          :scrollable="!inPopup"
>
  <div class="bbn-grid-fields bbn-padded">
    <div v-if="cfg.show_id"><?=_('ID')?></div>
    <div v-if="cfg.show_id" v-text="currentSource.id"></div>
    <div v-if="!schemaHasField('text') && (!cfg.notext || !cfg.show_alias)"><?=_('Text')?></div>
    <bbn-input v-if="!schemaHasField('text') && (!cfg.notext || !cfg.show_alias)"
               v-model="currentSource.text"
    ></bbn-input>
    <div v-if="cfg.show_code && !schemaHasField('code')"><?=_('Code')?></div>
    <bbn-input v-if="cfg.show_code && !schemaHasField('code')"
               v-model="currentSource.code"
    ></bbn-input>
    <template v-for="sch in currentComp.schema" v-if="currentComp.schema && showField(sch)">
      <div v-text="sch.title"></div>
      <bbn-field mode="write"
                v-bind="sch"
                v-model="currentSource[sch.field]"
      ></bbn-field>
    </template>
    <div v-if="cfg.show_alias && !schemaHasField('id_alias')"
        v-text="cfg.alias_name || '<?=bbn\Str::escapeSquotes(_('Alias'))?>'">
    </div>
    <div v-if="cfg.show_alias && !schemaHasField('id_alias')"
        class="bbn-flex-width"
    >
      <bbn-input :value="alias"
                 readonly="readonly"
                 class="bbn-flex-fill"
                 v-if="!cfg.root_alias || !cfg.root_alias.last_level"
      ></bbn-input>
      <bbn-button @click="selectAlias" 
                  v-if="!cfg.root_alias || !cfg.root_alias.last_level"
      >
        <?=_("Browse")?>
      </bbn-button>
      <bbn-dropdown v-if="cfg.root_alias && cfg.root_alias.last_level"
                    :source="cfg.root_alias.last_level_children"
                    placeholder="Select Alias"
                    source-text="text"
                    source-value="id"
                    class="bbn-w-100"
                    v-model="currentSource.id_alias"
      ></bbn-dropdown>
      <bbn-button v-if="currentSource.id_alias"
                  @click="clearAlias"
      >
        <?=_("Clear")?>
      </bbn-button>
    </div>
    <div v-if="(cfg.categories || !!cfg.show_icon) && !schemaHasField('icon')"><?=_('Icon')?></div>
    <div v-if="(cfg.categories || !!cfg.show_icon) && !schemaHasField('icon')"
        class="bbn-middle"
        style="justify-content: flex-start"
    >
      <div class="bbn-box bbn-xspadded bbn-right-sspace">
        <i :class="['bbn-xxxlarge', 'bbn-block', CurrentSource.icon]"
          :title="currentSource.icon"
          v-if="currentSource.icon"
        ></i>
        <div style="width: 2em; height: 2em"></div>
      </div>
      <bbn-button @click="selectIcon"><?=_("Browse")?></bbn-button>
      <bbn-button v-if="currentSource.icon"
                  @click="currentSource.icon = ''"
                  class="bbn-left-sspace"
      ><?=_("Clear")?></bbn-button>
    </div>
    <div v-if="cfg.categories && !schemaHasField('tekname')"><?=_('Tekname')?></div>
    <bbn-input v-if="cfg.categories && !schemaHasField('tekname')"
              v-model="currentSource.tekname"
    ></bbn-input>
    <div v-if="cfg.show_value"><?=_('Value')?></div>
    <div v-if="cfg.show_value"
         style="height: 300px"
    >
      <bbn-json-editor v-model="currentSource.value"></bbn-json-editor>
    </div>
  </div>
</bbn-form>
