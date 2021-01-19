
<div class="bbn-overlay">
  <div class="bbn-flex-height">
    <div class="bbn-card bbn-padded bbn-w-100">
      <div>
        <span>
          <strong>
            <?=_('Option')?>:
          </strong>
        </span>
        <span v-text="' '+source.option"></span>
      </div>
      <div v-if="source.codeOpt">
        <span>
          <strong>
            <?=_('Code')?>:
          </strong>
        </span>
        <span v-text="' '+source.codeOpt"></span>
      </div>
      <div>
        <span>
          <strong>
            <?=_('Option used')?>:
          </strong>
        </span>
        <span  v-text="info"></span>
      </div>
    </div>
    <div class="bbn-flex-fill bbn-padded">
      <div  style="padding-top: 1em; padding-left:1em" class=" bbn-overlay">
          <bbn-tree :source="source.treeData"></bbn-tree>
      </div>
    </div>
  </div>
</div>
