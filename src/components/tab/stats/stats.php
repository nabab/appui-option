<div class="bbn-overlay">
  <bbn-splitter bbn-if="loaded">
    <bbn-pane>
      <div class="bbn-flex-height bbn-padding">
        <div>
          <span><strong><?= _('Option used') ?>: </strong></span>
          <span bbn-text="result"></span>
          <span> <?= _('times') ?></span>
        </div>
        <div class="bbn-flex-fill bbn-padding">
          <div  class="bbn-overlay">
              <bbn-tree :source="treeData"></bbn-tree>
          </div>
        </div>
      </div>
    </bbn-pane>
    <bbn-pane></bbn-pane>
  </bbn-splitter>
  <div bbn-else
       class="bbn-overlay bbn-middle bbn-b bbn-large">
    <?= _('Loading..') ?>
  </div>
</div>
