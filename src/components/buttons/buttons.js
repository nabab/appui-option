(() => {
  return {
    mixins: [bbn.cp.mixins.basic, bbn.cp.mixins['appui-option-tree']],
    methods: {
      linkOption(){
        bbn.fn.link(appui.plugins['appui-option'] + "/list/" + this.source.option.id)
      },
      copyId() {
        bbn.fn.copy(this.source.option.id);
        appui.success(bbn._("ID %s copied!", this.source.option.id));
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
          this.post(appui.plugins['appui-option'] + '/actions/remove', this.source.option, d => {
              if (d.success) {
                appui.success(bbn._('Deleted'));
                this.onDelete(this.source.option)
              }
            }
          )
        })
      },
      removeOptHistory(){
        this.confirm(bbn._('Are you sure you want to delete this option\'s history?'), () => {
          this.post(appui.plugins['appui-option'] + '/actions/remove',
            bbn.fn.extend({}, this.source.option, {history : true}),
            d => {
              if ( d.success ){
                this.onDelete(this.source.option)
              }
            }
          )
        })
      },
      onDelete(data) {
        appui.success(bbn._('Deleted'));
        if (data.isApp) {
          this.$emit('deleteapp', this.source.option);
        }
        else if (data.isPlugin) {
          this.$emit('deleteplugin', this.source.option);
        }
        if (data.isSubplugin) {
          this.$emit('deletesubplugin', this.source.option);
        }

        this.$emit('delete', this.source.option);
      },
    }
  }
})();
