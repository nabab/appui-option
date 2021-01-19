<!-- HTML Document -->

<bbn-form :action="source.root + 'actions/import'"
          :source="source.data"
          class="bbn-overlay"
>
  <bbn-json-editor v-model="source.data.option"
                   class="bbn-overlay"
                   mode="text">
  </bbn-json-editor>
</bbn-form>