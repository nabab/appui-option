<div class="bbn-flex"
     style="flex-flow: column; margin: auto">
  <div bbn-for="(item, i) in source">
    <bbn-button :notext="true"
                icon="nf nf-fa-edit"
                :disabled="isEditing"
                @click="edited = i"
                class="bbn-right-xxsmargin"/>
    <bbn-button :notext="true"
                icon="nf nf-fa-trash"
                :disabled="isEditing"
                @click="deleteItem(i)"
                class="bbn-right-xxsmargin"/>
    <appui-option-schema-viewer :source="item"/>
  </div>
</div>