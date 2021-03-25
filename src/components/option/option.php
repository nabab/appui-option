<div class="bbn-flex-height bbn-overlay">
  <bbn-toolbar class="bbn-spadded bbn-flex-width">
    <div class="bbn-flex-fill bbn-b bbn-c bbn-large" v-text="source.option.text"></div>
    <div>
      <bbn-button icon="nf nf-fa-link"
                  @click="linkOption"
                  :text="'<?=_('Go to')?> ' + source.option.text"
                  :notext="true"
      ></bbn-button>
      <bbn-button icon="nf nf-fa-history"
                  @click="deleteCache"
                  text="<?=_('Delete cache option')?>"
                  :notext="true"
                  class="bbn-hsmargin"
      ></bbn-button>
      <bbn-button icon="nf nf-fa-trash_o"
                  @click="removeOpt"
                  title="<?=_('Remove option from db')?>"
                  text="<?=_('Remove')?>"
                  :notext="true"
      ></bbn-button>
      <bbn-button icon="nf nf-fa-trash"
                  @click="removeOptHistory"
                  title="<?=_('Remove option\'s history')?>"
                  v-if="isAdmin"
                  text="<?=_('Remove history')?>"
                  class="bbn-hsmargin bbn-bg-red"
                  :notext="true"
      ></bbn-button>
    </div>
  </bbn-toolbar>
  <div class="bbn-flex-fill">
    <bbn-router class="bbn-flex-fill"
                :autoload="false"
                :nav="true"
                :master="true"
                :show-switch="false"
                :breadcrumb="isMobile"
    >
      <bbns-container url="values"
                      :static="true"
                      title="<?=_('Values')?>"
                      component="appui-option-form"
                      :source="source.option"
                      :load="false"
                      bcolor="teal"
                      fcolor="white"
                      icon="nf nf-fa-list_alt"
      ></bbns-container>
      <bbns-container url="cfg"
                      :static="true"
                      title="<?=_('Configuration')?>"
                      component="appui-option-config"
                      :load="false"
                      :source="source"
                      bcolor="sandybrown"
                      fcolor="white"
                      icon="nf nf-fa-gears"
      ></bbns-container>
      <bbns-container url="preferences"
                      :static="true"
                      title="<?=_('My preferences')?>"
                      component="appui-option-preferences"
                      bcolor="yellowgreen"
                      fcolor="white"
                      icon="nf nf-mdi-account_settings_variant"
                      :source="source"
                      v-if="isAdmin"
      ></bbns-container>
      <bbns-container url="upreferences"
                      :static="true"
                      title="<?=_('Users preferences')?>"
                      component="appui-option-preferences"
                      bcolor="tomato"
                      fcolor="white"
                      icon="nf nf-fa-users"
                      :source="source"
                      v-if="isAdmin"
      ></bbns-container>
      <bbns-container url="stats"
                      :static="true"
                      title="<?=_('Stats')?>"
                      component="appui-option-stats"
                      bcolor="skyblue"
                      fcolor="white"
                      icon="nf nf-fa-bar_chart"
                      :source="source"
      ></bbns-container>
      <bbns-container url="password"
                      :static="true"
                      title="<?=_('Password')?>"
                      component="appui-option-psw"
                      bcolor="#32a852"
                      fcolor="white"
                      icon="nf nf-mdi-key"
                      :source="source"
                      v-if="isAdmin"
      ></bbns-container>
    </bbn-router>
  </div>
</div>