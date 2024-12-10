<div class="bbn-padding bbn-background">
  <div class="bbn-section bbn-c">
    <legend><?= _("Template information") ?></legend>
    <bbn-form :action="root + 'actions/add'"
              :source="source"
              @success="onCreate">
      <div class="bbn-c bbn-w-100">
        <h2 bbn-text="_('New alias')"/>
        <label><?= _("Pick the option you want to make a link to") ?></label><br><br>
        <appui-option-input-picker :nullable="false"
                                   bbn-model="source.id_alias"/>
      </div>
    </bbn-form>
  </div>
</div>
