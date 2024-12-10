<div class="bbn-padding bbn-background">
  <div class="bbn-section bbn-c">
    <legend><?= _("Template information") ?></legend>
    <bbn-form :action="root + 'actions/add'"
              :source="source"
              @success="onCreate">
              <div class="bbn-grid-fields bbn-c">
        <label><?= _("Template name") ?></label>
        <bbn-input bbn-model="source.text"
                  class="bbn-wide"
                  :required="true"/>

        <label><?= _("Template code") ?></label>
        <bbn-input bbn-model="source.code"
                  class="bbn-wide"
                  :required="true"/>
      </div>
    </bbn-form>
  </div>
</div>
