(() => {
  return {
    mixins: [bbn.cp.mixins.basic, bbn.cp.mixins['appui-option-tree']],
    methods: {
      linkOption(){
        bbn.fn.link(appui.plugins['appui-option'] + "/list/" + this.source.id)
      },
      deleteCache(){
        this.post(appui.plugins['appui-option'] + '/actions/delete_cache',{
          id: this.data.option.id
        }, (d) => {
          if ( d.success ){
            appui.success("Deleted");
          }
          else{
            appui.error(d);
          }
        })
      },
      removeOpt() {
        this.confirm(bbn._('Are you sure you want to delete this option?'), ()=>{
          this.post(appui.plugins['appui-option'] + '/actions/remove', this.source, d => {
              if (d.success) {
                appui.success(bbn._('Deleted'));
                this.onDelete(this.source)
              }
            }
          )
        })
      },
      removeOptHistory(){
        this.confirm(bbn._('Are you sure you want to delete this option\'s history?'), () => {
          this.post(appui.plugins['appui-option'] + '/actions/remove',
            bbn.fn.extend({}, this.source, {history : true}),
            d => {
              if ( d.success ){
                this.onDelete(this.source)
              }
            }
          )
        })
      },
      onDelete(data) {
        appui.success(bbn._('Deleted'));
        if (data.isApp) {
          this.$emit('deleteapp', this.source);
        }
        else if (data.isPlugin) {
          this.$emit('deleteplugin', this.source);
        }
        if (data.isSubplugin) {
          this.$emit('deletesubplugin', this.source);
        }

        this.$emit('delete', this.source);
      },
    }
  }
})();
