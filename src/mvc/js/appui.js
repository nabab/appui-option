// Javascript Document
(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    props: ['source'],
    methods: {
      save(row, col, idx){
        if ( !row.text || !row.code ){
          this.getPopup().alert(bbn._("Text and Code are mandatory!"));
        }
        else {
          this.post(this.source.root + 'actions/' + (row.id ? 'update' : 'insert'), row, (d) => {
            if ( d.success ){
              this.$refs.table.updateData();
              this.$refs.table.editedRow = false;
              this.$refs.table.editedIndex = false;
              appui.success();
            }
            else{
              appui.error(d);
            }
          });
        }
      },
      removeItem(row, col, idx){
        if ( row.id ){
          this.confirm(bbn._('Are you sure you want to delete this entry?'), () => {
            this.post(this.source.root + 'actions/delete', {id: row.id}, (d) => {
              if ( d.success ){
                this.$refs.table.updateData();
                appui.success(bbn._('Deleted'));
              }
              else {
                appui.error(d);
              }
            });
          });
        }
      },
      getButtons(e){
        let res = [{
          text: bbn._("Options's page"),
          icon: 'nf nf-fa-list',
          action: () => {
            bbn.fn.link(this.source.root + 'list/' + e.id)
          },
          notext: true
        }];
        if ( e.write ){
          res.push({
            text: bbn._('Edit'),
            icon: 'nf nf-fa-edit',
            action: 'edit',
            notext: true
          });
        }
        if ( !e.num_children && e.write ){
          res.push({
            text: bbn._('Delete'),
            icon: 'nf nf-fa-trash',
            action: this.removeItem,
            notext: true
          });
        }
        return res;
      }
    }
  }
})();

