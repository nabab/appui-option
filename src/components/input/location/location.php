<!-- HTML Document -->
<span :class="['bbn-iblock', componentClass]">
  <bbn-dropdown bbn-model="currentValue"
                :source="sourceURL"
                :required="true"
                source-value="rootAccess"
                ref="dropdown"
                @ready="setDropdown"/>
</span>
