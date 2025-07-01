(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    props: ['source', 'configuration'],
    data() {
      return {
        root: appui.plugins['appui-option'] + '/',
        cfg: this.configuration,
      }
    },
    computed: {
      currentIcon: {
        get() {
          if (!('icon' in this.source) && ('value' in this.source)) {
            try {
              const v = bbn.fn.isString(this.source.value) ? JSON.parse(this.source.value) : this.source.value;
              if (v && ('icon' in v)) {
                return v.icon;
              }
            }
            catch (e) {}

            return '';
          }

          return this.source.icon || '';
        },
        set(value) {
          if (!('icon' in this.source) && ('value' in this.source)) {
            try {
              const v = bbn.fn.isString(this.source.value) ? JSON.parse(this.source.value) : this.source.value;
              v.icon = value;
              this.source.value = JSON.stringify(v);
              return true;
            }
            catch (e) {}
          }

          this.source.icon = value;
          return true;
        }
      },
      alias(){
        return this.source.alias ? this.source.alias.text : '';
      },
      list(){
        let tab = this.closest('bbn-container')
        return tab ? (tab.find('appui-option-list') || null) : null
      },
      tree(){
        return this.closest('appui-option-option') || null
      },
      currentComp(){
        return this.list || this.tree
      },
      inPopup(){
        return !!this.closest('bbn-popup');
      },
      currentTranslation(){
        if (!!this.list) {
          return this.list.currentTranslation;
        }
        else if (!!this.tree
          && (this.tree.source.translations !== undefined)
        ) {
          return this.tree.source.translations;
        }
        return false;
      },
      unnecessaryFields() {
        const pc = this.cfg || {};
        const fields = [];
        const authorized = ['id', 'id_parent'];
        if (pc.schema) {
          pc.schema.forEach(f => {
            if (f.field && !authorized.includes(f.field)) {
              authorized.push(f.field);
            }
          });
        }
        if (pc.show_code) {
          authorized.push('code');
        }

        if (pc.show_icon) {
          authorized.push('icon');
        }

        if (pc.relations) {
          authorized.push('id_alias');
        }

        for (let n in this.source) {
          if (!authorized.includes(n)) {
            if ((n === 'id_alias') && !pc.relations) {
              fields.push(n);
            }
            else if (!pc.show_value) {
              fields.push(n);
            }
          }
        }
      }
    },
    methods: {
      schemaHasField(field){
        return field && this.cfg.schema && (bbn.fn.search(this.cfg.schema, 'field', field) > -1);
      },
      showField(f){
        if ( ((f.field === 'code') && !this.cfg.show_code) ||
          ((f.field === 'id_alias') && (this.cfg.relation !== 'alias')) ||
          ((f.field === 'value') && !this.cfg.show_value)
        ){
          return false;
        }

        return true;
      },
      selectAlias(){
        this.getPopup({
          width: 500,
          height: 600,
          label: bbn._('Options'),
          component: 'appui-option-browse',
          source: {
            idRootTree: this.cfg.id_root_alias,
            data: this.source
          }
        });
      },
      clearAlias(){
        this.source.id_alias = '';
        this.alias = '';
      },
      selectIcon(){
        this.getPopup({
          width: '80%',
          height: '80%',
          label: bbn._('Icon Picker'),
          component: 'appui-core-popup-iconpicker',
          source: {
            field: 'currentIcon',
            obj: this
          }
        });
      },
      beforeSend(d){
        if ( !this.source ){
          return false;
        }

        if ( (d.source_children !== undefined) && !d.source_children.length ){
          delete d.source_children;
        }
        return true;
      },
      success(d) {
        if ( d.success && d.data ){
          if ( this.list ){
            if ( this.source.id ){
              let idx = bbn.fn.search(this.list.source.options, 'id', this.source.id);
              if ( idx > -1 ){
                this.list.source.options[idx] = d.data;
              }
              else{
                appui.error(d);
              }
            }
            else {
              this.list.source.options.push(d.data);
            }
            this.list.$refs.table.updateData();
          }
          else if ( this.tree ){
            let list = this.tree.tree.getRef('tree' + bbn.fn.getField(this.tree.tree.blocks, 'id', a => a.index === this.tree.tree.currentIndex));
            const node = this.tree.tree.currentNode;
            this.$nextTick(() => {
              if (node){
                node.parent.reload()
              }
              else {
                list.reload();
              }
            })
          }
          appui.success(bbn._('Saved'));
        }
        else {
          appui.error(d);
        }
      },
      openI18n(){
        if (!!appui.plugins['appui-i18n']) {
          bbn.fn.link(appui.plugins['appui-i18n'] + '/page');
        }
      }
    }
  }
})();
