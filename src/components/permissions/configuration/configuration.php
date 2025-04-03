<!-- HTML Document -->
<div class="bbn-block bbn-lmargin bbn-lpadding bbn-border bbn-radius">
  <bbn-form :action="(url || (parent.root + 'actions/')) + 'update'"
            @success="success"
            :source="source"
            :fixedFooter="false"
            ref="form_cfg">
    <div class="bbn-grid-fields">
      <div><?= _('Type') ?></div>
      <i :class="'nf nf-fa-' + (source.type ? source.type : 'key')"
          style="font-size: large"></i>

      <div><?= _('Code') ?></div>
      <div bbn-if="!source.is_perm"
            bbn-text="source.code"/>
      <bbn-input bbn-else
                  bbn-model="source.code"
                  maxlength="255"/>

      <div><?= _('Text') ?></div>
      <bbn-input bbn-model="source.text"
                 maxlength="255"
                 class="bbn-w-100"/>

      <div><?= _('Help') ?></div>
      <!-- <bbn-editable type="markdown"
                    bbn-model="source.help"/> -->
      <bbn-markdown bbn-model="source.help"/>

      <div><?= _('Public') ?></div>
      <bbn-checkbox bbn-model="source.public"
                    :novalue="0"/>

      <div><?= _('Cascade') ?></div>
      <bbn-checkbox bbn-model="source.cascade"
                    :novalue="0"/>
    </div>
  </bbn-form>
</div>
