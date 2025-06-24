<!-- HTML Document -->
<div>
  <div class="bbn-padding bbn-centered-block"
       style="min-width: 60%">
    <div class="bbn-vlmargin bbn-card bbn-no-padding">
      <bbn-form :action="root + 'actions/cfg'"
                :source="source.cfg"
                :validation="beforeSend"
                ref="config"
                @success="onSuccess"
                :scrollable="false"
                mode="big">
        <div class="bbn-padding">
          <div class="bbn-w-100 bbn-c bbn-light bbn-lg">
            <?= _('Configuration for the option') ?> <span bbn-text="source.option.text"/> 
          </div>
          <hr>

          <div class="bbn-w-100 bbn-c bbn-m" bbn-if="!source.parentCfg.allow_children">
            <p><?= _("The configuration is only available for elements which are allowed to have children.") ?></p>
            <p><a class="bbn-link" :href="root + 'tree/option/' + source.option.id_parent"><?= _("Review the parent configuration for this option if you wish to modify its settings.") ?></a></p>
          </div>
          <template bbn-else>
            <div class="bbn-grid-fields">
              <!-- OPTIONS UI INFORMATIONS -->
              <div class="bbn-grid-full bbn-m bbn-b">
                <?= _("This option's user information") ?>
              </div>

              <label><?= _('Description') ?></label>
              <bbn-editable bbn-model="source.cfg.desc"
                            :disabled="isFrozen"
                            :source="{type: 'multilines'}"
                            novalue="<?= _('Write an optional description') ?>"
                            class="bbn-wider"/>


              <label><?= _('Help') ?></label>
              <bbn-editable bbn-model="source.cfg.help"
                            :disabled="isFrozen"
                            :source="{type: 'markdown'}"
                            novalue="<?= _('Write a help text if needed') ?>"
                            class="bbn-wider"/>


            </div>
            <hr>

            <div class="bbn-w-100 bbn-c bbn-light bbn-lg">
              <?= _('Configuration for items under this option') ?>
            </div>
            <div bbn-if="cfg.inherit_from"
                class="bbn-w-100 bbn-c bbn-light bbn-lg">
              <?= _('Inherited from') ?> <a :href="root + 'list/' + source.cfg.inherit_from" bbn-text="source.cfg.inherit_from_text"/>
            </div>
            <div bbn-if="showReset"
                style="position: absolute; top: 15px; right: 30px">
              <bbn-button type="button"
                          @click="reset"
                          icon="nf nf-fa-undo"
                          title="<?= _('Back to default') ?>"
                          :notext="true"/>
            </div>
            <hr>
            <appui-option-config-items :source="source.cfg" :option-id="optionId"/>
            <template bbn-if="source.cfg.relations !== 'template'">
              <hr>
              <div class="bbn-w-100 bbn-c bbn-light bbn-lg">
                <?= _('Items inheritance') ?>
              </div>
              <div class="bbn-grid-fields">
                <!-- OPTIONS INHERITANCE -->
                <hr>
                <div class="bbn-grid-full bbn-m bbn-b">
                  <?= _('Options inheritance') ?>
                </div>
  
                <label><?= _('Allow children') ?></label>
                <bbn-checkbox bbn-model.number="source.cfg.allow_children"
                              :value="1"
                              :disabled="isFrozen"/>
  
                <div class="bbn-grid-full bbn-c">
                  <bbn-radio class="bbn-options-inheritance"
                            bbn-if="source.cfg.allow_children"
                            bbn-model="source.cfg.inheritance"
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
                              }, {
                                text: '<?= st::escape(_('Default')) ?>',
                                value: 'default',
                              }]"/>
                </div>
  
                <label bbn-if="cfg.allow_children"
                      class="bbn-p">
                  <?= _("Set rules for items' descendents") ?>
                </label>
                <bbn-switch bbn-model="showScfg"
                            :disabled="isFrozen"
                            :value="true"
                            :novalue="false"
                            bbn-if="cfg.allow_children"/>
              </div>
              <div bbn-if="showScfg && source.cfg.allow_children" class="bbn-box bbn-top-sspace">
                <div class="bbn-header bbn-c bbn-no-border-left bbn-no-border-top bbn-no-border-right bbn-spadding bbn-radius-top-left bbn-radius-top-right"><?= _('Descendents configuration') ?></div>
  
                <appui-option-config-items class="bbn-padding" :source="source.cfg.scfg" :option-id="optionId"/>
  
                <div class="bbn-grid-fields bbn-padding">
                  <!-- OPTIONS INHERITANCE -->
                  <hr>
                  <div class="bbn-grid-full bbn-m bbn-b">
                    <?= _('Options inheritance') ?>
                  </div>
  
                  <label><?= _('Allow children') ?></label>
                  <bbn-checkbox bbn-model.number="source.cfg.scfg.allow_children"
                                :value="1"
                                :disabled="isFrozen"/>
                </div>
              </div>
            </template>
          </template>
        </div>
      </bbn-form>
    </div>
  </div>
</div>