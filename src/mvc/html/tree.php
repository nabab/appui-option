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
            <div class="bbn-w-100 bbn-padding">
              <bbn-button bbn-for="b in c.buttons"
                          :action="b.click || undefined"
                          :url="b.url || undefined"
                          :icon="b.icon || undefined"
                          :icon-position="b.iconPosition || 'left'">{{b.text || ''}}</bbn-button>
            </div>
            <div class="bbn-flex-fill bbn-padding"
                 bbn-if="((typeof c.source === 'string') && c.root) || bbn.fn.isArray(c.source)">
              <bbn-tree :source="c.source"
                        uid="id"
                        :root="c.root || undefined"
                        :map="treeMapper"
                        @select="node => c.select(node)"
                        ref="tree"
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
          <bbn-container url="new_paradigm"
                         icon="nf nf-new"
                         title="<?= _("New application") ?>">
            <div class="bbn-padding bbn-background">
              <div class="bbn-section bbn-c">
                <legend><?= _("Your application informations") ?></legend>
                <bbn-form :action="source.root + 'actions/paradigm/create'"
                          :source="newParadigm"
                          @success="onParadigmCreated">
                  <div class="bbn-grid-fields bbn-c">
                    <label><?= _("New application name") ?></label>
                    <bbn-input v-model="newParadigm.text"
                              class="bbn-wide"/>
    
                    <label><?= _("Application code") ?></label>
                    <bbn-input v-model="newParadigm.code"
                              class="bbn-wide"/>
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
                <bbn-form :action="source.root + 'actions/plugin/create'"
                          :source="newPlugin"
                          @success="onPluginCreated">
                  <div class="bbn-grid-fields bbn-c">
                    <label><?= _("New plugin name") ?></label>
                    <bbn-input v-model="newPlugin.text"
                              class="bbn-wide"/>
    
                    <label><?= _("Application code") ?></label>
                    <bbn-input v-model="newPlugin.code"
                              class="bbn-wide"/>
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
