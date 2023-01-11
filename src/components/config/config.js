// Javascript Document
(() => {
  let controllers = false;
  return {
    props: ['source'],
    data() {
      let defScfg = {
        allow_children: null,
        alias_name: "",
        categories: null,
        controller: null,
        default: "",
        default_value: null,
        desc: "",
        form: null,
        frozen: 0,
        i18n: "",
        i18n_inheritance: "",
        id: "",
        inheritance: "",
        permissions: "",
        schema: null,
        show_alias: null,
        show_code: null,
        show_icon: 0,
        show_value: null,
        sortable: null,
        write: true,
        help: '',
        notext: 0,
        view: 0,
        root_alias: bbn._('Root')
      };
      return {
        data: {
          cfg: this.source.cfg,
          scfg: this.source.cfg.scfg || defScfg,
          id: this.source.option ? this.source.option.id : this.source.id
        },
        ready: false,
        models: [],
        views: [],
        showSchema: !!this.source.cfg.schema,
        jsonDataTemplate: [{
          text: bbn._('Field'),
          title: bbn._('Insert a form field'),
          className: 'jsoneditor-type-object',
          value: {
            title: bbn._('Insert a title'),
            field: bbn._("Insert the field's name"),
            type: 'string',
            showable: true,
            editable: true,
            hidden: false,
            options: {}
          }
        }],
        jsonSchema: {
          "type": "array",
          "items": {
            "type": "object",
            "properties": {
              "title": {
                "type": "string"
              },
              "field": {
                "type": "string"
              },
              "type": {
                "type": "string"
              },
              "showable": {
                "type": "boolean"
              },
              "editable": {
                "type": "boolean"
              },
              "hidden": {
                "type": "boolean"
              },
              "options": {
                "type": "object"
              }
            },
            "required": ["title", "field"]
          }
        },
        //rootAlias: this.source.cfg.root_alias !== undefined ? this.source.cfg.root_alias.text : bbn._('Root'),
        showScfg: !!this.source.cfg.scfg,
        showSchemaScfg: !!this.source.cfg.scfg && !!this.source.cfg.scfg.schema,
        defaultScfg: defScfg,
        showReset: !this.source.cfg.frozen,
        root: appui.plugins['appui-option'] + '/'
      }
    },
    computed: {
      canDefineSubPermissions(){
        if (this.source.permissions) {
          return !['all', 'cascade'].includes(this.source.permissions.cfg)
        }

        return true;
      },
      canDefineSelfPermission(){
        return !this.source.permissions
      },
      permissionsText(){
        let str = '';
        if (this.source.cfg.permissions) {
          str += ' <strong>' + this.source.cfg.permissions.from_text + '</strong>';
        }
        else if (!this.canDefineSubPermissions) {
          str += bbn._("The permissions' configuration comes from the parent option");
        }
        else if (!this.canDefineSelfPermission) {
          str += bbn._("This permission's configuration comes from the parent option");
        }
        return str;
      },
      permissionsSource(){
        let r = [{
          text: bbn._("None"),
          value: ''
        }];
        if (this.canDefineSelfPermission) {
          r.push({
            text: bbn._("This"),
            value: 'single'
          });
        }

        if (this.source.cfg.allow_children && this.canDefineSubPermissions) {
          r.push({
            text: bbn._("Children"),
            value: 'children'
          });
          r.push({
            text: bbn._("Cascade"),
            value: 'cascade'
          });
          if (this.canDefineSelfPermission) {
            r.push({
              text: bbn._("All (this + cascade)"),
              value: 'all'
            });
          }
        }
        return r;
      },
      inPopup(){
        return !!this.closest('bbn-popup');
      },
      controllers(){
        return controllers
      },
      tree(){
        return this.closest('appui-option-option') || null
      }
    },
    methods: {
      toggleSchema() {
        this.showSchema = !this.showSchema;
      },
      toggleSchemaScfg() {
        this.showSchemaScfg = !this.showSchemaScfg;
      },
      beforeSend(data) {
        let clearData = (d) => {
          if ( d.frozen !== undefined ){
            delete d.frozen;
          }
          if ( d.inherit_from !== undefined ){
            delete d.inherit_from;
          }
          if ( d.inherit_from_text !== undefined ){
            delete d.inherit_from_text;
          }
          if ( d.write !== undefined ){
            delete d.write;
          }
          if ( !d.i18n || !d.i18n.length ){
            delete d.i18n;
          }
          if (!d.i18n || !d.i18n.length || !d.allow_children) {
            delete d.i18n_inheritance;
          }
          if ( d.root_alias ){
            delete d.root_alias;
          }
          if ( d.id ){
            delete d.id;
          }
          return d;
        };
        data.cfg = clearData(data.cfg);
        if ( this.showScfg ){
          data.cfg.scfg = clearData(data.scfg);
        }
        else {
          if ( data.cfg.scfg !== undefined ){
            delete data.cfg.scfg;
          }
        }
        delete data.scfg;
        return true;
      },
      onSuccess() {
        let tab = bbn.vue.closest(this, 'bbn-container'),
            list = bbn.vue.find(tab, 'appui-option-list'),
            table = list ? list.getRef('table') : false;
        if ( table && table.hasStorage ){
          table.storage.remove(table._getStorageRealName());
          this.$nextTick(() => {
              tab.reload();
          });
        }
        else if( this.tree ){
          this.tree.tree.$refs.listOptions.selectedNode.$parent.reload();
        }
        else{
          tab.reload();
        }
      },
      browseAlias(src) {
        this.getPopup().open({
          width: 500,
          height: 600,
          title: bbn._('Options'),
          component: 'appui-option-browse',
          source: {
            data: src
          }
        });
      },
      setToRoot(){
        this.$set(this.data.cfg, 'id_root_alias', '');
        this.$set(this.data.cfg, 'root_alias', bbn._('Root'));
      },
      setToRootScfg(){
        this.$set(this.data.scfg, 'id_root_alias', '');
        this.$set(this.data.scfg, 'root_alias', bbn._('Root'));
      },
      unlock(){
        this.data.cfg.frozen = false;
        this.data.cfg.inherit_from = '';
        //this.data.cfg.inherit_from_text = '';
        this.data.cfg_inherit_from_text = '';
      },
      reset(){
        this.confirm(bbn._('Are you sure you want to back to the default configuration?'), () => {
          this.post(this.root + 'actions/default', {id: this.source.id}, d => {
            if ( d.success ){
              appui.success(bbn._('Success'));
              this.onSuccess();
            }
          })
        });
      }
    },
    mounted(){
      if (!appui.plugins['appui-option'] || controllers) {
        this.ready = true;
      }
      else{
        this.post(appui.plugins['appui-option'] + '/plugins', (d) => {
          if (d.controllers) {
            controllers = d.controllers;
          }
          this.ready = true;
        });
      }
    },
    watch:{
      /*
      rootAlias(val, oldVal){
        cfg: bbn.fn.extend(this.source.cfg, {root_alias: val}),
      }
      */
      showScfg(newVal){
        if ( !newVal ){
          this.data.scfg = this.defaultScfg;
        }
        else {
          this.data.cfg.inheritance = '';
        }
      },
      'data.cfg.allow_children'(newVal){
        if ( newVal && !!this.source.cfg.scfg ){
          this.showScfg = !!newVal;
        }
      }
    }
  }
})();
