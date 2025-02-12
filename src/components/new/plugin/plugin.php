<div class="bbn-padding bbn-background">
  <div class="bbn-section bbn-c">
    <legend><?= _("Your plugin informations") ?></legend>
    <bbn-form :action="root + 'actions/add/plugin'"
              :source="source"
              @success="onCreate"
              :validation="validate">
      <div class="bbn-grid-fields bbn-c">
        <label><?= _("New plugin name") ?></label>
        <bbn-input bbn-model="source.text"
                  class="bbn-wide"
                  :required="true"/>

        <label><?= _("Application code") ?></label>
        <bbn-input bbn-model="source.code"
                  class="bbn-wide"
                  :required="true"/>

        <label><?= _("Prefix") ?></label>
        <div>
          <bbn-radio bbn-model="currentPrefix"
                     :source="prefixes"
                     :required="true"
                     :nullable="true"/><br>
          <bbn-input bbn-if="currentPrefix === 'other'"
                    bbn-model="source.prefix"
                    class="bbn-wide"
                    :required="true"/>
        </div>
      </div>
    </bbn-form>
  </div>
</div>
