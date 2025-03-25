<div class="bbn-section bbn-block">
  <bbn-form @submit.prevent.stop="onSubmit"
            :source="source"
            ref="form">
    <div class="bbn-grid-fields">
      <label>
        <bbn-tooltip source="<?= ("A concise title to show in table columns and on editor label") ?>">
          <span><?= _("Title") ?></span>
        </bbn-tooltip>
      </label>
      <div>
        <bbn-input class="bbn-regular"
                  bbn-model="source.label"
                  :required="true"/>&nbsp;
        <bbn-button bbn-if="showFlabel"
                    class="bbn-s"
                    icon="nf nf-fa-minus"
                    @click="showFlabel = false; source.flabel = null"
                    flabel="<?= _("Removes the alternate title") ?>"
                    label="<?= _("Delete alternate title") ?>"/>
        <bbn-button bbn-else
                    class="bbn-s"
                    icon="nf nf-fa-plus"
                    @click="showFlabel = true"
                    flabel="<?= _("Adds a longer laternate title that will be shown when mouse overs") ?>"
                    label="<?= _("Add alternate title") ?>"/>
      </div>
    
      <label bbn-if="showFlabel">
        <bbn-tooltip source="<?= ("A longer title if needed to explain better what it is about") ?>">
          <span><?= _("Full title") ?></span>
        </bbn-tooltip>
      </label>
      <bbn-input bbn-if="showFlabel"
                class="bbn-regular"
                bbn-model="source.ftitle"
                :required="true"/>
    
      <label><?= _("Field") ?></label>
      <bbn-input class="bbn-regular"
                bbn-model="source.field"
                :required="true"/>
    
      <label><?= _("Type") ?></label>
      <bbn-combo class="bbn-regular"
                bbn-model="source.type"
                :nullable="true"
                :source="types"/>
    
      <hr>
      <div class="bbn-grid-full bbn-b"><?= _("Edition") ?></div>
    
      <label><?= _("Editable") ?></label>
      <bbn-checkbox bbn-model="source.editable"/>
    
      <label bbn-if="source.editable"><?= _("Required") ?></label>
      <bbn-checkbox bbn-if="source.editable"
                    bbn-model="source.required"/>
    
      <label bbn-if="source.editable"><?= _("Nullable") ?></label>
      <bbn-checkbox bbn-if="source.editable"
                    bbn-model="source.nullable"/>
    
      <hr>
      <div class="bbn-grid-full bbn-b"><?= _("Presentation") ?></div>
    
      <label><?= _("Hidden in the list") ?></label>
      <bbn-checkbox bbn-model="source.invisible"/>
    
      <label bbn-if="source.hidden"><?= _("Showable from the columns' menu") ?></label>
      <bbn-checkbox bbn-model="source.showable"
                    bbn-if="source.hidden"/>
    
      <label><?= _("Filterable") ?></label>
      <bbn-checkbox bbn-model="source.filterable"/>
    
      <label>
        <bbn-tooltip source="<?= _("The classes must be separated by space") ?>">
          <span><?= _("CSS Class(es)") ?></span>
        </bbn-tooltip>
      </label>
      <bbn-input class="bbn-regular"
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
    
      <hr>
      <div class="bbn-grid-full bbn-b"><?= _("Component") ?></div>

      <label><?= _("Viewer component") ?></label>
      <bbn-input class="bbn-regular"
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
                class="bbn-regular"
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
