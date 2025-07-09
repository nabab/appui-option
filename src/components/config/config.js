// Javascript Document
(() => {
  const getDefaultCfg = o => {
    const cfg = bbn.fn.extend({
      allow_children: null,
      alias_name: "",
      categories: null,
      controller: null,
      default: "",
      default_value: null,
      desc: "",
      form: null,
      frozen: 0,
      help: '',
      i18n: "",
      i18n_inheritance: "",
      id: "",
      id_template: null,
      inheritance: "",
      notext: 0,
      permissions: "",
      relations: '',
      root_alias: bbn._('Root'),
      schema: null,
      show_code: null,
      show_icon: 0,
      show_value: null,
      sortable: null,
      view: 0,
      write: true,
    }, o || {});
    if (cfg.id_template && (cfg.relations !== 'template')) {
      cfg.relations = 'template';
    }

    return cfg;
  };
  return {
    mixins: [bbn.cp.mixins.basic],
    props: ['source'],
    data() {
      return {
        optionId: this.source.option ? this.source.option.id : this.source.id,
        ready: false,
        models: [],
        views: [],
        showSchema: !!this.source.cfg.schema,
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
        showScfg: !!this.source.cfg.scfg,
        lastScfg: {},
        showReset: !this.source.cfg.frozen,
        root: appui.plugins['appui-option'] + '/',
        isFrozen: !!this.source.cfg.frozen || this.source.useTemplate,
        data: {
          id: this.optionId,
          cfg: getDefaultCfg(this.source.cfg)
        }
      }
    },
    methods: {
      transformData(data) {
        return {
          id: this.optionId,
          cfg: data
        }
      },
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
        data = clearData(data);
        if (this.showScfg) {
          data.scfg = clearData(data.scfg || {});
        }
        else {
          if (data.scfg !== undefined ){
            delete data.scfg;
          }
        }

        return true;
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
        else if (this.tree?.currentNode && (this.tree.currentNode.data?.id === this.optionId)) {
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
      unlock(){
        this.source.cfg.frozen = false;
        this.source.cfg.inherit_from = '';
        //this.data.cfg.inherit_from_text = '';
        this.source.cfg_inherit_from_text = '';
      },
      reset(){
        this.confirm(bbn._('Are you sure you want to back to the default configuration?'), () => {
          this.post(this.root + 'actions/default', {id: this.optionId}, d => {
            if ( d.success ){
              appui.success(bbn._('Success'));
              this.onSuccess();
            }
          })
        });
      }
    },
    watch: {
      cfg: {
        deep: true,
        handler(newVal) {
          this.source.cfg = bbn.fn.extend({}, newVal, true);
        }
      },
      isFrozen(newVal){
        if (newVal) {
        }
      },
      currentSchema(newVal) {
        this.source.cfg.schema = newVal;
      },
      /*
      rootAlias(val, oldVal){
        cfg: bbn.fn.extend(this.source.cfg, {root_alias: val}),
      }
      */
      showScfg(newVal){
        if (newVal) {
          this.source.cfg.scfg = getDefaultCfg(this.lastScfg);
        }
        else {
          this.lastScfg = this.source.cfg.scfg;
          delete this.source.cfg.scfg;
        }
      },
      'source.cfg.allow_children'(newVal){
        if ( newVal && !!this.source.cfg.scfg ){
          this.showScfg = !!newVal;
        }
      }
    }
  }
})();
