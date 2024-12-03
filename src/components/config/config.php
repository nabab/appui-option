<!-- HTML Document -->
<bbn-form v-if="ready"
          :action="root + 'actions/cfg'"
          :source="data"
          :validation="beforeSend"
          ref="config"
          @success="onSuccess"
          :scrollable="!inPopup">
  <div class="bbn-padding">
    <div class="bbn-w-100 bbn-c bbn-bottom-margin bbn-xl">
      <?= _('Configuration for items in option') ?> <span v-text="source.option.text"/> 
      &nbsp;
      <bbn-button type="button"
                  @click="unlock"
                  icon="nf nf-fa-unlock_alt"
                  title="<?= _('Unlock') ?>"
                  :notext="true"/>
    </div>
    <div v-if="source.cfg.inherit_from"
         class="bbn-w-100 bbn-c bbn-bottom-margin bbn-lg">
      <?= _('Inherited from') ?> <a :href="root + 'list/' + source.cfg.inherit_from" v-text="source.cfg_inherit_from_text"/>
      &nbsp;
      <bbn-button type="button"
                  @click="unlock"
                  icon="nf nf-fa-unlock_alt"
                  title="<?= _('Unlock') ?>"
                  :notext="true"/>
    </div>
    <div v-if="showReset"
         style="position: absolute; top: 15px; right: 30px">
      <bbn-button type="button"
                  @click="reset"
                  icon="nf nf-fa-undo"
                  title="<?= _('Back to default') ?>"
                  :notext="true"/>
    </div>

    <div class="bbn-grid-fields">

      <label style="width: 15em"><?= _("Presets") ?></label>
      <div>
        <bbn-checkbox class="k-checkbox"
                      v-model.number="data.cfg.categories"
                      :disabled="!!source.cfg.frozen"
                      style="margin-right: 1.5em"
                      label="<?= _("Categories' page") ?>"
                      :value="1"/>
        <bbn-checkbox v-model.number="data.cfg.noparent"
                      :value="1"
                      title="<?= _('Hide the parent button') ?>"
                      label="<?= _('Hide parent') ?>"
                      :disabled="!!source.cfg.frozen"/>
      </div>

      <label v-if="!source.cfg.categories"><?= _('Allow children') ?></label>
      <bbn-checkbox v-if="!source.cfg.categories"
                    v-model.number="data.cfg.allow_children"
                    :value="1"
                    :disabled="!!source.cfg.frozen"/>

      <label v-if="!data.cfg.categories"><?= _('Show') ?></label>
      <div v-if="!data.cfg.categories">
        <bbn-checkbox v-model.number="data.cfg.show_code"
                      :disabled="!!source.cfg.frozen"
                      :value="1"
                      label="<?= _('Code') ?>"
                      style="margin-right: 1.5em"/>
        <bbn-checkbox v-model.number="data.cfg.show_alias"
                      :disabled="!!source.cfg.frozen"
                      :value="1"
                      label="<?= _('Alias') ?>"
                      style="margin-right: 1.5em"/>
        <bbn-checkbox v-if="source.cfg.show_alias"
                      v-model.number="data.cfg.notext"
                      :disabled="!!source.cfg.frozen"
                      :value="1"
                      style="margin-right: 1.5em"
                      title="<?= _('Hide the text column') ?>"
                      label="<?= _('No text') ?>"/>
        <bbn-checkbox v-model.number="data.cfg.show_icon"
                      :disabled="!!source.cfg.frozen"
                      :value="1"
                      label="<?= _('Icon') ?>"
                      style="margin-right: 1.5em"/>
      </div>

      <label v-if="source.cfg.show_alias"><?= _("Alias' root") ?></label>
      <div class="bbn-flex-width"
           v-if="source.cfg.show_alias">
        <appui-option-input-picker :disabled="!!source.cfg.frozen"
                                   v-model="data.cfg.id_root_alias"/>
      </div>

      <label v-if="source.cfg.show_alias"><?= _("Alias' name") ?></label>
      <bbn-input v-if="source.cfg.show_alias"
                 v-model="data.cfg.alias_name"
                 :disabled="!!source.cfg.frozen"/>

      <label v-if="!source.cfg.categories"><?= _('Orderable') ?></label>
      <bbn-checkbox v-if="!source.cfg.categories"
                    v-model.number="data.cfg.sortable"
                    :disabled="!!source.cfg.frozen"
                    :value="1"/>

      <label class="bbn-options-inheritance"
             v-if="source.cfg.allow_children">
        <?= _('Inheritance') ?>
      </label>
      <bbn-radio class="bbn-options-inheritance"
                 v-if="source.cfg.allow_children"
                 v-model="data.cfg.inheritance"
                 :disabled="!!source.cfg.frozen || showScfg"
                 :source="[{
                    text: '<?= st::escape(_('None')) ?>',
                    value: '',
                  }, {
                    text: '<?= st::escape(_('Only children')) ?>',
                    value: 'children',
                  }, {
                    text: '<?= st::escape(_('Cascade')) ?>',
                    value: 'cascade',
                  }, {
                    text: '<?= st::escape(_('Default')) ?>',
                    value: 'default',
                  }]"/>

      <label v-if="data.cfg.permissions !== 1"><?= _('Permissions') ?></label>
      <div v-if="data.cfg.permissions !== 1">
        <div class="bbn-w-100">
          <bbn-radio class="bbn-options-inheritance"
                     v-model="data.cfg.permissions"
                     :disabled="!!source.cfg.frozen"
                     v-if="permissionsSource.length > 1"
                     :source="permissionsSource"/>
        </div>
        <div class="bbn-w-100 bbn-i"
             v-if="source.permissions"
             v-html="permissionsText">
        </div>
      </div>

      <label><?= _('Default value') ?></label>
      <bbn-dropdown :source="root + 'text_value/' + data.id"
                    :disabled="!!source.cfg.frozen"
                    source-value="id"
                    v-model="data.cfg.default_value"
                    placeholder=" - "/>

      <label><?= _('External MV') ?></label>
      <bbn-dropdown id="bbn_options_cfg_model"
                    :nullable="true"
                    :source="controllers"
                    v-model="data.cfg.controller"
                    :disabled="!!source.cfg.frozen"
                    placeholder=" - "/>

      <!--<label v-if="!data.categories"><?/*=_('Model')*/?></label>
      <bbn-dropdown id="bbn_options_cfg_model"
                    v-if="!data.categories"
                    class="bbn-wider"
                    name="model"
                    :source="models"
                    v-model="data.model"
                    :disabled="!!source.cfg.inherit_from"
                    placeholder=" - "/>
      <label v-if="!data.categories || !data.form"><?/*=_('View')*/?></label>
      <bbn-dropdown id="bbn_options_cfg_view"
                    v-if="!data.categories || !data.form"
                    class="bbn-wider"
                    name="view"
                    :source="views"
                    v-model="data.view"
                    :disabled="!!source.cfg.inherit_from"
                    placeholder=" - "/>-->

      <label v-if="!data.cfg.categories || !data.cfg.view"><?= _('Form') ?></label>
      <bbn-dropdown v-if="!data.cfg.categories || !data.cfg.view"
                    :source="views"
                    v-model="data.cfg.form"
                    :disabled="!!source.cfg.frozen"
                    placeholder=" - "/>

      <label v-if="!showSchema">
        <?= _('Show value') ?>
      </label>
      <bbn-checkbox v-if="!showSchema" 
                    v-model.number="data.cfg.show_value"
                    :disabled="!!source.cfg.frozen"
                    :value="1"/>

      <label v-if="!data.cfg.show_value">
        <a class="bbn-p" @click="toggleSchema"><?= _('Schema') ?></a>
      </label>
      <div v-if="showSchema && !data.cfg.show_value">
        <bbn-json-editor v-model="data.cfg.schema"
                         :cfg="{schema: jsonSchema, templates: jsonDataTemplate}"
                         :disabled="!!source.cfg.frozen"
                         v-if="showSchema"
                         style="height: 300px"/>
      </div>
      <div v-else-if="!data.cfg.show_value"> </div>

      <label><?= _('Language') ?></label>
      <bbn-dropdown :source="source.languages"
                    v-model="data.cfg.i18n"
                    placeholder=" - "
                    source-value="code"
                    :nullable="true"
                    :disabled="!!source.cfg.frozen"/>
      <label class="bbn-options-inheritance"
             v-if="source.cfg.allow_children && data.cfg.i18n">
        <?= _('Language inheritance') ?>
      </label>
      <bbn-radio class="bbn-options-inheritance"
                 v-if="source.cfg.allow_children && data.cfg.i18n"
                 v-model="data.cfg.i18n_inheritance"
                 :disabled="!!source.cfg.frozen || showScfg"
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

      <label><?= _('Description') ?></label>
      <bbn-textarea style="min-height: 120px"
                    v-model="data.cfg.desc"
                    :disabled="!!source.cfg.frozen"/>


      <label><?= _('Help') ?></label>
      <bbn-markdown v-model="data.cfg.help"
                    :disabled="!!source.cfg.frozen"/>

      <label v-if="source.cfg.allow_children"
             class="bbn-p">
        <?= _('SubConfigurator') ?>
      </label>
      <bbn-switch v-model="showScfg"
                  :disabled="!!source.cfg.frozen"
                  :value="true"
                  :novalue="false"
                  v-if="data.cfg.allow_children"/>
    </div>
    <div v-if="showScfg && data.cfg.allow_children" class="bbn-box bbn-top-sspace">
      <div class="bbn-header bbn-c bbn-no-border-left bbn-no-border-top bbn-no-border-right bbn-spadding bbn-radius-top-left bbn-radius-top-right"><?= _('SubConfigurator') ?></div>
      <div class="bbn-grid-fields bbn-padding">
        <label style="width: 15em"><?= _("Categories' page") ?></label>
        <div>
          <bbn-checkbox v-model.number="data.scfg.categories"
                        :disabled="!!data.scfg.frozen"
                        style="margin-right: 1.5em"
                        :value="1"/>
          <bbn-checkbox v-model.number="data.scfg.noparent"
                        :value="1"
                        title="<?= _('Hide the parent button') ?>"
                        label="<?= _('Hide parent') ?>"
                        :disabled="!!data.scfg.frozen"/>
        </div>

        <label v-if="!data.scfg.categories"><?= _('Show') ?></label>
        <div v-if="!data.scfg.categories">
          <bbn-checkbox v-model.number="data.scfg.show_code"
                        :disabled="!!source.cfg.frozen"
                        :value="1"
                        label="<?= _('Code') ?>"
                        style="margin-right: 1.5em"/>
          <bbn-checkbox v-model.number="data.scfg.show_alias"
                        :disabled="!!source.cfg.frozen"
                        :value="1"
                        label="<?= _('Alias') ?>"
                        style="margin-right: 1.5em"/>
          <bbn-checkbox v-if="source.show_alias"
                        v-model.number="data.scfg.notext"
                        :disabled="!!source.cfg.frozen"
                        :value="1"
                        label="<?= _('No text') ?>"
                        style="margin-right: 1.5em"/>
          <bbn-checkbox v-model.number="data.scfg.show_icon"
                        :disabled="!!source.cfg.frozen"
                        :value="1"
                        label="<?= _('Icon') ?>"
                        style="margin-right: 1.5em"/>
        </div>

        <label v-if="data.scfg.show_alias"><?= _("Alias' root") ?></label>
        <div class="bbn-flex-width"
              v-if="data.scfg.show_alias">
          <bbn-button @click="browseAlias(data.scfg)"
                      type="button"
          ><?= _("Browse") ?></bbn-button>
          <bbn-button @click="setToRootScfg"
                      type="button"
          ><?= _("Root") ?></bbn-button>
          <bbn-input readonly="readonly"
                      class="bbn-flex-fill"
                      :value="data.scfg.root_alias"/>
        </div>

        <label v-if="data.scfg.show_alias"><?= _("Alias' name") ?></label>
        <bbn-input v-if="data.scfg.show_alias"
                    v-model="data.scfg.alias_name"/>

        <label v-if="!data.scfg.categories"><?= _('Orderable') ?></label>
        <bbn-checkbox v-if="!data.scfg.categories"
                      v-model.number="data.scfg.sortable"
                      :disabled="!!source.cfg.frozen"
                      :value="1"/>

        <label v-if="!data.scfg.categories"><?= _('Allow children') ?></label>
        <bbn-checkbox v-if="!data.scfg.categories"
                      v-model.number="data.scfg.allow_children"
                      :disabled="!!source.cfg.frozen"
                      :value="1"/>

        <label class="bbn-options-inheritance"
                v-if="data.scfg.allow_children">
          <?= _('Inheritance') ?>
        </label>
        <bbn-radio class="bbn-options-inheritance"
                    v-if="data.scfg.allow_children"
                    v-model="data.scfg.inheritance"
                    :disabled="!!source.cfg.frozen"
                    :source="[{
                      text: '<?= _('None') ?>',
                      value: '',
                    }, {
                      text: '<?= _('Only children') ?>',
                      value: 'children',
                    }, {
                      text: '<?= _('Cascade') ?>',
                      value: 'cascade',
                    }, {
                      text: '<?= _('Default') ?>',
                      value: 'default',
                    }]"/>

        <label><?= _('Default value') ?></label>
        <bbn-dropdown :source="root + 'text_value/' + data.id"
                      :disabled="!!source.cfg.frozen"
                      source-value="id"
                      v-model="data.scfg.default_value"
                      placeholder=" - "/>

        <label><?= _('External MV') ?></label>
        <bbn-dropdown id="bbn_options_cfg_model"
                      :source="controllers"
                      v-model="data.model"
                      :disabled="!!source.cfg.inherit_from"
                      placeholder=" - "/>

        <!--<label v-if="!data.categories"><?/*=_('Model')*/?></label>
        <bbn-dropdown id="bbn_options_cfg_model"
                      v-if="!data.categories"
                      class="bbn-wider"
                      name="model"
                      :source="models"
                      v-model="data.model"
                      :disabled="!!source.cfg.inherit_from"
                      placeholder=" - "
        ></bbn-dropdown>
        <label v-if="!data.categories || !data.form"><?/*=_('View')*/?></label>
        <bbn-dropdown id="bbn_options_cfg_view"
                      v-if="!data.categories || !data.form"
                      class="bbn-wider"
                      name="view"
                      :source="views"
                      v-model="data.view"
                      :disabled="!!source.cfg.inherit_from"
                      placeholder=" - "
        ></bbn-dropdown>-->

        <label v-if="!data.scfg.categories || !data.scfg.view"><?= _('Form') ?></label>
        <bbn-dropdown v-if="!data.scfg.categories || !data.scfg.view"
                      :source="views"
                      v-model="data.scfg.form"
                      :disabled="!!source.cfg.frozen"
                      placeholder=" - "/>

        <label><?= _('Language') ?></label>
        <bbn-dropdown :source="source.languages"
                      v-model="data.scfg.i18n"
                      placeholder=" - "
                      source-value="code"/>

        <label v-if="source.cfg.allow_children && !showSchemaScfg">
          <?= _('Show value') ?>
        </label>
        <bbn-checkbox v-if="!showSchema"
                      v-model.number="data.scfg.show_value"
                      :disabled="!!source.cfg.frozen"
                      :value="1"/>

        <label v-if="showSchemaScfg && !data.scfg.show_value">
          <a class="bbn-p" @click="toggleSchemaScfg"><?= _('Schema') ?></a>
        </label>
        <div v-if="showSchemaScfg && !data.scfg.show_value">
          <bbn-json-editor v-model="data.scfg.schema"
                           :cfg="{schema: jsonSchema, templates: jsonDataTemplate}"
                           :disabled="!!source.cfg.frozen"
                           style="height: 300px"/>
        </div>

        <label><?= _('Description') ?></label>
        <div>
          <bbn-textarea style="width: 100%; min-height: 120px"
                        v-model="data.scfg.desc"
                        :disabled="!!source.cfg.frozen"/>
        </div>

        <label><?= _('Help') ?></label>
        <bbn-markdown v-model="data.scfg.help"/>
      </div>
    </div>
  </div>
</bbn-form>