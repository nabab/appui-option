<!-- HTML Document -->
<bbn-splitter orientation="vertical">
  <bbn-pane :size="40">
    <bbn-toolbar class="bbn-permissions-toolbar bbn-widget bbn-hspadded bbn-h-100">
      <bbn-dropdown :source="modes"
                    class="bbn-narrow"
                    v-model="mode"/>
      <div class="bbn-toolbar-separator">
      </div>
      <bbn-dropdown :source="source.sources"
                    source-text="text"
                    :source-value="mode === 'access' ? 'rootAccess' : 'rootOptions'"
                    v-model="currentSource"/>
      <div class="bbn-toolbar-separator">
      </div>
      <bbn-button icon="nf nf-fa-refresh"
                  :notext="true"
                  title="<?= _("Refresh all permissions") ?>"
                  @click="refresh"/>
      <bbn-button icon="nf nf-mdi-broom"
                  :notext="true"
                  title="<?= _("Clean up permissions (delete obsoletes)") ?>"
                  @click="cleanUp"/>
      <div class="bbn-toolbar-separator">
      </div>
      <div v-if="selected && selected.path"
           class="bbn-lg bbn-b">
        <a :href="selected.path"
           :title="_('Go to') + ' ' + selected.path"
           v-text="selected.text"/>
      </div>
      <div v-else
           class="bbn-lg bbn-b">
        <?= _("No item selected") ?>
      </div>
      <div v-if="selected && selected.path"
           class="bbn-toolbar-separator">
      </div>
      <bbn-button v-if="selected && !selected.isFile && !selected.items"
                  class="bbn-red"
                  icon="nf nf-fa-times"
                  title="<?= _("Delete") ?>"
                  @click="delPerm"/>
    </bbn-toolbar>
    <!-- Toolbar -->
  </bbn-pane>
  <bbn-pane>
    <bbn-splitter orientation="horizontal"
                  :collapsible="true"
                  :resizable="true"
    >
      <bbn-pane :collapsible="true"
                :size="350"
                :resizable="true">
        <!-- Tree -->
        <bbn-tree :source="root + 'tree'"
                  uid="id"
                  :data="{mode: mode}"
                  :root="currentSource"
                  :map="treeMapper"
                  @select="permissionSelect"
                  ref="tree"
                  class="bbn-permissions-list"
        ></bbn-tree>
      </bbn-pane>
      <bbn-pane :collapsible="true" :resizable="true">
        <div class="bbn-permissions-form bbn-100">
          <div v-if="selected" class="bbn-overlay bbn-bordered">
            <bbn-panelbar class="bbn-100"
                          :flex="true"
                          @select="changeSection"
                          :opened="currentSection"
                          :source="panelSource"/>
          </div>
          <div v-else
               class="bbn-overlay bbn-middle">
            <div class="bbn-xl bbn-block"><?= _("Select an item...") ?></div>
          </div>
        </div>
      </bbn-pane>
    </bbn-splitter>
  </bbn-pane>
</bbn-splitter>