<!-- HTML Document -->

<div class="appui-option-input-picker">
  <bbn-button @click="showFloater = !showFloater"
              ref="button"
              type="button">
    <?= _("Browse") ?>
  </bbn-button> &nbsp;
  <bbn-input v-model="rootAlias"/>
  <bbn-button v-if="value"
              class="bbn-space-left"
              @click="emitInput(null)">
    <?= _("Clear") ?>
  </bbn-button>
  <bbn-input type="hidden"
             v-model="value"/>
  <bbn-floater v-if="showFloater"
               :element="$refs.button.$el"
               height="40em"
               width="25em">
    <div class="bbn-overlay">
      <bbn-tree v-if="ready"
                class="tree"
                :source="root + 'tree'"
                uid="id"
                :root="id_root"
                :map="treeMapper"
                @select="optionSelect"
      ></bbn-tree>
    </div>
  </bbn-floater>
</div>