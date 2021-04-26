<!-- HTML Document -->
<span :class="['bbn-iblock', componentClass]">
  <bbn-dropdown v-model="currentValue"
                :source="sourceURL"
                :required="true"
                source-value="rootAccess"/>
</span>
