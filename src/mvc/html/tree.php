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
              <div class="bbn-button-group"
                   bbn-if="treeSeen.includes(c.id)">
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
            <div bbn-if="!treeSeen.includes(c.id)"
                class="bbn-flex-fill bbn-middle">
              <div class="bbn-card bbn-padding bbn-block">Hello!</div>
            </div>
            <div class="bbn-flex-fill bbn-hpadding"
                 bbn-elseif="(changingRoot !== c.id) && ((typeof c.source === 'string') && c.root) || bbn.fn.isArray(c.source)">
              <bbn-tree bbn-if="c.source"
                        :source="c.source"
                        uid="id"
                        :selectable="false"
                        :storage-full-name="c.storageName || ''"
                        :storage="c.storage"
                        :root="c.root || undefined"
                        :map="treeMapper"
                        item-component="appui-option-tree-item"
                        :no-data-component="c.noData || null"
                        @nodeclick="node => c.select(node)"
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
                                 @update="onUpdateDataDebug"/>
            <bbn-loader bbn-else
                        class="bbn-overlay bbn-middle"/>
          </bbn-container>
          <!-- INDEX 2 -->
          <bbn-container url="app"
                         label="<?= _("App") ?>"
                         ref="appContainer">
            <appui-option-page-app :source="optionSelected"
                              bbn-if="!routerURL.indexOf('app') && optionSelected && isReady"
                              @update="onUpdateDataDebug"/>
            <bbn-loader bbn-else
                        class="bbn-overlay bbn-middle"/>
          </bbn-container>
          <!-- INDEX 3 -->
          <bbn-container url="template"
                         label="<?= _("Template") ?>"
                         ref="templateContainer">
            <appui-option-template :source="optionSelected"
                                    bbn-if="!routerURL.indexOf('template') && optionSelected && isReady"
                                    @route="setDefaultTemplateTab"
                                    @delete="onDeleteTemplate"
                                    @update="onUpdateDataDebug"/>
            <bbn-loader bbn-else
                        class="bbn-overlay bbn-middle"/>
          </bbn-container>
          <!-- INDEX 4 -->
          <bbn-container url="plugin"
                         label="<?= _("Plugin") ?>"
                         ref="pluginContainer">
            <appui-option-page-plugin :source="optionSelected"
                                 bbn-if="!routerURL.indexOf('plugin') && optionSelected && isReady"
                                 @delete="onDeletePlugin"
                                 @update="onUpdateDataDebug"/>
            <bbn-loader bbn-else
                        class="bbn-overlay bbn-middle"/>
          </bbn-container>
          <!-- INDEX 5 -->
          <bbn-container url="subplugin"
                         label="<?= _("Subplugin") ?>"
                         ref="subpluginContainer">
            <appui-option-page-subplugin :source="optionSelected"
                                         bbn-if="!routerURL.indexOf('subplugin') && optionSelected && isReady"
                                         @delete="onDeleteSubplugin"
                                         @update="onUpdateDataDebug"/>
            <bbn-loader bbn-else
                        class="bbn-overlay bbn-middle"/>
          </bbn-container>
          <!-- INDEX 6 -->
          <bbn-container url="container"
                         label="<?= _("Container") ?>"
                         ref="containerContainer">
            <appui-option-page-container :source="optionSelected"
                                         bbn-if="!routerURL.indexOf('container') && optionSelected && isReady"
                                         @delete="onDeleteContainer"
                                         @update="onUpdateDataDebug"/>
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
