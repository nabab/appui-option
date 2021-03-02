<!-- HTML Document -->

<div class="bbn-lpadded">
  <div class="bbn-w-100 bbn-lpadded bbn-bordered bbn-radius">
    <bbn-form class="bbn-w-100"
              :buttons="[]"
              :fixedFooter="false"
              ref="form_new"
              >
      <div class="bbn-grid-fields">
        <div><?=_('Code')?></div>
        <bbn-input v-model="source.code"
                   required="required"
                   class="bbn-w-100"
                   @keydown.enter.prevent="submitNew"/>

        <div><?=_('Text')?></div>
        <bbn-input v-model="source.text"
                   class="bbn-w-100"
                   required="required"
                   @keydown.enter.prevent="submitNew"/>

        <div><?=_('Help')?></div>
        <bbn-markdown v-model="source.help"/>

        <div class="bbn-grid-full bbn-margin">
          <bbn-button @click="submitNew"
                      icon="nf nf-fa-save">
            <?=_("Save")?>
          </bbn-button>
        </div>
      </div>
    </bbn-form>
  </div>
</div>
