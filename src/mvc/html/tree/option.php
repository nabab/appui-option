<div class="bbn-overlay">
  <appui-options-option :source="source" v-if="source.cfg"></appui-options-option>
  <div class="bbn-overlay bbn-middle" v-else>
    <div class="bbn-lg bbn-c">
      <?=_("Select an option in the tree")?>
    </div>
  </div>
</div>