<div class="bbn-overlay bbn-padding">
  <bbn-tree v-if="isMounted"
            class="tree"
            :source="root + 'tree'"
            uid="id"
            :root="cat"
            :map="treeMapper"
            @select="optionSelect"/>    
</div>