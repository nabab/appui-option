<div class="bbn-overlay bbn-flex-height">
  <div class="bbn-flex-fill">
    <bbn-scroll>
      <div class="bbn-padding bbn-centered-block">
        <div class="bbn-card bbn-vlmargin">
          <bbn-form :action="root + 'actions/' + (source.option.id ? 'update' : 'insert')"
                    :source="source.option"
                    @success="success" 
                    :scrollable="false"
                    mode="big">
            <div class="bbn-grid-fields bbn-padding">
              <div><?= _('ID') ?></div>
              <div bbn-text="source.option.id"/>
  
              <div><?= _("Template's name") ?></div>
              <bbn-input bbn-model="source.option.text"
                        class="bbn-wide"
                        :required="true"/>
  
              <div><?= _("Template's code") ?></div>
              <bbn-input bbn-model="source.option.code"
                         class="bbn-wide"
                         :required="true"/>
  
              <div><?= _('Icon') ?></div>
              <div class="bbn-middle"
                   style="justify-content: flex-start">
                <div class="bbn-box bbn-xspadding bbn-right-sspace">
                  <i :class="['bbn-xxxlarge', 'bbn-block', currentIcon]"
                    :title="currentIcon"
                    bbn-if="currentIcon"/>
                  <div bbn-else style="width: 2em; height: 2em"/>
                </div>
                <bbn-button @click="selectIcon"><?= _("Browse") ?></bbn-button>
                <bbn-button bbn-if="currentIcon"
                            @click="currentIcon = ''"
                            class="bbn-left-sspace"><?= _("Clear") ?></bbn-button>
              </div>
            </div>
          </bbn-form>
        </div>
      </div>
    </div>
  </bbn-scroll>
</div>
