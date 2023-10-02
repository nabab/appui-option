// Javascript Document

(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    props: ['source', 'parent', 'users', 'groups', 'url'],
    data(){
      return {};
    },
    methods: {
      setUserPerm(user){
        if ( user && user.id && !this.source.public && !this.source['group' + user.id_group] ){
          let isChecked = !this.source['user' + user.id];
          this.post((this.url || (this.parent.root + 'actions/')) + (isChecked ? 'add' : 'remove'), {
            id_user: user.id,
            id_option: this.source.id
          }, d => {
            if (d && d.success) {
              appui.success(bbn._('Saved!'));
            }
            else {
              appui.error(bbn._('Error!'));
            }
          });
        }
      }
    }
  }
})();