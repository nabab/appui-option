<div class="bbn-overlay bbn-padded">
  <bbn-tree v-if="isMounted"
            class="tree"
            :source="root + 'tree'"
            uid="id"
            :root="cat"
            :map="treeMapper"
            @select="optionSelect"
  ></bbn-tree>
</div>