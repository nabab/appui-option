<!-- HTML Document -->

<bbn-form :action="root + 'actions/import'"
          :source="source.data"
          class="bbn-overlay"
>
  <bbn-json-editor bbn-model="source.data.option"
                   class="bbn-overlay"
                   mode="text">
  </bbn-json-editor>
</bbn-form>