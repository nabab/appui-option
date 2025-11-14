<!-- HTML Document -->
<div class="bbn-overlay">
  <bbn-splitter orientation="vertical">
    <bbn-pane :size="40">
      <bbn-toolbar class="bbn-permissions-toolbar">
        <bbn-radio :source="modes"
                   bbn-model="mode"/>
        <div class="bbn-toolbar-separator"/>
        <bbn-dropdown :source="source.sources"
                      source-text="text"
                      :source-value="mode === 'access' ? 'rootAccess' : 'rootOptions'"
                      bbn-model="currentSource"/>
        <div class="bbn-toolbar-separator"/>
        <bbn-button icon="nf nf-fa-refresh"
                    :notext="true"
                    title="<?= _("Refresh all permissions") ?>"
                    @click="refresh"/>
        <bbn-button icon="nf nf-md-broom"
                    :notext="true"
                    title="<?= _("Clean up permissions (delete obsoletes)") ?>"
                    @click="cleanUp"/>
        <div class="bbn-toolbar-separator"/>
        <div bbn-if="selected && selected.path"
             class="bbn-lg bbn-b">
          <a :href="selected.path"
             :title="_('Go to') + ' ' + selected.path"
             bbn-text="selected.text"/>
        </div>
        <div bbn-else
             class="bbn-lg bbn-b">
          <?= _("No item selected") ?>
        </div>
        <div class="bbn-toolbar-separator"
             bbn-if="selected && selected.path"
             class="bbn-toolbar-separator"/>
        <bbn-button bbn-if="selected && !selected.isFile && !selected.items"
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
                    :resizable="true">
        <bbn-pane :collapsible="true"
                  :size="350"
                  :resizable="true"
                  :scrollable="false">
          <!-- Tree -->
          <bbn-tree :source="root + 'tree'"
                    uid="id"
                    :data="{mode: mode}"
                    :scrollable="true"
                    :root="currentSource"
                    :map="treeMapper"
                    @select="permissionSelect"
                    ref="tree"
                    class="bbn-permissions-list bbn-overlay"/>
        </bbn-pane>
        <bbn-pane :collapsible="true" :resizable="true">
          <div class="bbn-permissions-form bbn-100">
            <div bbn-if="selected" class="bbn-overlay bbn-border">
              <bbn-panelbar class="bbn-100"
                            :flex="true"
                            @select="changeSection"
                            :multiple="true"
                            :opened="currentSection"
                            :source="panelSource"/>
            </div>
            <div bbn-else
                 class="bbn-overlay bbn-middle">
              <div class="bbn-xl bbn-block"><?= _("Select an item...") ?></div>
            </div>
            <div class="bbn-overlay bbn-modal bbn-middle"
                 bbn-if="selected.type === 'folder'">
              <div class="bbn-xlpadding bbn-xl bbn-background"
                   bbn-text="_('No permission on folder')"/>
            </bbn-floater>
          </div>
        </bbn-pane>
      </bbn-splitter>
    </bbn-pane>
  </bbn-splitter>
  