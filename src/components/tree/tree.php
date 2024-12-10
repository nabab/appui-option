<div class="bbn-overlay bbn-padding">
  <bbn-tree bbn-if="isMounted"
            class="tree"
            :source="root + 'tree'"
            uid="id"
            :root="cat"
            :map="treeMapper"
            @select="optionSelect"
  ></bbn-tree>
</div>