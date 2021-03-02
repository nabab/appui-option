<div class="bbn-overlay">
  <bbn-splitter v-if="loaded">
    <bbn-pane>
      <div class="bbn-flex-height bbn-padded">
        <div>
          <span><strong><?=_('Option used')?>: </strong></span>
          <span v-text="result"></span>
          <span> <?=_('times')?></span>
        </div>
        <div class="bbn-flex-fill bbn-padded">
          <div  class="bbn-overlay">
              <bbn-tree :source="treeData"></bbn-tree>
          </div>
        </div>
      </div>
    </bbn-pane>
    <bbn-pane></bbn-pane>
  </bbn-splitter>
  <div v-else
       class="bbn-overlay bbn-middle bbn-b bbn-large">
    <?=_('Loading..')?>
  </div>
</div>
