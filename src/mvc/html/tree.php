<!-- HTML Document -->
<div class="bbn-overlay appui-option-tree">
  <bbn-splitter :resizable="true" :collapsible="true" orientation="horizontal">
    <bbn-pane :resizable="true" :collapsible="true" :size="300">
      <div class="bbn-flex-height">
        <bbn-toolbar class="bbn-flex-width bbn-spadded">
          <div class="bbn-flex-fill">
            <bbn-button icon="nf nf-fa-trash"
                        @click="deleteCache"
                        text='<?= _("Delete cache") ?>'/>
          </div>
        </bbn-toolbar>
        <div class="bbn-flex-fill">
          <div class="bbn-overlay">
            <bbn-tree :source="source.root + 'tree'"
                      uid="id"
                      :root="source.cat"
                      :map="treeMapper"
                      @select="treeNodeActivate"
                      ref="listOptions"
                      :draggable="true"
                      @move="moveOpt"
                      :menu="treeMenu"
                      :sortable="true"
                      :storage="true"
                      :storage-full-name="storageName"/>
          </div>
        </div>
      </div>
    </bbn-pane>
    <bbn-pane :resizable="true"
              :collapsible="true">
      <div class="bbn-overlay">
        <bbn-router :autoload="true"
                    :root="routerRoot"
                    :single="true"
                    ref="router"
                    class="bbn-overlay"
                    v-if="optionSelected.id"/>
        <div class="bbn-overlay bbn-middle"
             v-else>
          <div class="bbn-card bbn-vmiddle bbn-c bbn-lpadded">
              <div class="bbn-xxxl bbn-c">
                <?= _("Select Option") ?>
              </div>
          </div>
        </div>
      </div>
    </bbn-pane>
  </bbn-splitter>
</div>
