(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    data(){
      return {
        cfg: {
          show_code: true,
          show_alias: true,
          show_value: true,
          show_id: true
        },
        isMobile: bbn.fn.isMobile(),
        data: this.source.option ? this.source : null
      }
    },
    computed: {
      tree(){
        return this.closest('bbn-container').closest('bbn-container').getComponent()
      },
      isAdmin(){
        return appui.user.isAdmin
      }
    },
    methods: {
      onRoute(route) {
        this.$emit('route', route);
      },
      showUsageOpt(){
        this.post(appui.plugins['appui-option'] + "/actions/show_used_option", {
          id: this.source.option.id
        }, d => {
          if ( d.success && d.tree ){
            //this.optionSelected.showUsage.tree = d.tree;
            //this.optionSelected.showUsage.occourences = d.totalReferences;
            //this.optionSelected.showUsage.dataTables = d.tables;
            this.getPopup({
              width: 450,
              height: 550,
              label: bbn._('Usage'),
              component: 'appui-option-popup-tree',
              source: {
                treeData: d.tree,
                result: d.totalReferences,
                option: this.data.option.text,
                codeOpt: this.data.option.code || false,
              }
            });
          }
          else if ( d.success && !d.tree ){
            this.alert(bbn._('No occurrence of this option found'))
          }
        })
      }
    },
    mounted() {
      let id = this.source.id;
      if (!id && this.closest('bbn-container').hasArguments()) {
        id = this.closest('bbn-container').args[0];
      }

      if (!this.data && id) {
        bbn.fn.post(appui.plugins['appui-option'] + '/tree/option', {id}, d => {
          if (d.success) {
            delete d.success;
            this.data = d;
            this.$emit('update', d);
          }
        })
      }
    }
  }
})()