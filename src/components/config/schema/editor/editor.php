<div class="bbn-section bbn-block">
  <bbn-form @submit.prevent.stop="onSubmit"
            @cancel="onCancel"
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
                  bbn-model="currentSource.label"
                  :required="true"/>&nbsp;
        <bbn-button bbn-if="showFlabel"
                    class="bbn-s"
                    icon="nf nf-fa-minus"
                    @click="showFlabel = false; currentSource.flabel = null"
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
                bbn-model="currentSource.flabel"
                :required="true"/>
    
      <label><?= _("Field") ?></label>
      <bbn-input class="bbn-regular"
                bbn-model="currentSource.field"
                :required="true"/>
    
      <label><?= _("Type") ?></label>
      <bbn-combo class="bbn-regular"
                bbn-model="currentSource.type"
                :nullable="true"
                :source="types"/>
    
      <hr>
      <div class="bbn-grid-full bbn-b"><?= _("Edition") ?></div>
    
      <label><?= _("Editable") ?></label>
      <bbn-checkbox bbn-model="currentSource.editable"/>
    
      <label bbn-if="currentSource.editable"><?= _("Required") ?></label>
      <bbn-checkbox bbn-if="currentSource.editable"
                    bbn-model="currentSource.required"/>
    
      <label bbn-if="currentSource.editable"><?= _("Nullable") ?></label>
      <bbn-checkbox bbn-if="currentSource.editable"
                    bbn-model="currentSource.nullable"/>
    
      <hr>
      <div class="bbn-grid-full bbn-b"><?= _("Presentation") ?></div>
    
      <label><?= _("Hidden in the list") ?></label>
      <bbn-checkbox bbn-model="currentSource.invisible"/>
    
      <label bbn-if="currentSource.invisible"><?= _("Showable from the columns' menu") ?></label>
      <bbn-checkbox bbn-model="currentSource.showable"
                    bbn-if="currentSource.invisible"/>
    
      <label><?= _("Filterable") ?></label>
      <bbn-checkbox bbn-model="currentSource.filterable"/>
    
      <label>
        <bbn-tooltip source="<?= _("The classes must be separated by space") ?>">
          <span><?= _("CSS Class(es)") ?></span>
        </bbn-tooltip>
      </label>
      <bbn-input class="bbn-regular"
                bbn-model="currentSource.cls"/>
    
      <label><?= _("Width") ?></label>
      <div>
        <bbn-radio :source="widthRadio"
                  bbn-model="widthType"/><br>
        <label bbn-if="widthType === 'dynamic'"><?= _("Min width") ?></label>
        <bbn-numeric bbn-model="currentSource.minWidth"
                    bbn-if="widthType === 'dynamic'"
                    :min="0"
                    :max="1500"/>
        <label bbn-if="widthType === 'dynamic'"><?= _("Max width") ?></label>
        <bbn-numeric bbn-model="currentSource.maxWidth"
                    bbn-if="widthType === 'dynamic'"
                    :min="0"
                    :max="1500"/>
        <label bbn-if="widthType === 'fixed'"><?= _("Fixed width") ?></label>
        <bbn-numeric bbn-model="currentSource.width"
                    bbn-if="widthType === 'fixed'"
                    :min="0"
                    :max="1500"/>
      </div>
    
      <hr>
      <div class="bbn-grid-full bbn-b"><?= _("Component") ?></div>

      <label><?= _("Viewer component") ?></label>
      <bbn-input class="bbn-regular"
                bbn-model="currentSource.component"/>
      
      <label bbn-if="currentSource.component"><?= _("Component options") ?></label>
      <div bbn-if="currentSource.component">
        <bbn-radio :source="optionsRadio"
                  bbn-model="optionsType"/><br>
        <bbn-json-editor bbn-if="optionsType === 'source'"
                        bbn-model="currentSource"/>
        <bbn-json-editor bbn-elseif="optionsType === 'options'"
                        bbn-model="currentOptions"/>
      </div>
    
      <label bbn-if="currentSource.editable"><?= _("Editor component") ?></label>
      <bbn-input bbn-if="currentSource.editable"
                class="bbn-regular"
                bbn-model="currentSource.editor"/>
      
      <label bbn-if="currentSource.editable && currentSource.editor"><?= _("Component options") ?></label>
      <div bbn-if="currentSource.editable && currentSource.editor">
        <bbn-radio :source="optionsRadio"
                  bbn-model="editorOptionsType"/><br>
        <bbn-json-editor bbn-if="optionsType === 'source'"
                        bbn-model="currentSource"/>
        <bbn-json-editor bbn-elseif="optionsType === 'options'"
                        bbn-model="currentOptions"/>
      </div>
    </div>
  </bbn-form>
</div>
