
<div class="bbn-overlay">
  <div class="bbn-flex-height">
    <div class="bbn-card bbn-padding bbn-w-100">
      <div>
        <span>
          <strong>
            <?= _('Option') ?>:
          </strong>
        </span>
        <span bbn-text="' '+source.option"></span>
      </div>
      <div bbn-if="source.codeOpt">
        <span>
          <strong>
            <?= _('Code') ?>:
          </strong>
        </span>
        <span bbn-text="' '+source.codeOpt"></span>
      </div>
      <div>
        <span>
          <strong>
            <?= _('Option used') ?>:
          </strong>
        </span>
        <span  bbn-text="info"></span>
      </div>
    </div>
    <div class="bbn-flex-fill bbn-padding">
      <div  style="padding-top: 1em; padding-left:1em" class=" bbn-overlay">
          <bbn-tree :source="source.treeData"></bbn-tree>
      </div>
    </div>
  </div>
</div>
