(() => {
  return {
    mixins: [bbn.cp.mixins.basic, bbn.cp.mixins['appui-option-tree']],
    data() {
      return {
        data: null
      }
    },
    mounted() {
      let id = this.source.id;
      if (!id && this.closest('bbn-container').hasArguments()) {
        id = this.closest('bbn-container').args[0];
      }

      if (!this.data && id) {
        bbn.fn.post(appui.plugins['appui-option'] + '/tree/option', {id}, d => {
          if (d.success) {
            delete d.success;
            this.data = d;
          }
        })
      }
    }
  }
})();
