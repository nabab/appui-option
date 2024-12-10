<div class="bbn-iflex-height">
  <bbn-input type="hidden"
             bbn-model="currentValue"
             bbn-show="false"/>
  <div class="bbn-vspadding bbn-w-100">
    <span bbn-text="_('Current path') + ':'"
          class="bbn-iblock bbn-right-space"/>
    <span class="bbn-iblock"
          bbn-if="currentPermission"
          bbn-html="currentPermission"/>
    <em bbn-else
        class="bbn-iblock"
        bbn-text="_('None')"/>
  </div>
  <div class="bbn-flex-fill bbn-w-100">
    <bbn-tree bbn-if="root"
              :source="sourceURL"
              :scrollable="false"
              :map="mapPermissions"
              :data="{mode: 'access'}"
              uid="id"
              :root="root"
              @select="selectPermission"
              @unselect="currentValue = ''"
              ref="tree"
              @ready="treeReady = true"/>
  </div>
</div>
