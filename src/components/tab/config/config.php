<!-- HTML Document -->
<div>
  <div class="bbn-padding bbn-centered-block">
    <div class="bbn-vlmargin bbn-card bbn-no-padding">
      <bbn-form bbn-if="ready"
                :action="root + 'actions/cfg'"
                :source="data"
                :validation="beforeSend"
                ref="config"
                @success="onSuccess"
                :scrollable="false"
                mode="big">
        <div class="bbn-padding">
          <div class="bbn-w-100 bbn-c bbn-bottom-margin bbn-xl">
            <?= _('Configuration for items in option') ?> <span bbn-text="source.option.text"/> 
            &nbsp;
            <bbn-button type="button"
                        @click="unlock"
                        icon="nf nf-fa-unlock_alt"
                        title="<?= _('Unlock') ?>"
                        :notext="true"/>
          </div>
          <div bbn-if="data.cfg.inherit_from"
              class="bbn-w-100 bbn-c bbn-bottom-margin bbn-lg">
            <?= _('Inherited from') ?> <a :href="root + 'list/' + data.cfg.inherit_from" bbn-text="data.cfg.inherit_from_text"/>
            &nbsp;
            <bbn-button type="button"
                        @click="unlock"
                        icon="nf nf-fa-unlock_alt"
                        title="<?= _('Unlock') ?>"
                        :notext="true"/>
          </div>
          <div bbn-if="showReset"
              style="position: absolute; top: 15px; right: 30px">
            <bbn-button type="button"
                        @click="reset"
                        icon="nf nf-fa-undo"
                        title="<?= _('Back to default') ?>"
                        :notext="true"/>
          </div>

          <div class="bbn-grid-fields">

            <!-- PRESETS -->
            <hr class="bbn-hr">
            <div class="bbn-grid-full bbn-m bbn-b">
              <?= _('Presets') ?>
            </div>

            <label>
              <?= _("Presets") ?>
            </label>
            <div>
              <bbn-checkbox bbn-model.number="data.cfg.categories"
                            :disabled="!!data.cfg.frozen"
                            style="margin-right: 1.5em"
                            label="<?= _("Categories' page") ?>"
                            :value="1"/>
            </div>

            <!-- DATA STRUCTURE -->
            <hr>
            <div class="bbn-grid-full bbn-m bbn-b">
              <?= _('Data structure') ?>
            </div>

            <label bbn-if="!data.cfg.categories">
              <?= _('Orderable') ?>
            </label>
            <bbn-checkbox bbn-if="!data.cfg.categories"
                          bbn-model.number="data.cfg.sortable"
                          :disabled="!!data.cfg.frozen"
                          :value="1"/>

            <label bbn-if="!data.cfg.categories">
              <?= _('Use') ?>
            </label>
            <div bbn-if="!data.cfg.categories">
              <bbn-checkbox bbn-model.number="data.cfg.show_code"
                            :disabled="!!data.cfg.frozen"
                            :value="1"
                            label="<?= _('Code') ?>"
                            style="margin-right: 1.5em"/>
              <bbn-checkbox bbn-if="source.cfg.relations === 'alias'"
                            bbn-model.number="data.cfg.notext"
                            :disabled="!!data.cfg.frozen"
                            :value="1"
                            style="margin-right: 1.5em"
                            title="<?= _('Hide the text column') ?>"
                            label="<?= _('No text') ?>"/>
              <bbn-checkbox bbn-model.number="data.cfg.show_icon"
                            :disabled="!!data.cfg.frozen"
                            :value="1"
                            label="<?= _('Icon') ?>"
                            style="margin-right: 1.5em"/>
            </div>

            <label bbn-if="!data.cfg.show_value">
              <?= _('Schema') ?>
            </label>
            <div bbn-if="!data.cfg.show_value">
              <appui-option-schema :source="currentSchema"
                                    class="bbn-w-100 bbn-no-padding"/>
            </div>

            <!-- INTERNAL RELATIONS -->
            <hr>
            <div class="bbn-grid-full bbn-m bbn-b">
              <?= _('Internal relations') ?>
            </div>

            <div class="bbn-grid-full bbn-c">
              <bbn-radio class="bbn-options-relations"
                        bbn-model="data.cfg.relations"
                        :disabled="!!data.cfg.frozen || showScfg"
                        :source="aliasRelations"/>
            </div>
            <label bbn-if="data.cfg.relations === 'template'">
              <?= _('Template used by children') ?>
            </label>
            <bbn-dropdown bbn-if="data.cfg.relations === 'template'"
                          bbn-model="data.cfg.id_template"
                          :source="appui.plugins['appui-option'] + '/data/templates'"
                          :disabled="!!data.cfg.frozen"/>

            <label bbn-if="data.cfg.relations === 'alias'">
              <?= _("Alias' root") ?>
            </label>
            <div class="bbn-flex-width"
                 bbn-if="data.cfg.relations === 'alias'">
              <appui-option-input-picker :disabled="!!data.cfg.frozen"
                                          bbn-model="data.cfg.id_root_alias"/>
            </div>

            <label bbn-if="data.cfg.relations === 'alias'">
              <?= _("Alias' name") ?>
            </label>
            <bbn-input bbn-if="data.cfg.relations === 'alias'"
                      bbn-model="data.cfg.alias_name"
                      :disabled="!!data.cfg.frozen"
                      class="bbn-wide"/>

            <!-- OPTIONS INHERITANCE -->
            <hr>
            <div class="bbn-grid-full bbn-m bbn-b">
              <?= _('Options inheritance') ?>
            </div>

            <label bbn-if="!data.cfg.categories"><?= _('Allow children') ?></label>
            <bbn-checkbox bbn-if="!data.cfg.categories"
                          bbn-model.number="data.cfg.allow_children"
                          :value="1"
                          :disabled="!!data.cfg.frozen"/>

            <div class="bbn-grid-full bbn-c">
              <bbn-radio class="bbn-options-inheritance"
                        bbn-if="data.cfg.allow_children"
                        bbn-model="data.cfg.inheritance"
                        :disabled="!!data.cfg.frozen || showScfg"
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
            </div>

            <!-- PERMISSIONS -->
            <hr>

            <div class="bbn-grid-full bbn-c"
                 bbn-if="data.cfg.permissions !== 1">
              <div class="bbn-w-100">
                <bbn-radio class="bbn-options-inheritance"
                          bbn-model="data.cfg.permissions"
                          :disabled="!!data.cfg.frozen"
                          bbn-if="permissionsSource.length > 1"
                          :source="permissionsSource"/>
              </div>
              <div class="bbn-w-100 bbn-i"
                  bbn-if="source.permissions"
                  bbn-html="permissionsText">
              </div>
            </div>

            <label><?= _('Default value') ?></label>
            <bbn-dropdown :source="root + 'text_value/' + data.id"
                          :disabled="!!data.cfg.frozen"
                          source-value="id"
                          bbn-model="data.cfg.default_value"
                          placeholder=" - "
                          class="bbn-wide"/>

            <!-- UI PERSONALIZATION -->
            <hr>
            <div class="bbn-grid-full bbn-m bbn-b">
              <?= _('UI Personalization') ?>
            </div>

            <label bbn-if="!data.cfg.categories"><?= _('Hide parent') ?></label>
            <bbn-checkbox bbn-if="!data.cfg.categories"
                          bbn-model.number="data.cfg.noparent"
                          :value="1"
                          :disabled="!!data.cfg.frozen"/>

            <label><?= _('External MV') ?></label>
            <bbn-dropdown id="bbn_options_cfg_model"
                          :nullable="true"
                          :source="controllers"
                          bbn-model="data.cfg.controller"
                          :disabled="!!data.cfg.frozen"
                          placeholder=" - "
                          class="bbn-wide"/>

            <!--<label bbn-if="!data.categories"><?/*=_('Model')*/?></label>
            <bbn-dropdown id="bbn_options_cfg_model"
                          bbn-if="!data.categories"
                          class="bbn-wider"
                          name="model"
                          :source="models"
                          bbn-model="data.model"
                          :disabled="!!data.cfg.inherit_from"
                          placeholder=" - "/>
            <label bbn-if="!data.categories || !data.form"><?/*=_('View')*/?></label>
            <bbn-dropdown id="bbn_options_cfg_view"
                          bbn-if="!data.categories || !data.form"
                          class="bbn-wider"
                          name="view"
                          :source="views"
                          bbn-model="data.view"
                          :disabled="!!data.cfg.inherit_from"
                          placeholder=" - "/>-->

            <label bbn-if="!data.cfg.categories || !data.cfg.view"><?= _('Form') ?></label>
            <bbn-dropdown bbn-if="!data.cfg.categories || !data.cfg.view"
                          :source="views"
                          bbn-model="data.cfg.form"
                          :disabled="!!data.cfg.frozen"
                          placeholder=" - "
                          class="bbn-wide"/>

            <label bbn-if="!showSchema">
              <?= _('Show value') ?>
            </label>
            <bbn-checkbox bbn-if="!showSchema" 
                          bbn-model.number="data.cfg.show_value"
                          :disabled="!!data.cfg.frozen"
                          :value="1"/>

            <!-- INTERNATIONALIZATION -->
            <hr>
            <div class="bbn-grid-full bbn-m bbn-b">
              <?= _('Internationalization') ?>
            </div>

            <label><?= _('Language') ?></label>
            <bbn-dropdown :source="source.languages"
                          bbn-model="data.cfg.i18n"
                          placeholder=" - "
                          source-value="code"
                          :nullable="true"
                          :disabled="!!data.cfg.frozen"
                          class="bbn-wide"/>

            <label class="bbn-options-inheritance"
                  bbn-if="data.cfg.allow_children && data.cfg.i18n">
              <?= _('Language inheritance') ?>
            </label>
            <bbn-radio class="bbn-options-inheritance"
                      bbn-if="data.cfg.allow_children && data.cfg.i18n"
                      bbn-model="data.cfg.i18n_inheritance"
                      :disabled="!!data.cfg.frozen || showScfg"
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

            <!-- USER INFORMATIONS -->
            <hr>
            <div class="bbn-grid-full bbn-m bbn-b">
              <?= _('User informations') ?>
            </div>

            <label><?= _('Description') ?></label>
            <bbn-editable bbn-model="data.cfg.desc"
                          :disabled="!!data.cfg.frozen"
                          :source="{type: 'multilines'}"
                          class="bbn-wider"/>


            <label><?= _('Help') ?></label>
            <bbn-editable bbn-model="data.cfg.desc"
                          :disabled="!!data.cfg.frozen"
                          :source="{type: 'markdown'}"
                          class="bbn-wider"/>

            <!-- ADVANCED -->
            <hr>
            <div class="bbn-grid-full bbn-m bbn-b">
              <?= _('Advanced inheritance manager') ?>
            </div>

            <label bbn-if="data.cfg.allow_children"
                  class="bbn-p">
              <?= _('SubConfigurator') ?>
            </label>
            <bbn-switch bbn-model="showScfg"
                        :disabled="!!data.cfg.frozen"
                        :value="true"
                        :novalue="false"
                        bbn-if="data.cfg.allow_children"/>
          </div>
          <div bbn-if="showScfg && data.cfg.allow_children && data.scfg" class="bbn-box bbn-top-sspace">
            <div class="bbn-header bbn-c bbn-no-border-left bbn-no-border-top bbn-no-border-right bbn-spadding bbn-radius-top-left bbn-radius-top-right"><?= _('SubConfigurator') ?></div>
            <div class="bbn-grid-fields bbn-padding">
              <label bbn-if="!data.scfg.categories">
                <?= _('Use') ?>
              </label>
              <div bbn-if="!data.scfg.categories">
                <bbn-checkbox bbn-model.number="data.scfg.show_code"
                              :disabled="!!data.scfg.frozen"
                              :value="1"
                              label="<?= _('Code') ?>"
                              style="margin-right: 1.5em"/>
                <bbn-checkbox bbn-if="data.scfg.relations === 'alias'"
                              bbn-model.number="data.scfg.notext"
                              :disabled="!!data.scfg.frozen"
                              :value="1"
                              style="margin-right: 1.5em"
                              title="<?= _('Hide the text column') ?>"
                              label="<?= _('No text') ?>"/>
                <bbn-checkbox bbn-model.number="data.scfg.show_icon"
                              :disabled="!!data.scfg.frozen"
                              :value="1"
                              label="<?= _('Icon') ?>"
                              style="margin-right: 1.5em"/>
              </div>

              <label bbn-if="!data.scfg.show_value">
                <?= _('Schema') ?>
              </label>
              <div bbn-if="!data.scfg.show_value">
                <appui-option-schema :source="currentSchema"
                                      class="bbn-w-100 bbn-no-padding"/>
              </div>

              <!-- INTERNAL RELATIONS -->
              <hr>
              <div class="bbn-grid-full bbn-m bbn-b">
                <?= _('Internal relations') ?>
              </div>

              <div class="bbn-grid-full bbn-c">
                <bbn-radio class="bbn-options-relations"
                          bbn-model="data.scfg.relations"
                          :disabled="!!data.scfg.frozen || showScfg"
                          :source="aliasRelations"/>
              </div>
              <label bbn-if="data.scfg.relations === 'template'">
                <?= _('Template used by children') ?>
              </label>
              <bbn-dropdown bbn-if="data.scfg.relations === 'template'"
                            bbn-model="data.scfg.id_template"
                            :source="appui.plugins['appui-option'] + '/data/templates'"
                            :disabled="!!data.scfg.frozen"/>

              <label bbn-if="data.scfg.relations === 'alias'">
                <?= _("Alias' root") ?>
              </label>
              <div class="bbn-flex-width"
                  bbn-if="data.scfg.relations === 'alias'">
                <appui-option-input-picker :disabled="!!data.scfg.frozen"
                                            bbn-model="data.scfg.id_root_alias"/>
              </div>

              <label bbn-if="data.scfg.relations === 'alias'">
                <?= _("Alias' name") ?>
              </label>
              <bbn-input bbn-if="data.scfg.relations === 'alias'"
                        bbn-model="data.scfg.alias_name"
                        :disabled="!!data.scfg.frozen"
                        class="bbn-wide"/>
              <!-- UI PERSONALIZATION -->
              <hr>
              <div class="bbn-grid-full bbn-m bbn-b">
                <?= _('UI Personalization') ?>
              </div>

              <label bbn-if="!data.scfg.categories"><?= _('Hide parent') ?></label>
              <bbn-checkbox bbn-if="!data.scfg.categories"
                            bbn-model.number="data.scfg.noparent"
                            :value="1"
                            :disabled="!!data.scfg.frozen"/>

              <label><?= _('External MV') ?></label>
              <bbn-dropdown id="bbn_options_cfg_model"
                            :nullable="true"
                            :source="controllers"
                            bbn-model="data.scfg.controller"
                            :disabled="!!data.scfg.frozen"
                            placeholder=" - "
                            class="bbn-wide"/>

              <!--<label bbn-if="!data.categories"><?/*=_('Model')*/?></label>
              <bbn-dropdown id="bbn_options_cfg_model"
                            bbn-if="!data.categories"
                            class="bbn-wider"
                            name="model"
                            :source="models"
                            bbn-model="data.model"
                            :disabled="!!data.scfg.inherit_from"
                            placeholder=" - "/>
              <label bbn-if="!data.categories || !data.form"><?/*=_('View')*/?></label>
              <bbn-dropdown id="bbn_options_cfg_view"
                            bbn-if="!data.categories || !data.form"
                            class="bbn-wider"
                            name="view"
                            :source="views"
                            bbn-model="data.view"
                            :disabled="!!data.scfg.inherit_from"
                            placeholder=" - "/>-->

              <label bbn-if="!data.scfg.categories || !data.scfg.view"><?= _('Form') ?></label>
              <bbn-dropdown bbn-if="!data.scfg.categories || !data.scfg.view"
                            :source="views"
                            bbn-model="data.scfg.form"
                            :disabled="!!data.scfg.frozen"
                            placeholder=" - "
                            class="bbn-wide"/>

              <label bbn-if="!showSchema">
                <?= _('Show value') ?>
              </label>
              <bbn-checkbox bbn-if="!showSchema" 
                            bbn-model.number="data.scfg.show_value"
                            :disabled="!!data.scfg.frozen"
                            :value="1"/>
            </div>
          </div>
        </div>
      </bbn-form>
    </div>
  </div>
</div>