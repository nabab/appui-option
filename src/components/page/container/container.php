<div class="bbn-overlay bbn-flex-height">
  <appui-option-loader :source="source"/>
  <div class="bbn-padding bbn-w-100 bbn-flex-width"
       bbn-if="data"
       :style="{
          backgroundColor: closest('bbn-container').closest('bbn-container').currentBcolor,
          color: closest('bbn-container').closest('bbn-container').currentFcolor,
          height: '4rem',
          alignItems: 'center'
        }"
       bbn-if="data?.option">
    <div class="bbn-flex-fill bbn-b bbn-c bbn-large">
      <?= _("Container") ?> 
      <span bbn-text="data.option.text"/>
    </div>
    <appui-option-buttons :source="data"/>
    <div class="bbn-bottom-left bbn-vxxspadding bbn-hxspadding">
      <appui-option-breadcrumb :source="data.breadcrumb"/>
    </div>
  </div>
  <div class="bbn-flex-fill">
    <bbn-scroll bbn-if="data">
      <div class="bbn-padding bbn-centered-block">
        <div class="bbn-card bbn-vlmargin">
          <bbn-form :action="root + 'actions/' + (data.option.id ? 'update' : 'insert')"
                    :source="data.option"
                    @success="success" 
                    :scrollable="false"
                    mode="big">
            <div class="bbn-grid-fields bbn-padding">
              <div><?= _('ID') ?></div>
              <div bbn-text="data.option.id"/>
  
              <div><?= _("Container's name") ?></div>
              <bbn-input bbn-model="data.option.text"
                        class="bbn-wide"
                        :required="true"/>
  
              <div><?= _("Container's code") ?></div>
              <bbn-input bbn-model="data.option.code"
                         class="bbn-wide"
                         :required="true"/>
  
              <div><?= _("Container's color") ?></div>
              <bbn-colorpicker bbn-model="data.option.color"/>
  
            </div>
          </bbn-form>
        </div>
      </div>
    </div>
    </bbn-scroll>
</div>
