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
          users: false, 
          items:[]
        }, 
        cfg_modified: false,
        new_modified: false
      }
    },
    mounted(){
      this.items = [{
        text: bbn._('Configuration'),
        component: this.$options.components['configuration'], 
        code: 'configuration'
      }, {
        text: bbn._('New permission (under this one)'),
        component: this.$options.components['newPermission'],
        code: 'newPermission'
      }, {
        text: bbn._('Groups'),
        component: this.$options.components['groups'],
        code: 'groups', 
        buttons: [{
          icon: 'nf nf-fa-check_square',
          title: bbn._('Check all'),
          action: this.checkAllGroups
        }, {
          icon: 'nf nf-fa-square',
          title: bbn._('Uncheck all'),
          action: this.uncheckAllGroups
        }
      ]
      },{
        text: bbn._('Users'),
        component: this.$options.components['users'],
        code: 'users'
      }],
        bbn.fn.log('groups', this.source.groups)
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
      clearNewPerm(){
        this.newPerm = {
          id_parent: this.idParent,
          code: '',
          text: '',
          help: ''
        };
      },
      refreshPermissions(){
        appui.confirm(this.source.lng.confirm_update_permissions, () => {
          this.post(this.source.root + 'actions/update_permissions', (d) => {
            //$tree.dataSource.read();
            if ( d && d.res && d.res.total ){
              appui.success(d.res.total + ' ' + bbn._('permissions added'))
              //appui.success(kendo.format(data.lng.total_updated, d.res.total));
            }
            else{
              appui.success(this.source.lng.no_permission_updated);
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
        this.post(this.source.root + 'permissions', {
          id: n.data.id,
          full: 1
        }, (d) => {
          this.selected = d.data || false;
          this.clearNewPerm();
        });
      },
      openSection(section){
        bbn.fn.log(JSON.stringify(this.sections), section)
        bbn.fn.each(this.sections, (s, i) => {
          this.sections[i] = false
          bbn.fn.log(this.sections[i])
        });
        if ( this.sections[section.code] === true ){
          this.sections[section.code] = false
        }
        else{
          this.sections[section.code] = true
        }
        
      },
      submitConf(){
        bbn.fn.log('SUBMIT CONF', this.cfg_modified)
        if ( this.cfg_modified ) {
          this.post(this.source.root + 'permissions/update', this.conf, (d) => {
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
        if (this.newPerm.id_parent && this.newPerm.code && this.new_modified ){
          this.post(this.source.root + 'permissions/insert', this.newPerm, (d) => {
            if ( d.data && d.data.success ){
              /** @todo to add the new permission to tre (permissions list) */
              this.clearNewPerm();
              appui.success(bbn._('Inserted!'));
            }
            else if ( !d.data || !d.data.success ){
              appui.error(bbn._('Error'));
            }
            
          });
        }
      },
      delPerm(){
        if ( this.selected.id ){
          appui.confirm(bbn._('Are you sure you want to delete this permission?'), ()  => {
            this.post(this.source.root + 'permissions/delete', {id: this.selected.id}, (d) => {
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
        bbn.fn.log('1',group, this.selected.public )
        if ( group && group.id && !this.selected.public ){
          let isChecked = !this.selected['group' + group.id];
          bbn.fn.log('setGroupPerm', group, this.selected.public, this.source.root + 'permissions/' + (isChecked ? 'add' : 'remove'))
          this.post(this.source.root + 'permissions/' + (isChecked ? 'add' : 'remove'), {
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
          this.post(this.source.root + 'permissions/' + (isChecked ? 'add' : 'remove'), {
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
    },
    components: {
      'configuration':{
        template: '#configuration',
        computed: {
          sections(){
            return this.closest('bbn-container').getComponent().sections;
          },
          selected(){
            return this.closest('bbn-container').getComponent().selected;
          }
        },

        mounted() {
          bbn.fn.log('mounted 1', this.$refs)
        },
        methods: {
          submitConf(){
            this.closest('bbn-container').getComponent().cfg_modified = this.$refs['form_cfg'].modified;
            bbn.fn.log(this.$refs['form_cfg'].modified);
            return this.closest('bbn-container').getComponent().submitConf()
          },
          delPerm(){
            return this.closest('bbn-container').getComponent().delPerm()
          },
          
        }
      },
      'newPermission': {
        template: '#new-permission',
        computed: {
          sections() {
            return this.closest('bbn-container').getComponent().sections;
          },
          newPerm() {
            return this.closest('bbn-container').getComponent().newPerm;
          }
        },
        mounted(){
          bbn.fn.log('mounted 2', this.$refs)
        },
        methods: {
          submitNew(){
            this.closest('bbn-container').getComponent().new_modified = this.$refs['form_new'].modified;
            bbn.fn.log('ref',this.$refs['form_new'].modified)
            return this.closest('bbn-container').getComponent().submitNew();
          }
        }
      },
      'groups': {
        template: '#groups',
        computed: {
          sections() {
            return this.closest('bbn-container').getComponent().sections;
          },
          groups() {
            return this.closest('bbn-container').getComponent().source.groups;
          },
          selected(){
            return this.closest('bbn-container').getComponent().selected;
          }
        },
        mounted() {
          bbn.fn.log('mounted 3', this.$refs)
        },
        methods: {
          setGroupPerm(g) {
            return this.closest('bbn-container').getComponent().setGroupPerm(g);
          },
          checkAllGroups(){
            return this.closest('bbn-container').getComponent().checkAllGroups();
          },
          uncheckAllGroups(){
            return this.closest('bbn-container').getComponent().uncheckAllGroups();
          }
        }
      },
      'users': {
        template: '#users',
        computed: {
          sections(){
            return this.closest('bbn-container').getComponent().sections;
          },
          users(){
            return this.closest('bbn-container').getComponent().source.users;
          },
          selected(){
            return this.closest('bbn-container').getComponent().selected;
          }
        },
        methods: {
          setUserPerm(j){
            return this.closest('bbn-container').getComponent().setUserPerm(j);
          }
        }
      }
    }
  };
})();