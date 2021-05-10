<div class="bbn-overlay bbn-flex-height">
  <bbn-input type="hidden"
             v-model="currentValue"
             v-show="false"/>
  <div class="bbn-vspadded bbn-w-100">
    <span v-text="_('Current path') + ':'"
          class="bbn-iblock bbn-right-space"/>
    <span class="bbn-iblock"
          v-if="currentPermission"
          v-html="currentPermission"/>
    <em v-else
        class="bbn-iblock"
        v-text="_('None')"/>
  </div>
  <div class="bbn-flex-fill bbn-w-100">
    <bbn-tree v-if="root"
              :source="sourceURL"
              :scrollable="false"
              :map="mapPermissions"
              :data="{mode: 'access'}"
              uid="id"
              :root="root"
              @select="selectPermission"
              @unselect="currentValue = ''"
              ref="tree"/>
  </div>
</div>
