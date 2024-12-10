<div class="bbn-padding bbn-background">
  <div class="bbn-section bbn-c">
    <legend><?= _("Your application informations") ?></legend>
    <bbn-form :action="root + 'actions/add'"
              :source="source"
              @success="onCreate">
      <div class="bbn-grid-fields bbn-c">
        <label><?= _("New application name") ?></label>
        <bbn-input bbn-model="source.text"
                  class="bbn-wide"
                  :required="true"/>

        <label><?= _("Application code") ?></label>
        <bbn-input bbn-model="source.code"
                    class="bbn-wide"
                    :required="true"/>
      </div>
    </bbn-form>
  </div>
</div>
