<!-- HTML Document -->
<bbn-splitter :resizable="true" :collapsible="true" orientation="horizontal">
  <bbn-pane :resizable="true" :collapsible="true" :size="450">
    <div class="bbn-flex-height">
      <bbn-toolbar class="bbn-flex-width bbn-spadded">
        <div class="bbn-flex-fill">
          <bbn-button icon="nf nf-fa-trash"
                      @click="deleteCache"
                      text='<?=_("Delete cache")?>'
          ></bbn-button>
        </div>
        <div v-if="source.is_admin"
             class="bbn-vmiddle"
        >
          <span :class="['bbn-b', 'bbn-i', {'bbn-primary-text-alt': !appuiTree}]"><?=_('App.')?></span>
          <bbn-switch v-model="appuiTree"
                      :novalue="false"
                      off-icon="nf nf-fa-arrow_left"
                      on-icon="nf nf-fa-arrow_right"
                      :no-icon="false"
                      class="bbn-hsmargin"
          ></bbn-switch>
          <span :class="['bbn-b', 'bbn-i', {'bbn-primary-text-alt': appuiTree}]"><?=_('Appui')?></span>
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
                    :storage-full-name="storageName"
          ></bbn-tree>
        </div>
      </div>
    </div>
  </bbn-pane>
  <bbn-pane :resizable="true" :collapsible="true">
    <bbn-router :autoload="true"
                :root="routerRoot"
                :single="true"
                ref="router"
                class="bbn-overlay"
    ></bbn-router>
    <div class="bbn-overlay bbn-middle" v-if="$refs.router && !$refs.router.activeContainer">
      <div class="bbn-card bbn-vmiddle bbn-c bbn-lpadded">
          <div class="bbn-xxxl bbn-c">
            <?=_("Select Option")?>
          </div>
      </div>
    </div>
  </bbn-pane>
</bbn-splitter>