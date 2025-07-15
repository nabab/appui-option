<div class="bbn-flex-height bbn-overlay appui-option-option">
  <appui-option-loader :source="source"/>
  <div class="bbn-padding bbn-w-100 bbn-flex-width"
       :style="{
          backgroundColor: closest('bbn-container').closest('bbn-container').currentBcolor,
          color: closest('bbn-container').closest('bbn-container').currentFcolor,
          height: '4rem',
          alignItems: 'center'
        }"
       bbn-if="data?.option">
    <div class="bbn-flex-fill bbn-b bbn-c bbn-large"
         bbn-text="data.option.text"/>
    <appui-option-buttons :source="data"
                          @deleteapp="a => $emit('deleteapp', a)"
                          @deleteplugin="a => $emit('deleteplugin', a)"
                          @deletesubplugin="a => $emit('deletesubplugin', a)"
                          @delete="a => $emit('delete', a)"/>
    <div class="bbn-bottom-left bbn-vxxspadding bbn-hxspadding">
      <appui-option-breadcrumb :source="data.breadcrumb"/>
    </div>
  </div>
  <div class="bbn-flex-fill">
    <div bbn-if="data?.usedTemplate && (data.usedTemplate !== data.option.id_alias)"
         class="bbn-lpadding bbn-card bbn-centered-block bbn-vlmargin">
      <div class="bbn-message-info bbn-i bbn-c bbn-light bbn-bottom-margin"
           bbn-text="_('This option cannot be modified as it is part of the template %s', data.template.text)"/>
      <div class="bbn-grid-fields bbn-c bbn-bottom-margin">
        <div><?= _("Option's ID") ?></div>
        <div bbn-text="data.option.id"/>
        <div><?= _("Template's ID") ?></div>
        <div bbn-text="data.option.alias.id"/>
        <div><?= _("Template's text") ?></div>
        <div bbn-text="data.option.alias.text"/>
        <div><?= _("Template's code") ?></div>
        <div bbn-if="data.option.code === data.option.alias.code"
             bbn-text="data.option.code"/>
        <div bbn-else
             class="bbn-state-error">
          <?= _("This option's code is not the same as the template's one") ?>:
          <span bbn-text="data.option.code + ' / ' + data.option.alias.code"/>
        </div>
      </div>
      <div class="bbn-w-100"
            bbn-if="data.realCfg">
        <div class="bbn-card bbn-message-error bbn-centered-block bbn-spadding bbn-c">
          <?= _("Configuration for this option is set but is not taken into account") ?><br><br>
          <bbn-button @click="deleteConfig"
                      icon="nf nf-fa-trash"
                      :label="_('Delete configuration')"/>
        </div>
      </div>
      <div class="bbn-w-100"
            bbn-if="data.option.text || data.option.value">
        <div class="bbn-card bbn-message-error bbn-centered-block bbn-spadding bbn-c">
          <?= _("Some values for this option are set but are not taken into account") ?><br><br>
          <bbn-button @click="deleteValues"
                      icon="nf nf-fa-trash"
                      :label="_('Delete values')"/>
        </div>
      </div>
    </div>
    <bbn-router bbn-elseif="data?.option"
                class="bbn-100"
                :autoload="false"
                :nav="true"
                :master="true"
                ref="router"
                @notfound="onNotFound"
                @route="onRoute"
                default="values"
                :show-switch="false"
                :breadcrumb="isMobile">
      <bbn-container :url="data.option.id + '/values'"
                      :fixed="true"
                      label="<?= _('Values') ?>"
                      :load="false"
                      bcolor="teal"
                      fcolor="white"
                      icon="nf nf-fa-list_alt">
        <div class="bbn-padding bbn-centered-block">
          <appui-option-form :source="data.option" :configuration="data.parentCfg"/>
        </div>
      </bbn-container>
      <bbn-container :url="data.option.id + '/cfg'"
                      :fixed="true"
                      label="<?= _('Configuration') ?>"
                      component="appui-option-config"
                      :load="false"
                      :source="data"
                      bcolor="sandybrown"
                      fcolor="white"
                      icon="nf nf-fa-gears"/>
      <bbn-container :url="data.option.id + '/preferences'"
                      :fixed="true"
                      label="<?= _('Preferences') ?>"
                      component="appui-option-preferences"
                      bcolor="tomato"
                      fcolor="white"
                      icon="nf nf-md-account_settings_outline"
                      :source="data"
                      :disabled="!!(data.template || data.isApp)"/>
      <bbn-container :url="data.option.id + '/stats'"
                      :fixed="true"
                      :disabled="data.isApp"
                      label="<?= _('Stats') ?>"
                      component="appui-option-stats"
                      bcolor="skyblue"
                      fcolor="white"
                      icon="nf nf-fa-bar_chart"
                      :source="data"/>
      <bbn-container :url="data.option.id + '/password'"
                      :fixed="true"
                      :disabled="data.isApp"
                      label="<?= _('Password') ?>"
                      component="appui-option-psw"
                      bcolor="#32a852"
                      fcolor="white"
                      icon="nf nf-md-key"
                      :source="data"/>
    </bbn-router>
    <bbn-loader bbn-elseif="isLoading"
                class="bbn-overlay bbn-middle"/>
    <div bbn-else
          class="bbn-overlay bbn-middle">
      <div class="bbn-xxl bbn-block bbn-padding bbn-radius bbn-border">
        <?= _("Option not found") ?>
      </div>
    </div>
  </div>
</div>