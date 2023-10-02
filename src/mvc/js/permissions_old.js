// Javascript Document
(() => {
  return {
    data(){
      return {
        selected: false,
        newPerm: {},
        sections:{
          configuration: true,
          newPermission: false,
          groups: false,
          users: false
        }
      }
    },
    computed: {
      idParent(){
        return this.selected.id || null;
      },
      conf(){
        return {
          id: this.selected.id,
          code: this.selected.code,
          text: this.selected.text,
          help: this.selected.help,
          public: this.selected.public || false,
          cascade: this.selected.cascade || false
        }
      },

    },
    methods: {
      enter(element) {
        const width = getComputedStyle(element).width;

        element.style.width = width;
        element.style.position = 'absolute';
        element.style.visibility = 'hidden';
        element.style.height = 'auto';

        const height = getComputedStyle(element).height;

        element.style.width = null;
        element.style.position = null;
        element.style.visibility = null;
        element.style.height = 0;

        // Force repaint to make sure the
        // animation is triggered correctly.
        getComputedStyle(element).height;

        // Trigger the animation.
        // We use `requestAnimationFrame` because we need
        // to make sure the browser has finished
        // painting after setting the `height`
        // to `0` in the line above.
        requestAnimationFrame(() => {
          element.style.height = height;
        });
      },
      afterEnter(element) {
        element.style.height = 'auto';
      },
      leave(element) {
        const height = getComputedStyle(element).height;

        element.style.height = height;

        // Force repaint to make sure the
        // animation is triggered correctly.
        getComputedStyle(element).height;

        requestAnimationFrame(() => {
          element.style.height = 0;
        });
      },
      clearNewPerm(){
        this.newPerm = {
          id_parent: this.idParent,
          code: '',
          text: '',
          help: ''
        };
      },
      refreshPermissions(){
        this.confirm(bbn._("Are you sure you want to update all permissions? It might take a while..."), () => {
          bbn.fn.post(this.source.root + 'actions/update_permissions', (d) => {
            if (d && d.res && d.res.total) {
              appui.success(d.res.total + ' ' + bbn._("permissions have been added"));
            }
            else if (d && d.res) {
              appui.success(bbn._("No permission has been added"));
            }
            else {
              appui.error();
            }
            //load();
          });
        });
      },
      treeMapper(n){
        n.text += '<span class="bbn-permissions-list-code">' + n.code + '</span>';
        return n;
      },
      permissionSelect(n){
        bbn.fn.post(this.source.root + 'permissions', {
          id: n.data.id,
          full: 1
        }, (d) => {
          this.selected = d.data || false;
          this.clearNewPerm();
          //bbn.fn.extend(r, d.data);
        });
      },
      openSection(section){
        bbn.fn.each(this.sections, (s, i) => {
           this.sections[i] = i === section
        });
      },
      submitConf(){
        if ( this.getRef('form_cfg').dirty ){
          bbn.fn.post(this.source.root + 'permissions/update', this.conf, (d) => {
            if ( d.data && d.data.success ){
              appui.success(bbn._('Saved!'));
            }
            else {
              appui.error(bbn._('Error!'));
            }
          });
        }
      },
      submitNew(){
        if ( this.newPerm.id_parent && this.newPerm.code && this.getRef('form_new').dirty ){
          bbn.fn.post(this.source.root + 'permissions/insert', this.newPerm, (d) => {
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
      delPerm(){
        if ( this.selected.id ){
          this.confirm(bbn._('Are you sure you want to delete this permission?'), ()  => {
            bbn.fn.post(this.source.root + 'permissions/delete', {id: this.selected.id}, (d) => {
              if ( d.data && d.data.success ){
                appui.success(bbn._('Deleted!'));
                this.selected = {};
                /** @todo to remove it from the permissions list (tree) and to select its parent */
              }
            });
          });
        }
      },
      checkAllGroups(){
        bbn.fn.each(this.source.groups, (v, i) => {
          if ( !this.selected['group' + v.id] ){
            this.setGroupPerm(v);
            this.selected['group' + v.id] = true;
          }
        });
      },
      uncheckAllGroups(){
        bbn.fn.each(this.source.groups, (v, i) => {
          if ( this.selected['group' + v.id] ){
            this.setGroupPerm(v);
            this.selected['group' + v.id] = false;
          }
        });
      },
      setGroupPerm(group){
        if ( group && group.id && !this.selected.public ){
          let isChecked = !this.selected['group' + group.id];
          bbn.fn.post(this.source.root + 'permissions/' + (isChecked ? 'add' : 'remove'), {
            id_group: group.id,
            id_option: this.selected.id
          }, (d) => {
            if ( d.data.res ){
              appui.success(bbn._('Saved!'));
            }
            else {
              appui.error(bbn._('Error!'));
            }
          });
        }
      },
      setUserPerm(user){
        if ( user && user.id && !this.selected.public && !this.selected['group' + user.id_group] ){
          let isChecked = !this.selected['user' + user.id];
          bbn.fn.post(this.source.root + 'permissions/' + (isChecked ? 'add' : 'remove'), {
            id_user: user.id,
            id_option: this.selected.id
          }, (d) => {
            if ( d.data.res ){
              appui.success(bbn._('Saved!'));
            }
            else {
              appui.error(bbn._('Error!'));
            }
          });
        }
      }
    }
  };
})();