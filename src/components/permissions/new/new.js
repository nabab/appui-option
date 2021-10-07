// Javascript Document

(() => {
  return {
    props: ['source', 'parent'],
    data(){
      return {
        newPerm: {
          id_parent: this.parent.selected.id,
          code: '',
          text: '',
          help: ''
        }
      };
    },
    computed: {
      idParent(){
        return this.parent.selected.id;
      }
    },
    methods: {
      clearNewPerm(){
        this.newPerm = {
          id_parent: this.parent.selected.id,
          code: '',
          text: '',
          help: ''
        };
      },
      onSubmit(d) {
        if ( this.newPerm.id_parent && this.newPerm.code && this.getRef('form_new').dirty ){
          if ( d.data && d.data.success ){
            /** @todo to add the new permission to tre (permissions list) */
            this.clearNewPerm();
            appui.success(bbn._('Inserted!'));
          }
          else {
            appui.error(bbn._('Error'));
          }
        }
      },
    },
    watch: {
      idParent(){
        this.clearNewPerm();
        this.getRef('form').reset();
      }
    }
  }
})();