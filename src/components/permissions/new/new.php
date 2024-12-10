<!-- HTML Document -->

<div class="bbn-block bbn-lmargin bbn-lpadding bbn-border bbn-radius">
  <bbn-form class="bbn-w-100"
            :action="parent.root + 'actions/create'"
            :source="newPerm"
            :fixedFooter="false"
            ref="form">
    <div class="bbn-grid-fields">
      <div><?= _('Code') ?></div>
      <bbn-input bbn-model="newPerm.code"
                  required="required"
                  class="bbn-w-100"
                  @keydown.enter.prevent="submitNew"/>

      <div><?= _('Text') ?></div>
      <bbn-input bbn-model="newPerm.text"
                  class="bbn-w-100"
                  required="required"
                  @keydown.enter.prevent="submitNew"/>

      <div><?= _('Help') ?></div>
      <bbn-markdown bbn-model="newPerm.help"/>

    </div>
  </bbn-form>
</div>
