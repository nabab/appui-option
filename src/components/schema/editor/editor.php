<div class="bbn-section">
  <bbn-form @submit.prevent.stop="onSubmit"
            :source="source">
    <div class="bbn-grid-fields">
      <label>
        <bbn-tooltip source="<?= ("A concise title to show in table columns and on editor label") ?>">
          <span><?= _("Title") ?></span>
        </bbn-tooltip>
      </label>
      <div>
        <bbn-input class="wide"
                  bbn-model="source.label"
                  :required="true"/>&nbsp;
        <a bbn-if="showFlabel"
          @click="showFlabel = false; source.flabel = null"><?= _("Remove the longer title") ?></a>
        <a bbn-else
          @click="showFlabel = true"><?= _("Add a longer title") ?></a>
      </div>
    
      <label bbn-if="showFlabel">
        <bbn-tooltip source="<?= ("A longer title if needed to explain better what it is about") ?>">
          <span><?= _("Full title") ?></span>
        </bbn-tooltip>
      </label>
      <bbn-input bbn-if="showFlabel"
                class="wide"
                bbn-model="source.ftitle"
                :required="true"/>
    
      <label><?= _("Field") ?></label>
      <bbn-input class="wide"
                bbn-model="source.field"
                :required="true"/>
    
      <label><?= _("Type") ?></label>
      <bbn-combo class="wide"
                bbn-model="source.type"
                :nullable="true"
                :source="types"/>
    
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
    
      <label><?= _("Hidden in the list") ?></label>
      <bbn-checkbox bbn-model="source.invisible"/>
    
      <label bbn-if="source.hidden"><?= _("Showable from the columns' menu") ?></label>
      <bbn-checkbox bbn-model="source.showable"
                    bbn-if="source.hidden"/>
    
      <label><?= _("Filterable") ?></label>
      <bbn-checkbox bbn-model="source.filterable"/>
    
      <label><?= _("CSS Class(es) (space separated)") ?></label>
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
    
      <div class="bbn-grid-full bbn-b"><?= _("Component") ?></div>

      <label><?= _("Viewer component") ?></label>
      <bbn-input class="wide"
                bbn-model="source.component"/>
      
      <label bbn-if="source.component"><?= _("Component options") ?></label>
      <div bbn-if="source.component">
        <bbn-radio :source="optionsRadio"
                  bbn-model="optionsType"/><br>
        <bbn-json-editor v-if="optionsType === 'source'"
                        v-model="source.source"/>
        <bbn-json-editor v-elseif="optionsType === 'options'"
                        v-model="source.options"/>
      </div>
    
      <label bbn-if="source.editable"><?= _("Editor component") ?></label>
      <bbn-input bbn-if="source.editable"
                class="wide"
                bbn-model="source.editor"/>
      
      <label bbn-if="source.editable && source.editor"><?= _("Component options") ?></label>
      <div bbn-if="source.editable && source.editor">
        <bbn-radio :source="optionsRadio"
                  bbn-model="optionsType"/><br>
        <bbn-json-editor v-if="optionsType === 'source'"
                        v-model="source.source"/>
        <bbn-json-editor v-elseif="optionsType === 'options'"
                        v-model="source.options"/>
      </div>
    </div>
  </bbn-form>
</div>
