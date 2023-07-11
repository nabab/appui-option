// Javascript Document
/* jshint esversion: 6 */
(() => {
  return {
    data(){
      return {
        showTable: true,
        currentTranslation: false
      }
    },
    computed: {
      tableData(){
        return bbn.fn.extend({root: this.source.root}, this.source.cfg);
      },
      schema(){
        if ( this.source.cfg.schema ){
          return typeof this.source.cfg.schema === 'string' ? JSON.parse(this.source.cfg.schema) : this.source.cfg.schema;
        }
        return [];
      }
    },
    methods: {
      getToolbar(){
        let res = [];
        if ( this.source.parent && !this.source.cfg.noparent ){
          res.push({
            text: this.source.parent_text,
            icon: 'nf nf-fa-angle_double_left',
            action: this.goParent,
            disabled: !this.source.parent
          });
        }
        if ( this.source.is_dev ){
          res.push({
            text: bbn._('Configuration'),
            icon: 'nf nf-fa-cog',
            action: this.openConfig
          });
        }
        if ( this.source.cfg.sortable && this.source.cfg.write ){
          res.push({
            text: bbn._('Fix order'),
            icon: 'nf nf-fa-sort_numeric_asc',
            action: this.fixNum
          });
        }
        if ( this.source.cfg.write ){
          res.push({
            text: bbn._('Add'),
            icon: 'nf nf-fa-plus',
            action: this.insert
          });
        }
        return res;
      },
      goParent(){
        if ( this.source.parent ){
          bbn.fn.link(this.source.root + 'list/' + this.source.parent);
        }
      },
      openConfig(){
        this.post(this.source.root + 'tree/option/' + this.source.id, d => {
          if (d && d.data) {
            this.getPopup({
              title: bbn._("Option's configuration"),
              component: 'appui-option-config',
              source: d.data,
              maxWidth: 1000,
              width: '80vw'
            });
          }
        })
      },
      fixNum(){
        this.post(this.source.root + 'actions/fix_order/' + this.source.id, (d) => {
          if ( d.data ){
            this.$set(this.source, 'options', d.data);
            this.$nextTick(() => {
              this.$refs.table.updateData();
              appui.success(bbn._('Fixed'));
            });
          }
          else{
            appui.error();
          }
        });
      },
      mapTable(row){
        if ( this.schema && this.schema.length && row.value ){
          let val = typeof row.value === 'string' ? JSON.parse(row.value, (k, v) => {
            if ( 'null' === v ){
              v = null;
            }
            return v;
          }) : row.value;
          bbn.fn.iterate(val, (v, k) => {
            this.$set(row, k, v);
          })
          bbn.fn.each(this.schema, obj => {
            if ( row[obj.field] === undefined ){
              this.$set(row, obj.field, obj.default !== undefined ? (obj.default === 'null' ? null : obj.default) : null);
            }
            else if ( (row[obj.field] !== undefined) && (obj.type !== undefined) && (obj.type.toLowerCase() === 'json') ){
              row[obj.field] = JSON.stringify(row[obj.field]);
            }
          });
        }
        return row;
      },
      schemaHasField(field){
        return field && this.schema && (bbn.fn.search(this.schema, 'field', field) > -1);
      },
      showSchemaField(field){
        return !(((field === 'code') && !this.source.cfg.show_code) ||
          ((field === 'id_alias') && !this.source.cfg.show_alias));
      },
      renderAlias(row){
        if ( row.id_alias && row.alias ){
          return '<a href="' + this.source.root + 'list/' + row.alias.id_parent + '">' + row.alias.text +
            (row.alias.code ? ' <span class="bbn-grey">(' + row.alias.code + ')</span>' : '') +
            '</a>';
        }
        return '-';
      },
      renderIcon(row){
        return row.icon ? '<i class="' + row.icon + '"></i>' : '';
      },
      renderButtons(row){
        let res = [];
        if ( this.source.cfg.write ){
          res.push({
            text: bbn._('Edit'),
            icon: 'nf nf-fa-edit',
            action: this.edit,
            notext: true
          });
          res.push({
            text: bbn._('Copy'),
            icon: 'nf nf-fa-copy',
            action: this.duplicate,
            notext: true
          });
          res.push({
            text: bbn._('Delete'),
            icon: 'nf nf-fa-trash',
            action: this.remove,
            notext: true
          });
        }
        if ( this.source.cfg.allow_children || this.source.cfg.categories ){
          res.push({
            text: bbn._('List'),
            icon: 'nf nf-fa-list',
            url: this.source.root + 'list/' + row.id,
            notext: true
          });
        }
        return res;
      },
      insert(){
        this.$refs.table.insert({}, {
          title: bbn._('New option'),
          maximizable: true
        });
      },
      edit(row, col, idx){
        this.post(appui.plugins['appui-option'] + '/data/text', {
          id: row.id
        }, d => {
          if (d.success) {
            this.currentTranslation = d.translations;
            if (d.text !== row.text) {
              row = bbn.fn.extend(true, {}, row, {text: d.text});
            }
          }
          else {
            this.currentTranslation = false;
          }
          this.$refs.table.edit(row, {
            title: bbn._('Updating option') + ' "' + row.text + '"',
            maximizable: true
          }, idx);
        })
      },
      duplicate(row){
        let newRow = bbn.fn.extend({}, row, {
          id: '',
          code: null
        });
        if ( this.source.cfg.sortable ){
          newRow.num = this.source.options.length + 1;
        }
        if ( row.num_children ){
          appui.confirm(bbn._("Do you also want to duplicate children options?"), () => {
            newRow.source_children = row.id;
            this.openDuplicateForm(newRow);
          }, () => {
            newRow.num_children = 0;
            this.openDuplicateForm(newRow);
          });
        }
        else{
          newRow.num_children = 0;
          this.openDuplicateForm(newRow);
        }
      },
      openDuplicateForm(newRow){
        if ( newRow ){
          this.$refs.table.insert(newRow, {
            title: bbn._('Copy option'),
            height: 600,
            width: 700
          });
        }
      },
      remove(row){
        if ( row.id ){
          appui.confirm(bbn._('Are you sure you want to delete this entry?'), () => {
            this.post(this.source.root + 'actions/delete', {id: row.id}, (d) => {
              if ( d.success ){
                let idx = bbn.fn.search(this.source.options, 'id', row.id);
                if ( idx > -1 ){
                  this.source.options.splice(idx, 1);
                  this.$refs.table.updateData();
                  appui.success(bbn._('Deleted'));
                }
                else{
                  appui.error();
                }
              }
            });
          });
        }
      }
    },
    components: {
      'appui-option-list-fixnum': {
        name: 'appui-option-list-fixnum',
        template: `
  <bbn-dropdown :source="src"
                :value="source.num"
                class="bbn-w-100"
                @change="setNum"
                ref="dropdown"
  ></bbn-dropdown>
        `,
        props: ['source'],
        computed: {
          list(){
            return this.closest('appui-option-list');
          },
          src(){
            return Array.from({length: this.list.$refs.table.total}, (v, k) => k + 1);
          }
        },
        methods: {
          setNum(val){
            if ( val ){
              this.post(this.list.source.root + 'actions/order', {
                id: this.source.id,
                num: val
              }, (d) => {
                if ( d.success && d.data ){
                  this.$set(this.list.source, 'options', d.data);
                  this.$nextTick(() => {
                    this.list.$refs.table.updateData();
                    appui.success(bbn._('Saved'));
                  });
                }
                else{
                  appui.error();
                }
              });
            }
          }
        },
        updated(){
          if ( this.$refs.dropdown && this.$refs.dropdown.widget ){
            this.$refs.dropdown.widget.value(this.source.num);
          }
        }
      }
    }
  }
})();