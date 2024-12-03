// Javascript Document
(()=>{
  return {
    mixins: [bbn.cp.mixins.basic],
    data(){
      return {
        option: '{}',
        optionSelected:{
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
          text: bbn._('Export'),
          icon: 'nf nf-fa-arrow_down',
          action: this.exportOption
        }]
      }
    },
    computed: {
      treeInitialData(){
        return this.data
      }
    },
    methods: {
      importOption(node){
        this.getPopup({
          title: 'Import into option ' + node.text,
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
      exportOption(node){
        this.post(this.source.root + 'actions/export', {id: node.data.id}, (d) => {
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
        bbn.fn.log(arguments);
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
      deleteSingleCache(){
        this.post(this.source.root + 'actions/delete_cache',{
          id: this.optionSelected.id
        }, (d) => {
          if ( d.success ){
            appui.success("Delete");
          }
          else{
            appui.error("No delete cache");
          }
        })
      },
      treeMapper(d){    
        let obj= {
          data: d,
          id: d.id,
          code: d.code,
          icon: d.icon,
          text: d.text ? d.text :
            (d.alias && d.alias.text ? '<em style="color:#4285f4">'+ d.alias.text +'</em>' : d.code),
          num: d.num_children || 0
        };
        if ( d.code !== null ){
          obj.text += ' &nbsp; <span class="bbn-grey">' +  "(" + d.code +  ")" + '</span>';
        }
        return obj
      },
      treeNodeActivate(d){
        this.post(this.source.root + 'data/get_info',{
          id: d.data.id
        }, ele => {
          if( ele.success ){
            let text = d.text.split("&nbsp");
            this.optionSelected.id = d.data.id;
            this.optionSelected.text = text[0];
            this.optionSelected.code = d.data.code;
            this.option= ele.info;
          }
          else{
            appui.error(bbn._('Impossible to retrieve information about this element'));
          }
        });
      },
      linkOption(){
        if ( this.optionSelected.id.length ){
          bbn.fn.link(this.source.root + "list/" + this.optionSelected.id);
        }
      },
      showUsageOpt(){
        this.post(this.source.root + "actions/show_used_option",{
          id: this.optionSelected.id
        }, d => {
          if ( d.success && d.tree ){
            this.optionSelected.showUsage.tree = d.tree;
            this.optionSelected.showUsage.occourences = d.totalReferences;
            this.optionSelected.showUsage.dataTables = d.tables;
            this.getPopup({
              width: 450,
              height: 550,
              title: bbn._('Usage'),
              component: 'appui-option-popup-tree',
              source: {
                treeData: d.tree,
                result: d.totalReferences,
                option: this.optionSelected.text,
                codeOpt: this.optionSelected.code ? this.optionSelected.code : false,
              }
            });
          }
        });
      },
      moveOpt(ev,node,nodeDest){
        let obj ={
          idNode: node.data.id,
          idParentNode: nodeDest.data.id
        };
        ev.preventDefault();
        this.post(this.source.root + 'actions/move', obj , (d) => {
          if ( d.success ){
            appui.success(bbn._('Option successfully moved'));
          }
          else{
            appui.error(bbn._('Error!! Option not moved'))
          }

        });
        if (nodeDest.level>0){
          nodeDest.parent.reload();
        }
        if (nodeOrig.level>0){
          nodeOrig.parent.reload();
        }
      }
    }
  }
})();
