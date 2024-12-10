<div class="bbn-padding bbn-background"
      bbn-if="currentPlugin">
  <div class="bbn-section bbn-c">
    <legend><?= _("Choose the plugin") ?></legend>
    <bbn-form :action="root + 'actions/add'"
              :source="newAlias"
              @success="onCreate">
      <div class="bbn-c bbn-w-100">
        <h2 bbn-text="_('New subplugin', currentPlugin?.code)"/>
        <label><?= _("Pick the plugin you want to make a subplugin for") ?></label><br><br>
        <bbn-dropdown bbn-model="newAlias.id_plugin"
                      :source="currentPlugin ? source.plugins.filter(a => a.id !== currentPlugin.id) : source.plugins"
                      source-value="id"
                      class="bbn-wide"
                      :required="true"/><br><br>
      </div>
    </bbn-form>
  </div>
</div>
