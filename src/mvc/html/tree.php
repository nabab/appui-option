<!-- HTML Document -->
<div class="bbn-overlay appui-option-tree">
  <bbn-splitter :resizable="true" :collapsible="true" orientation="horizontal">
    <bbn-pane :resizable="true" :collapsible="true" :size="300">
      <div class="bbn-overlay"
           ref="container"
           :style="{overflow: 'visible', transition: 'margin-left 0.5s', width: '100% !important', marginLeft: currentPosition}">
        <div bbn-for="c in blocks"
             class="bbn-100 bbn-abs bbn-background"
             :style="{left: c.index ? c.index*100 + '%' : '0px'}"
             bbn-if="(undefined === c.condition) || c.condition()">
          <div class="bbn-flex-height">
            <div class="bbn-w-100 bbn-padding"
                 :style="{
                   backgroundColor: closest('bbn-container').currentBcolor,
                   color: closest('bbn-container').currentFcolor
                 }">
              <div class="bbn-button-group">
                <bbn-button bbn-for="b in c.buttons"
                            :action="b.action || undefined"
                            :url="b.url || undefined"
                            :icon="b.icon || undefined"
                            :disabled="b.menu ? true : false"
                            :icon-position="b.iconPosition || 'left'">
                  <bbn-menu bbn-if="b.menu"
                            :source="b.menu"
                            class="bbn-no-border"/>
                  {{b.menu ? '' : b.text || ''}}
                </bbn-button>
              </div>
            </div>
            <div class="bbn-flex-fill bbn-padding"
                 bbn-if="(changingRoot !== c.id) && ((typeof c.source === 'string') && c.root) || bbn.fn.isArray(c.source)">
              <bbn-tree :source="c.source"
                        uid="id"
                        :root="c.root || undefined"
                        :map="treeMapper"
                        @select="node => c.select(node)"
                        :ref="'tree' + c.id"
                        :draggable="c.draggable"
                        @move="moveOpt"
                        :menu="treeMenu"
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
                    ref="router"
                    class="bbn-overlay">

          <bbn-container url="home"
                         title="<?= _("Home") ?>">
            <div class="bbn-overlay bbn-middle">
              <div class="bbn-card bbn-vmiddle bbn-c bbn-lpadding">
                <div class="bbn-xxxl bbn-c">
                  <?= _("Select Option") ?>
                </div>
              </div>
            </div>
          </bbn-container>

          <bbn-container url="option"
                         title="<?= _("Home") ?>"
                         ref="optionContainer">
            <appui-option-option :source="optionSelected"
                                 bbn-if="optionSelected && isReady"
                                 @route="setDefaultTab"/>
            <bbn-loader bbn-else/>
          </bbn-container>

          <bbn-container url="new_app"
                         icon="nf nf-new"
                         title="<?= _("New application") ?>">
            <div class="bbn-padding bbn-background">
              <div class="bbn-section bbn-c">
                <legend><?= _("Your application informations") ?></legend>
                <bbn-form :action="source.root + 'actions/add'"
                          :source="newItem"
                          @success="onCreate">
                  <div class="bbn-grid-fields bbn-c">
                    <label><?= _("New application name") ?></label>
                    <bbn-input v-model="newItem.text"
                              class="bbn-wide"
                              :required="true"/>
    
                    <label><?= _("Application code") ?></label>
                    <bbn-input v-model="newItem.code"
                               class="bbn-wide"
                               :required="true"/>
                  </div>
                </bbn-form>
              </div>
            </div>
          </bbn-container>

          <bbn-container url="new_plugin"
                         title="<?= _("New Plugin") ?>">
            <div class="bbn-padding bbn-background">
              <div class="bbn-section bbn-c">
                <legend><?= _("Your plugin informations") ?></legend>
                <bbn-form :action="source.root + 'actions/add'"
                          :source="newItem"
                          @success="onCreate">
                  <div class="bbn-grid-fields bbn-c">
                    <label><?= _("New plugin name") ?></label>
                    <bbn-input v-model="newItem.text"
                              class="bbn-wide"
                              :required="true"/>
    
                    <label><?= _("Application code") ?></label>
                    <bbn-input v-model="newItem.code"
                              class="bbn-wide"
                              :required="true"/>
                  </div>
                </bbn-form>
              </div>
            </div>
          </bbn-container>

          <bbn-container url="new_subplugin"
                         title="<?= _("New Subplugin") ?>">
            <div class="bbn-padding bbn-background"
                 bbn-if="currentPlugin">
              <div class="bbn-section bbn-c">
                <legend><?= _("Choose the plugin") ?></legend>
                <bbn-form :action="source.root + 'actions/add'"
                          :source="newAlias"
                          @success="onCreate">
                  <div class="bbn-c bbn-w-100">
                    <h2 bbn-text="_('New subplugin for %s', currentPlugin.code)"/>
                    <label><?= _("Pick the plugin you want to make a subplugin for") ?></label><br><br>
                    <bbn-dropdown v-model="newAlias.id_plugin"
                                  :source="currentPlugin ? source.plugins.filter(a => a.id !== currentPlugin.id) : source.plugins"
                                  source-value="id"
                                  class="bbn-wide"
                                  :required="true"/><br><br>
                  </div>
                </bbn-form>
              </div>
            </div>
          </bbn-container>

          <bbn-container url="new_template"
                         title="<?= _("New Template") ?>">
            <div class="bbn-padding bbn-background"
                 bbn-if="templateSelected">
              <div class="bbn-section bbn-c">
                <legend><?= _("Template information") ?></legend>
                <bbn-form :action="source.root + 'actions/add'"
                          :source="newItem"
                          @success="onCreate">
                          <div class="bbn-grid-fields bbn-c">
                    <label><?= _("Template name") ?></label>
                    <bbn-input v-model="newItem.text"
                              class="bbn-wide"
                              :required="true"/>
    
                    <label><?= _("Template code") ?></label>
                    <bbn-input v-model="newItem.code"
                              class="bbn-wide"
                              :required="true"/>
                  </div>
                </bbn-form>
              </div>
            </div>
          </bbn-container>

          <bbn-container url="new_option"
                         title="<?= _("New Option Category") ?>">
            <div class="bbn-padding bbn-background">
              <div class="bbn-section bbn-c">
                <legend><?= _("Option information") ?></legend>
                <bbn-form :action="source.root + 'actions/add'"
                          :source="newItem"
                          @success="onCreate">
                  <h4>
                    <?= _("We call the option at the root of your applications categories, because theorically they should hold the different options lists") ?>
                  </h4>
                  <div class="bbn-grid-fields bbn-c">
                    <label><?= _("Option name") ?></label>
                    <bbn-input v-model="newItem.text"
                              class="bbn-wide"
                              :required="true"/>
    
                    <label><?= _("Option code") ?></label>
                    <bbn-input v-model="newItem.code"
                              class="bbn-wide"
                              :required="true"/>
                  </div>
                </bbn-form>
              </div>
            </div>
          </bbn-container>

          <bbn-container url="new_alias"
                         title="<?= _("New Alias") ?>">
            <div class="bbn-padding bbn-background">
              <div class="bbn-section bbn-c">
                <legend><?= _("Template information") ?></legend>
                <bbn-form :action="source.root + 'actions/add'"
                          :source="newAlias"
                          @success="onCreate">
                  <div class="bbn-c bbn-w-100">
                    <h2 bbn-text="_('New alias')"/>
                    <label><?= _("Pick the option you want to make a link to") ?></label><br><br>
                  </div>
                </bbn-form>
              </div>
            </div>
          </bbn-container>
        </bbn-router>
      </div>
    </bbn-pane>
  </bbn-splitter>
</div>
