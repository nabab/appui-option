<!-- HTML Document -->
<bbn-splitter :resizable="true" :collapsible="true" orientation="horizontal">
  <bbn-pane :resizable="true" :collapsible="true" :size="400">
    <div class="bbn-flex-height">
      <div class="heightTop">
        <div class="bbn-padding">
          <bbn-button icon="nf nf-fa-times"
                      @click="deleteCache"
                      label='<?= _("Delete cache") ?>'
          ></bbn-button>
        </div>
      </div>
      <div class="bbn-flex-fill">
        <div class="bbn-hpadding bbn-overlay">
          <bbn-tree2 :source="source.root + 'tree'"
                    uid="id"
                    :root="0"
                    :map = "treeMapper"
                    @select="treeNodeActivate"
                    :path="['03a480db025011e8beb3005056014c9f', '16e090ac025011e8beb3005056014c9f', '16ec799a025011e8beb3005056014c9f']"
                    ref="listOptions"
                    :drag="true"
                    @dragend="moveOpt"
                    :min-expand-level="1"
                    :menu="treeMenu"
          ></bbn-tree2>
        </div>
      </div>
    </div>
  </bbn-pane>
  <bbn-pane :resizable="true" :collapsible="true">
    <div class="bbn-flex-height" bbn-if="optionSelected.id.length">
      <div class="heightTop">
        <div class="bbn-padding" bbn-if="optionSelected.id.length">
          <bbn-button icon="nf nf-fa-times"
                      @click="deleteSingleCache"
                      label="<?= _('Delete cache option') ?>"
          ></bbn-button>
          <bbn-button icon="nf nf-fa-link"
                      @click="linkOption"
                      :label="'<?= _('Go to') ?>' +' '+ optionSelected.text"
          ></bbn-button>
          <bbn-button icon="nf nf-fa-eye"
                      @click="showUsageOpt">
                      <?= _('Show Usage') ?>
          </bbn-button>
        </div>
      </div>
      <div class="bbn-flex-fill bbn-padding">
        <bbn-json-editor bbn-model="option" :readonly="true"></bbn-json-editor>
      </div>
    </div>
    <div class="bbn-h-100 bbn-middle" bbn-else>
      <div class="bbn-card bbn-vmiddle bbn-c bbn-lpadding">
          <span class="bbn-xxxl bbn-c">
            <?= _("Select Option") ?>
          </span>
      </div>
    </div>
  </bbn-pane>
</bbn-splitter>