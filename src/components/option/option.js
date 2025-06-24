(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    data(){
      return {
        isMobile: bbn.fn.isMobile(),
        data: this.source.option ? this.source : null,
        isLoading: true,
        tree: appui.getRegistered('appui-option-tree') || null,
        isAdmin: appui.user.isAdmin
      }
    },
    methods: {
      onNotFound(e, uid) {
        const currentUid = this.getRef('router').currentURL.split('/')[0];
        if (bbn.fn.isUid(uid) && (uid !== currentUid)) {
          e.preventDefault();
          if (this.tree.currentId === currentUid) {
            this.tree.changeSelected(uid, 'options');
          }

          bbn.fn.log(["notfound", "currentId: " + this.tree.currentId, "Uid from router: " + currentUid, "UID given: " + uid, this.data, arguments, this.getRef('router').currentURL]);
        }
      },
      onRoute(route) {
        this.$emit('route', route);
      },
      deleteValues() {
        const obj = {
          id: this.data.option.id,
          id_alias: this.data.option.id_alias,
          value: null,
          text: null,
          code: null
        };
        this.post(appui.plugins['appui-option'] + "/actions/update", obj, d => {
          if (d.success) {
            bbn.fn.iterate(obj, (v, k) => {
              if (v !== this.data.option[k]) {
                this.data.option[k] = obj[k];
              }
            });
            appui.success(bbn._('Values deleted'));
          }
          else {
            appui.error(d.error || '');
          }
        });
      },
      deleteConfig() {
        this.post(appui.plugins['appui-option'] + "/actions/cfg", {
          id: this.data.option.id,
          cfg: null
        }, d => {
          if (d.success) {
            this.data.realCfg = null;
            appui.success(bbn._('Configuration deleted'));
          }
          else {
            appui.error(d.error || '');
          }
        });
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
    }
  }
})()