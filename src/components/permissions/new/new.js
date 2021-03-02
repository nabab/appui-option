// Javascript Document

(() => {
  return {
    props: ['source', 'parent'],
    data(){
      return {
        newPerm: {
          id_parent: this.idParent,
          code: '',
          text: '',
          help: ''
        }
      };
    },
    computed: {
      idParent(){
        this.source.selected ? this.source.selected.id : null;
      }
    },
    methods: {
      clearNewPerm(){
        this.newPerm = {
          id_parent: this.idParent,
          code: '',
          text: '',
          help: ''
        };
      },
      submitNew(){
        if ( this.newPerm.id_parent && this.newPerm.code && this.getRef('form_new').dirty ){
          this.post(this.parent.root + 'actions/insert', this.newPerm, (d) => {
            if ( d.data && d.data.success ){
              /** @todo to add the new permission to tre (permissions list) */
              this.clearNewPerm();
              appui.success(bbn._('Inserted!'));
            }
            else {
              appui.error(bbn._('Error'));
            }
          });
        }
      },
    },
    watch: {
      idParent(){
        this.clearNewPerm()
      }
    }
  }
})();