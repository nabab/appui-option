<div class="bbn-overlay">
  <appui-option-option :source="source" bbn-if="source.cfg"></appui-option-option>
  <div class="bbn-overlay bbn-middle" bbn-else>
    <div class="bbn-lg bbn-c">
      <?= _("Select an option in the tree") ?>
    </div>
  </div>
</div>