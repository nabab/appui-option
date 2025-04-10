(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    props: ['source', 'configuration'],
    data() {
      const target = this.source.option || this.source.row || this.source;
      const currentSource = new Proxy(target, {
        set(obj, prop, value) {
          obj[prop] = value;
          return true;
        },
        get(obj, prop) {
          const value = target[prop];
          if (!(prop in obj)) {
            target[prop] = '';
          }

          return obj[prop];
        }
      });
      return {
        root: appui.plugins['appui-option'] + '/',
        currentSource,
        cfg: this.configuration || this.source.cfg
      }
    },
    computed: {
      alias(){
        return this.currentSource.alias ? this.currentSource.alias.text : '';
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
      }
    },
    methods: {
      schemaHasField(field){
        return field && this.currentComp.schema && (bbn.fn.search(this.currentComp.schema, 'field', field) > -1);
      },
      showField(f){
        if ( ((f.field === 'code') && !this.cfg.show_code) ||
          ((f.field === 'id_alias') && (this.cfg.relation !== 'alias')) ||
          ((f.field === 'value') && !this.cfg.show_value) ||
          ((f.field === 'tekname') && !this.cfg.categories)
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
            data: this.currentSource
          }
        });
      },
      clearAlias(){
        this.currentSource.id_alias = '';
        this.alias = '';
      },
      selectIcon(){
        this.getPopup({
          width: '80%',
          height: '80%',
          label: bbn._('Icon Picker'),
          component: 'appui-core-popup-iconpicker',
          source: {
            field: 'icon',
            obj: this.currentSource
          }
        });
      },
      beforeSend(d){
        if ( !this.currentComp ){
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
            if ( this.currentSource.id ){
              let idx = bbn.fn.search(this.list.source.options, 'id', this.currentSource.id);
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
            this.tree.tree.optionSelected.id = false;
            this.$nextTick(() => {
              if ( list.selectedNode ){
                let parent = list.selectedNode.parent;
                let id = list.selectedNode.source.data.id;
                list.selectedNode.parent.reload().then(() => {
                  this.$nextTick(() => {
                    parent.selectPath(id);
                  })
                });
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
