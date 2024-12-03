<div class="bbn-flex-height bbn-overlay appui-option-option">
  <div class="bbn-header bbn-spadding bbn-w-100 bbn-flex-width"
       bbn-if="data?.option">
    <div class="bbn-flex-fill bbn-b bbn-c bbn-large"
         bbn-text="data.option.text"/>
    <div>
      <bbn-button icon="nf nf-fa-link"
                  @click="linkOption"
                  :text="'<?= _('Go to') ?> ' + data.option.text"
                  :notext="true"/>
      <bbn-button icon="nf nf-fa-history"
                  @click="deleteCache"
                  text="<?= _('Delete cache option') ?>"
                  :notext="true"
                  class="bbn-hsmargin"/>
      <bbn-button icon="nf nf-fa-trash_o"
                  @click="removeOpt"
                  title="<?= _('Remove option from db') ?>"
                  text="<?= _('Remove') ?>"
                  :notext="true"/>
      <bbn-button icon="nf nf-fa-trash"
                  @click="removeOptHistory"
                  title="<?= _('Remove option\'s history') ?>"
                  bbn-if="isAdmin"
                  text="<?= _('Remove history') ?>"
                  class="bbn-hsmargin bbn-bg-red"
                  :notext="true"/>
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
                      bbn-if="!data.isApp"
                      title="<?= _('Values') ?>"
                      component="appui-option-form"
                      :source="data.option"
                      :load="false"
                      bcolor="teal"
                      fcolor="white"
                      icon="nf nf-fa-list_alt"/>
      <bbns-container :url="data.option.id + '/cfg'"
                      :fixed="true"
                      :disabled="data.isApp"
                      title="<?= _('Configuration') ?>"
                      component="appui-option-config"
                      :load="false"
                      :source="data"
                      bcolor="sandybrown"
                      fcolor="white"
                      icon="nf nf-fa-gears"/>
      <bbns-container :url="data.option.id + '/preferences'"
                      :fixed="true"
                      title="<?= _('Preferences') ?>"
                      component="appui-option-preferences"
                      bcolor="tomato"
                      fcolor="white"
                      icon="nf nf-mdi-account_settings_variant"
                      :source="data"
                      :disabled="data.template || data.isApp"/>
      <bbns-container :url="data.option.id + '/stats'"
                      :fixed="true"
                      :disabled="data.isApp"
                      title="<?= _('Stats') ?>"
                      component="appui-option-stats"
                      bcolor="skyblue"
                      fcolor="white"
                      icon="nf nf-fa-bar_chart"
                      :source="data"/>
      <bbns-container :url="data.option.id + '/password'"
                      :fixed="true"
                      :disabled="data.isApp"
                      title="<?= _('Password') ?>"
                      component="appui-option-psw"
                      bcolor="#32a852"
                      fcolor="white"
                      icon="nf nf-mdi-key"
                      :source="data"/>
    </bbn-router>
    <bbn-loader bbn-else/>
  </div>
</div>