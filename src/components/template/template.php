<div class="bbn-overlay bbn-flex-height">
  <div class="bbn-padding bbn-w-100 bbn-flex-width"
       bbn-if="data"
       :style="{
          backgroundColor: closest('bbn-container').closest('bbn-container').currentBcolor,
          color: closest('bbn-container').closest('bbn-container').currentFcolor,
          height: '4rem',
          alignItems: 'center'
        }"
       bbn-if="data?.option">
    <div class="bbn-flex-fill bbn-b bbn-c bbn-large">
      <?= _("Template") ?> 
      <span bbn-text="data.option.text"/>
    </div>
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
                :show-switch="false"
                :breadcrumb="isMobile">
      <bbns-container :url="data.option.id + '/values'"
                      :fixed="true"
                      label="<?= _('Values') ?>"
                      component="appui-option-template-form"
                      :source="data"
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
    </bbn-router>
    <bbn-loader bbn-else/>
  </div>
</div>