// Javascript Document
(() => {
  return {
    statics() {
      return {
        controllers: false
      };
    },
    mixins: [bbn.cp.mixins.basic],
    props: ['source', 'optionId'],
    data() {
      return {
        currentSchema: this.source.schema || [],
        ready: false,
        models: [],
        views: [],
        showSchema: !!this.source.schema,
        aliasRelations: [{
          text: bbn._('No relations'),
          value: '',
        }, {
          text: bbn._('Use alias'),
          value: 'alias',
        }, {
          text: bbn._('Use template'),
          value: 'template',
        }],
        tree: appui.getRegistered('appui-option-tree') || null,
        jsonDataTemplate: [{
          text: bbn._('Field'),
          title: bbn._('Insert a form field'),
          className: 'jsoneditor-type-object',
          value: {
            label: bbn._('Insert a title'),
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
        structureTypes: [{
          text: bbn._("No properties"),
          value: 'none'
        }, {
          text: bbn._("Free structure"),
          value: 'json'
        }, {
          text: bbn._("Schema"),
          value: 'schema'
        }],
        showReset: !this.source.frozen,
        root: appui.plugins['appui-option'] + '/',
        isFrozen: !!this.source.frozen || this.source.useTemplate,
      }
    },
    computed: {
      structureType: {
        get() {
          if (this.source.show_value) {
            return 'json';
          }
          else if (this.source.schema) {
            return 'schema';
          }
          else {
            return 'none';
          }
        },
        set(v) {
          if (v === 'json') {
            this.source.show_value = true;
            this.source.schema = null;
          }
          else if (v === 'schema') {
            this.source.schema = this.currentSchema;
            this.source.show_value = false;
          }
          else {
            this.source.schema = null;
            this.source.show_value = false;
          }
        }
      },
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
        if (this.source.permissions) {
          str += ' <strong>' + this.source.permissions.from_text + '</strong>';
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

        if (this.source.allow_children && this.canDefineSubPermissions) {
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
        return this.constructor.controllers;
      },
    },
    methods: {
      toggleSchema() {
        this.showSchema = !this.showSchema;
      },
      toggleSchemaScfg() {
        this.showSchemaScfg = !this.showSchemaScfg;
      },
      onSuccess() {
        let tab = this.closest('bbn-container'),
            list = tab.find('appui-option-list'),
            table = list ? list.getRef('table') : false;
        if ( table && table.hasStorage ){
          table.storage.remove(table._getStorageRealName());
          this.$nextTick(() => {
              tab.reload();
          });
        }
        else if (this.tree?.currentNode && (this.tree.currentNode.data?.id === this.data.id)) {
          this.tree.currentNode.parent.reload();
        }
        else{
          tab.reload();
        }
      },
      browseAlias(src) {
        this.getPopup({
          width: 500,
          height: 600,
          label: bbn._('Options'),
          component: 'appui-option-browse',
          source: {
            data: src
          }
        });
      },
    },
    mounted(){
      if (!appui.plugins['appui-option'] || this.constructor.controllers) {
        this.ready = true;
      }
      else{
        this.post(appui.plugins['appui-option'] + '/controllers', (d) => {
          if (d.data) {
            this.constructor.controllers = d.data;
          }
          this.ready = true;
        });
      }
    },
    watch:{
      isFrozen(newVal){
        if (newVal) {
        }
      },
      currentSchema(newVal){
        this.source.schema = newVal;
      },
    }
  }
})();
