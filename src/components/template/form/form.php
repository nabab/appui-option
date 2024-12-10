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
  
              <div><?= _("Other values") ?></div>
              <div style="height: 300px"
                   class="bbn-widest">
                <bbn-json-editor bbn-model="source.option.value"/>
              </div>
            </div>
          </bbn-form>
        </div>
      </div>
    </div>
    </bbn-scroll>
</div>
