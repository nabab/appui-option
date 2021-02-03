// Javascript Document
(()=>{
  return {
    data(){
      return {
        option: '{}',
        cfg: '{}',
        optionSelected: {
          id: '',
          text: '',
          code: null,
          showUsage: {
            tree : false,
            occourences: false,
            dataTables: false
          }
        },
        treeMenu: [{
          text: bbn._('Delete'),
          icon: 'nf nf-fa-times',
          action: this.deleteOption
        }, {
          text: bbn._('Import'),
          icon: 'nf nf-fa-arrow_up',
          action: this.importOption
        }, {
          text: bbn._('Export option'),
          icon: 'nf nf-fa-arrow_down',
          action: (node) => {
            this.exportOption(node)
          }
        }, {
          text: bbn._('Export children'),
          icon: 'nf nf-fa-arrow_down',
          action: (node) => {
            this.exportOption(node, true)
          }
        }, {
          text: bbn._('Export tree'),
          icon: 'nf nf-fa-arrow_down',
          action: (node) => {
            this.exportOption(node, 'full')
          }
        }],
        isAdmin: appui.app.user.isAdmin,
        appuiTree: false,
        routerRoot: appui.plugins['appui-option'] + '/tree/'
      }
    },
    computed: {
      storageName(){
        if (this.closest('bbn-floater')) {
          return undefined;
        }
        return 'appui-option-tree';
      },
      hasChildren(){
        if ( this.option ){
          return !!JSON.parse(this.option)['num_children']
        }
      },
      currentUrl(){
        if ( this.$refs.router && this.$refs.router.activeContainer ){
          let tn = this.$refs.router.activeContainer.find('bbn-router');
          if ( tn && tn.activeContainer ){
            return '/' + tn.activeContainer.url;
          }
        }
        return '';
      }
    },
    methods: {
      importOption(node){
        this.getPopup({
          title: 'Import into option ' + node.data.text,
          component: 'appui-option-import',
          source: {
            root: this.source.root,
            data: {
              id: node.data.id,
              option: ''
            }
          },
          width: '100%',
          height: '100%',
          closable: true,
          maximizable: false
        })
      },
      exportOption(node, children) {
        let data = {id: node.data.id, mode: 'single'};
        if (children) {
          if (children === 'full') {
            data.mode = 'full';
          }
          else {
            data.mode = 'children';
          }
        }
        this.post(this.source.root + 'actions/export', data, (d) => {
          if ( d.success ){
            this.getPopup({
              content: '<textarea class="bbn-100">' + d.export + '</textarea>',
              title: 'Export option ' + node.text,
              width: '100%',
              height: '100%',
              scrollable: false,
              closable: true,
              maximizable: false
            });
          }
        })
      },
      deleteOption(node){
        bbn.fn.log(arguments);
      },
      deleteCache(node){
        this.post(this.source.root + 'actions/delete_cache', (d) => {
          if ( d.success ){
            appui.success();
            this.$refs.listOptions.reset();
          }
          else{
            appui.error();
          }
        })
      },
      treeMapper(d, l, n){
        n.text = d.text || (d.alias && d.alias.text ? '<em style="color:#4285f4">'+ d.alias.text +'</em>' : d.code);
        if ( (d.code !== undefined) && (d.code !== null) ){
          n.text += ' &nbsp; <span class="bbn-grey"> (' + d.code + ')</span>';
        }
        return n;
      },
      treeNodeActivate(n){
        bbn.fn.link(appui.plugins['appui-option'] + '/tree/option/' + n.data.id + this.currentUrl, true);
      },
      moveOpt(node, nodeDest, ev){
        ev.preventDefault();
        this.post(appui.plugins['appui-option'] + '/actions/move', {
          idNode: node.data.id,
          idParentNode: nodeDest.data.id
        }, d => {
          if ( d.success ){
            appui.success(bbn._('Option successfully moved'));
            this.getRef('listOptions').move(node, nodeDest, true);
          }
          else{
            appui.error(bbn._('Error!! Option not moved'))
          }
        });
      }
    },
    beforeMount(){
      if ( this.source.option ){
        let opt = JSON.parse(this.source.option.info);
        this.cfg = this.source.option.cfg;
        this.option = this.source.option.info
        this.optionSelected.id = opt.id;
        this.optionSelected.code = opt.code;
        this.optionSelected.text = opt.text;
      }
    },
    watch: {
      appuiTree(){
        this.post(appui.plugins['appui-option'] + '/tree/typeTree',{appuiTree: this.appuiTree}, d => {
          if ( this.source.cat !== d.data.id_cat ){
            this.$set(this.source, 'cat', d.data.id_cat);
            if ( this.optionSelected.id.length > -1 ){
              this.optionSelected.id = '';
              this.optionSelected.text = '';
              this.optionSelected.code = null;
              this.option = '{}';
              this.cfg = '{}';
            }
            this.$refs.listOptions.reload();
          }
        });
      }
    }
  }
})();
