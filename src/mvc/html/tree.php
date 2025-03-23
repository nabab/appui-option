<!-- HTML Document -->
<div class="bbn-overlay appui-option-tree">
  <bbn-splitter :resizable="true" :collapsible="true" orientation="horizontal">
    <bbn-pane :resizable="true" :collapsible="true" :size="300" :scrollable="false">
      <div class="bbn-100"
           ref="container"
           :style="{overflow: 'visible', transition: 'margin-left 0.5s', width: '100% !important', marginLeft: currentPosition}">
        <div bbn-for="c in blocks"
             class="bbn-100 bbn-abs bbn-background"
             :style="{left: c.index ? (c.index*100) + '%' : '0px'}"
             key="id"
             bbn-if="(undefined === c.condition) || c.condition()">
          <div class="bbn-flex-height">
            <div class="bbn-hpadding"
                 :style="{
                   backgroundColor: closest('bbn-container').currentBcolor,
                   color: closest('bbn-container').currentFcolor,
                   height: '4rem',
                   alignItems: 'center',
                   display: 'flex'
                 }">
              <div class="bbn-button-group">
                <bbn-button bbn-for="b in c.buttons"
                            :action="b.action || undefined"
                            :url="b.url || undefined"
                            :icon="b.icon || undefined"
                            :disabled="b.menu ? true : false"
                            :icon-position="b.iconPosition || 'left'"
                            :style="b.menu ? {padding: '0px'} : ''">
                  <bbn-menu bbn-if="b.menu"
                            :source="b.menu"
                            class="bbn-no-border"/>
                  {{b.menu ? '' : b.text || ''}}
                </bbn-button>
              </div>
            </div>
            <h3 class="bbn-c bbn-hxspadding bbn-vpadding bbn-no-margin"
                bbn-text="c.label"/>
            <div class="bbn-flex-fill bbn-hpadding"
                 bbn-if="(changingRoot !== c.id) && ((typeof c.source === 'string') && c.root) || bbn.fn.isArray(c.source)">
              <bbn-tree :source="c.source"
                        uid="id"
                        :storage="true"
                        :storage-full-name="'appui-options-tree-' + c.id"
                        :root="c.root || undefined"
                        :map="treeMapper"
                        item-component="appui-option-tree-item"
                        :no-data-component="c.noData || null"
                        @select="node => c.select(node)"
                        :ref="'tree' + c.id"
                        :drag="c.draggable"
                        @move="moveOpt"
                        :menu="getTreeMenu"
                        :multiple="false"
                        :sortable="c.draggable"/>
            </div>
          </div>
        </div>
      </div>
    </bbn-pane>
    <bbn-pane :resizable="true"
              :collapsible="true">
      <div class="bbn-overlay">
        <bbn-router :root="routerRoot"
                    :autoload="false"
                    :url="routerURL"
                    ref="router"
                    class="bbn-overlay">
          <!-- INDEX 0 -->
          <bbn-container url="home"
                         label="<?= _("Home") ?>"
                         component="appui-option-page-home"/>
          <!-- INDEX 1 -->
          <bbn-container url="option"
                         label="<?= _("Option") ?>"
                         ref="optionContainer">
            <appui-option-option :source="optionSelected"
                                 bbn-if="!routerURL.indexOf('option') && optionSelected && isReady"
                                 @route="setDefaultTab"
                                 @deleteapp="onDeleteApp"
                                 @deleteplugin="onDeletePlugin"
                                 @deletesubplugin="onDeleteSubplugin"
                                 @delete="onDelete"
                                 @update="d => debug = JSON.stringify(d, null, 2)"/>
            <bbn-loader bbn-else
                        class="bbn-overlay bbn-middle"/>
          </bbn-container>
          <!-- INDEX 2 -->
          <bbn-container url="app"
                         label="<?= _("App") ?>"
                         ref="appContainer">
            <appui-option-page-app :source="optionSelected"
                              bbn-if="!routerURL.indexOf('app') && optionSelected && isReady"
                              @delete="onDeleteApp"
                              @update="d => debug = JSON.stringify(d, null, 2)"/>
            <bbn-loader bbn-else
                        class="bbn-overlay bbn-middle"/>
          </bbn-container>
          <!-- INDEX 3 -->
          <bbn-container url="template"
                         label="<?= _("Template") ?>"
                         ref="templateContainer">
            <appui-option-template :source="optionSelected"
                                    bbn-if="!routerURL.indexOf('template') && optionSelected && isReady"
                                    @delete="onDeleteTemplate"/>
            <bbn-loader bbn-else
                        class="bbn-overlay bbn-middle"/>
          </bbn-container>
          <!-- INDEX 4 -->
          <bbn-container url="plugin"
                         label="<?= _("Plugin") ?>"
                         ref="pluginContainer">
            <appui-option-page-plugin :source="optionSelected"
                                 bbn-if="!routerURL.indexOf('plugin') && optionSelected && isReady"
                                 @delete="onDeletePlugin"/>
            <bbn-loader bbn-else
                        class="bbn-overlay bbn-middle"/>
          </bbn-container>
          <!-- INDEX 5 -->
          <bbn-container url="subplugin"
                         label="<?= _("Subplugin") ?>"
                         ref="subpluginContainer">
            <appui-option-page-subplugin :source="optionSelected"
                                    bbn-if="!routerURL.indexOf('subplugin') && optionSelected && isReady"
                                    @delete="onDeleteSubplugin"/>
            <bbn-loader bbn-else
                        class="bbn-overlay bbn-middle"/>
          </bbn-container>
        </bbn-router>
      </div>
    </bbn-pane>
    <bbn-pane bbn-if="appui.user.isAdmin"
              :resizable="true"
              :collapsible="true"
              :collapsed="true"
              :size="250">
      <bbn-json-editor v-model="debug"
                       :readonly="true"/>
    </bbn-pane>
  </bbn-splitter>
</div>
