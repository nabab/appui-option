<div class="bbn-section">
  <div class="bbn-grid-fields bbn-mobile">
    <label>
      <bbn-tooltip source="<?= ("A concise title to show in table columns and on editor label") ?>">
        <span><?= _("Title") ?></span>
      </bbn-tooltip>
    </label>
    <div>
      <bbn-input class="wide"
                bbn-model="source.title"
                :required="true"/>&nbsp;
      <a bbn-if="showFtitle"
        @click="showFtitle = false; source.ftitle = null"><?= _("Remove the longer title") ?></a>
      <a bbn-else
        @click="showFtitle = true"><?= _("Add a longer title") ?></a>
    </div>
  
    <label bbn-if="showFtitle">
      <bbn-tooltip source="<?= ("A longer title if needed to explain better what it is about") ?>">
        <span><?= _("Full title") ?></span>
      </bbn-tooltip>
    </label>
    <bbn-input bbn-if="showFtitle"
               class="wide"
               bbn-model="source.title"
               :required="true"/>
  
    <label><?= _("Field") ?></label>
    <bbn-input class="wide"
               bbn-model="source.field"
               :required="true"/>
  
    <label><?= _("Type") ?></label>
    <bbn-input class="wide"
               bbn-model="source.type"
               :required="true"/>
  
    <div class="bbn-grid-full bbn-b"><?= _("Edition") ?></div>
  
    <label><?= _("Editable") ?></label>
    <bbn-checkbox bbn-model="source.editable"/>
  
    <label bbn-if="source.editable"><?= _("Required") ?></label>
    <bbn-checkbox bbn-if="source.editable"
                  bbn-model="source.required"/>
  
    <label bbn-if="source.editable"><?= _("Nullable") ?></label>
    <bbn-checkbox bbn-if="source.editable"
                  bbn-model="source.nullable"/>
  
    <div class="bbn-grid-full bbn-b"><?= _("Presentation") ?></div>
  
    <label><?= _("Hidden") ?></label>
    <bbn-checkbox bbn-model="source.hidden"/>
  
    <label bbn-if="source.hidden"><?= _("Showable") ?></label>
    <bbn-checkbox bbn-model="source.showable"
                  bbn-if="source.hidden"/>
  
    <label><?= _("Filterable") ?></label>
    <bbn-checkbox bbn-model="source.filterable"/>
  
    <label><?= _("CSS Class(es)") ?></label>
    <bbn-input class="wide"
               bbn-model="source.cls"/>
  
    <label><?= _("Width") ?></label>
    <div>
      <bbn-radio :source="widthRadio"
                 bbn-model="widthType"/><br>
      <label bbn-if="widthType === 'dynamic'"><?= _("Min width") ?></label>
      <bbn-numeric bbn-model="source.minWidth"
                   bbn-if="widthType === 'dynamic'"
                   :min="0"
                   :max="1500"/>
      <label bbn-if="widthType === 'dynamic'"><?= _("Max width") ?></label>
      <bbn-numeric bbn-model="source.maxWidth"
                   bbn-if="widthType === 'dynamic'"
                   :min="0"
                   :max="1500"/>
      <label bbn-if="widthType === 'fixed'"><?= _("Fixed width") ?></label>
      <bbn-numeric bbn-model="source.width"
                   bbn-if="widthType === 'fixed'"
                   :min="0"
                   :max="1500"/>
    </div>
  
    <div class="bbn-grid-full bbn-b"><?= _("Advanced") ?></div>
  
    <label><?= _("Component options") ?></label>
    <div>
      <bbn-radio :source="optionsRadio"
                 bbn-model="optionsType"/><br>
      <bbn-json-editor v-if="optionsType === 'source'"
                       v-model="source.source"/>
      <bbn-json-editor v-elseif="optionsType === 'options'"
                       v-model="source.options"/>
    <bbn-checkbox bbn-model="source.hidden"/>
  
  </div>
</div>
