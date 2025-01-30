<div class="bbn-iblock">
  <div class="bbn-w-100">
    <div class="bbn-flex-width">
      <div class="bbn-flex-fill">
        <span bbn-if="!source?.length"
              bbn-text="_('No data structure is defined')"/>
      </div>
      <div>
        <bbn-button icon="nf nf-fa-plus"
                    @click="addItem"
                    :notext="true"
                    :title="_('Add a new field')"
                    :disabled="isEditing"/>
        <bbn-button icon="nf nf-fa-save"
                    @click="saveItem"
                    :notext="true"
                    :title="_('Save the changes')"
                    :disabled="!isEditing"/>
        <bbn-button icon="nf nf-fa-cancel"
                    @click="cancel"
                    :notext="true"
                    :title="_('Save the changes')"
                    :disabled="!isEditing"/>
      </div>
    </div>
  </div>
  <div class="bbn-w-100"
       bbn-if="edited">
    <appui-option-schema-editor :source="edited"
                                @close="edited = false"
                                @save="saveItem"/>
  </div>
  <div bbn-elseif="source?.length"
       class="bbn-w-100">
    <div class="bbn-flex"
         style="flex-flow: column; margin: auto">
      <div bbn-for="(item, i) in source">
        <bbn-button :notext="true"
                    icon="nf nf-fa-edit"
                    :disabled="isEditing"
                    @click="edited = item"
                    class="bbn-right-xxsmargin"/>
        <bbn-button :notext="true"
                    icon="nf nf-fa-trash"
                    :disabled="isEditing"
                    @click="deleteItem(i)"
                    class="bbn-right-xxsmargin"/>
        <appui-option-schema-viewer :source="item"/>
      </div>
    </div>
  </div>