// Javascript Document

(() => {
  return {
    props: ['source', 'parent', 'users', 'groups', 'url'],
    data(){
      return {};
    },
    methods: {
      checkAllGroups(){
        bbn.fn.each(this.groups, (v, i) => {
          if ( !this.source['group' + v.id] ){
            this.setGroupPerm(v);
            this.source['group' + v.id] = true;
          }
        });
      },
      uncheckAllGroups(){
        bbn.fn.each(this.groups, (v, i) => {
          if ( this.source['group' + v.id] ){
            this.setGroupPerm(v);
            this.source['group' + v.id] = false;
          }
        });
      },
      setGroupPerm(group){
        if ( group && group.id && !this.source.public ){
          let isChecked = !this.source['group' + group.id];
          bbn.fn.post((this.url || (this.parent.root + 'actions/')) + (isChecked ? 'add' : 'remove'), {
            id_group: group.id,
            id_option: this.source.id
          }, (d) => {
            if (d && d.success) {
              appui.success(bbn._('Saved!'));
            }
            else {
              appui.error(bbn._('Error!'));
            }
          });
        }
      },
    }
  }
})();