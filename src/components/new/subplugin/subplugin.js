(() => {
  return {
    mixins: [bbn.cp.mixins['appui-option-tree']],
    data() {
      return {
        currentPlugin: null
      }
    },
    created() {
      this.currentPlugin = this.closest('bbn-container').getComponent().currentPlugin;
    },
  };
})()