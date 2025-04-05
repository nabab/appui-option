(() => {
  return {
    mixins: [bbn.cp.mixins.basic, bbn.cp.mixins.input],
    props: {
      root: {
        type: String,
      },
      rootCode: {
        type: String
      },
      permission: {
        type: String,
        default: ''
      },
      path: {
        type: Array
      }
    },
    data(){
      return {
        sourceURL: appui.plugins['appui-option'] + '/permissions/tree',
        currentValue: this.value,
        currentPermission: this.permission,
        treeReady: false,
        treeWatch: false
      }
    },
    methods: {
      isSelectable(d) {
        if (d.data?.code) {
          return d.data.code.substr(-1) !== '/';
        }

        return false;
      },
      selectPermission(node) {
        this.currentValue = node.data.id;
        let pluginUrl = this.rootCode ? appui.plugins[this.rootCode] + '/' : '';
        this.currentPermission = pluginUrl + node.getPath('code').join('');
      },
      mapPermissions(a){
        a.text += '<span class="bbn-grey bbn-left-sspace">(' +  a.code + ')</span>';
        a.selectable = (a.icon === 'nf nf-fa-file') || a.icon === 'nf nf-fa-key';
        return a;
      },
      selectOnTree(){
        if (this.path) {
          if (this.treeReady) {
            this.getRef('tree').selectPath(this.path);
          }
          else {
            this.treeWatch = this.$watch('treeReady', (newVal) => {
              this.getRef('tree').selectPath(this.path);
              this.treeWatch();
            })
          }
        }
      }
    },
    watch: {
      currentValue(v) {
        this.emitInput(v)
      },
      "obj.icon"(v) {
        this.currentValue = v;
      },
      root(){
        this.$nextTick(() => {
          let tree = this.getRef('tree');
          if (tree) {
            tree.updateData().then(() => {
              this.selectOnTree();
            });
          }
        })
      },
      path(newVal) {
        this.$nextTick(() => {
          this.selectOnTree();
        });
      },
      treeReady(newVal){
        this.$nextTick(() => {
          this.selectOnTree();
        });
      }
    }
  }
})();

