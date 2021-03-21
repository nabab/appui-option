<!-- HTML Document -->
<div class="bbn-lpadded">
  <div class="bbn-w-100 bbn-lpadded bbn-bordered bbn-radius">
    <bbn-form :action="(url || (parent.root + 'actions/')) + 'update'"
              @success="success"
              :source="source"
              :fixedFooter="false"
              ref="form_cfg"
              >
      <div class="bbn-grid-fields">
        <div><?=_('Type')?></div>
        <i :class="'nf nf-fa-' + (source.type ? source.type : 'key')"
           style="font-size: large"></i>

        <div><?=_('Code')?></div>
        <div v-if="!source.is_perm"
             v-text="source.code"
             ></div>
        <bbn-input v-else
                   v-model="source.code"
                   maxlength="255"/>

        <div><?=_('Text')?></div>
        <bbn-input v-model="source.text" maxlength="255"
                   @keydown.enter.prevent="submitConf"
                   class="bbn-w-100"/>

        <div><?=_('Help')?></div>
        <bbn-markdown v-model="source.help"/>


        <div><?=_('Public')?></div>
        <bbn-checkbox v-model="source.public"/>

        <div><?=_('Cascade')?></div>
        <bbn-checkbox v-model="source.cascade"/>
      </div>
    </bbn-form>
  </div>
</div>
