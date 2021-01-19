(() => {
  return {
    data(){
      return {
        alias: this.source.row && this.source.row.alias ? this.source.row.alias.text : (this.source.alias ? this.source.alias.text : ''),
        root: appui.plugins['appui-options'] + '/',
        currentSource: this.source.row || this.source
      }
    },
    computed: {
      list(){
        let tab = this.closest('bbn-container')
        return tab ? (tab.find('appui-options-list') || null) : null
      },
      tree(){
        return this.closest('appui-options-option') || null
      },
      currentComp(){
        return this.list || this.tree
      },
      cfg(){
        if ( this.list ){
          return this.list.source.cfg
        }
        else if ( this.tree ){
          return this.tree.cfg
        }
        return {}
      },
      inPopup(){
        return !!this.closest('bbn-popup');
      },
    },
    methods: {
      schemaHasField(field){
        return field && this.currentComp.schema && (bbn.fn.search(this.currentComp.schema, 'field', field) > -1);
      },
      showField(f){
        if ( ((f.field === 'code') && !this.cfg.show_code) ||
          ((f.field === 'id_lias') && !this.cfg.show_alias) ||
          ((f.field === 'value') && !this.cfg.show_value) ||
          ((f.field === 'tekname') && !this.cfg.categories)
        ){
          return false;
        }
        return true;
      },
      selectAlias(){
        this.getPopup().open({
          width: 500,
          height: 600,
          title: bbn._('Options'),
          component: 'appui-options-browse',
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
        this.getPopup().open({
          width: '80%',
          height: '80%',
          title: bbn._('Icon Picker'),
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
      success(d){
        if ( d.success && d.data ){
          if ( this.list ){
            if ( this.currentSource.id ){
              let idx = bbn.fn.search(this.list.source.options, 'id', this.currentSource.id);
              if ( idx > -1 ){
                this.list.source.options[idx] = d.data;
              }
              else{
                appui.error();
              }
            }
            else {
              this.list.source.options.push(d.data);
            }
            this.list.$refs.table.updateData();
          }
          else if ( this.tree ){
            let list = this.tree.tree.getRef('listOptions');
            if ( list.selectedNode ){
              list.selectedNode.parent.reload();
            }
            else {
              list.reload();
            }
          }
          appui.success(bbn._('Saved'));
        }
        else {
          appui.error();
        }
      }
    }
  }
})();
