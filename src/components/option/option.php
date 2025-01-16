<div class="bbn-flex-height bbn-overlay appui-option-option">
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
    <appui-option-buttons :source="data.option"/>
    <div class="bbn-bottom-left bbn-vxxspadding bbn-hxspadding">
      <appui-option-breadcrumb :source="data.breadcrumb"/>
    </div>
  </div>
  <div class="bbn-flex-fill">
    <bbn-router bbn-if="data?.option"
                class="bbn-flex-fill"
                :autoload="false"
                :nav="true"
                :master="true"
                @route="onRoute"
                default="values"
                :show-switch="false"
                :breadcrumb="isMobile">
      <bbns-container :url="data.option.id + '/values'"
                      :fixed="true"
                      label="<?= _('Values') ?>"
                      component="appui-option-form"
                      :source="data.option"
                      :load="false"
                      bcolor="teal"
                      fcolor="white"
                      icon="nf nf-fa-list_alt"/>
      <bbns-container :url="data.option.id + '/cfg'"
                      :fixed="true"
                      label="<?= _('Configuration') ?>"
                      component="appui-option-tab-config"
                      :load="false"
                      :source="data"
                      bcolor="sandybrown"
                      fcolor="white"
                      icon="nf nf-fa-gears"/>
      <bbns-container :url="data.option.id + '/preferences'"
                      :fixed="true"
                      label="<?= _('Preferences') ?>"
                      component="appui-option-tab-preferences"
                      bcolor="tomato"
                      fcolor="white"
                      icon="nf nf-md-account_settings_variant"
                      :source="data"
                      :disabled="data.template || data.isApp"/>
      <bbns-container :url="data.option.id + '/stats'"
                      :fixed="true"
                      :disabled="data.isApp"
                      label="<?= _('Stats') ?>"
                      component="appui-option-tab-stats"
                      bcolor="skyblue"
                      fcolor="white"
                      icon="nf nf-fa-bar_chart"
                      :source="data"/>
      <bbns-container :url="data.option.id + '/password'"
                      :fixed="true"
                      :disabled="data.isApp"
                      label="<?= _('Password') ?>"
                      component="appui-option-tab-psw"
                      bcolor="#32a852"
                      fcolor="white"
                      icon="nf nf-md-key"
                      :source="data"/>
      </bbn-router>
    <bbn-loader bbn-else/>
  </div>
</div>