(() => {
  return {
    props: ['source'],
    mounted() {
      let id = this.source.id;
      if (!id && this.closest('bbn-container').hasArguments()) {
        id = this.closest('bbn-container').args[0];
      }

      if (this.$origin.data) {
        this.$origin.isLoading = false;
      }
      else if (id) {
        bbn.fn.post(appui.plugins['appui-option'] + '/tree/option', {id}, d => {
          if (d.success) {
            delete d.success;
            this.$origin.data = d;
            this.$origin.$emit('update', d);
          }
          this.$origin.isLoading = false;
        })
      }
      else {
        this.$origin.isLoading = false;
      }
    }
  }
})()