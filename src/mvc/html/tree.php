<!-- HTML Document -->
<div class="bbn-overlay appui-option-tree">
  <bbn-splitter :resizable="true" :collapsible="true" orientation="horizontal">
    <bbn-pane :resizable="true" :collapsible="true" :size="300">
      <div class="bbn-flex-height">
        <bbn-toolbar class="bbn-flex-width bbn-spadded">
          <div class="bbn-flex-fill">
            <bbn-button icon="nf nf-fa-trash"
                        @click="deleteCache"
                        text='<?=_("Delete cache")?>'/>
          </div>
          <div bbn-if="source.is_admin"
               class="bbn-vmiddle">
            <span :class="['bbn-b', 'bbn-i', {'bbn-primary-text-alt': !appuiTree}]"><?=_('App.')?></span>
            <bbn-switch bbn-model="appuiTree"
                        :novalue="false"
                        :value="true"
                        off-icon="nf nf-fa-arrow_left"
                        on-icon="nf nf-fa-arrow_right"
                        :no-icon="false"
                        class="bbn-hsmargin"/>
            <span :class="['bbn-b', 'bbn-i', {'bbn-primary-text-alt': appuiTree}]"><?=_('Root')?></span>
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
                      :data="dataObj"
                      :menu="treeMenu"
                      :multiple="false"
                      :sortable="true"
                      :storage="true"
                      @dataloaded="delete dataObj.appuiTree"
                      :storage-full-name="storageName"/>
          </div>
        </div>
      </div>
    </bbn-pane>
    <bbn-pane :resizable="true"
              :collapsible="true">
      <div bbn-if="optionSelected.id"
           class="bbn-overlay">
        <bbn-router :autoload="true"
                    :root="routerRoot"
                    :single="true"
                    ref="router"
                    class="bbn-overlay"/>
      </div>
      <div class="bbn-overlay bbn-middle"
            bbn-else>
        <div class="bbn-card bbn-vmiddle bbn-c bbn-lpadded">
          <div class="bbn-xxxl bbn-c">
            <?= _("Select Option") ?>
          </div>
        </div>
      </div>
    </bbn-pane>
  </bbn-splitter>
</div>
