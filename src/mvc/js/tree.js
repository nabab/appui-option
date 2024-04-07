// Javascript Document
(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    data() {
      return {
        root: appui.plugins['appui-option'] + '/',
        option: '{}',
        cfg: '{}',
        optionSelected: {
          id: '',
          text: '',
          code: null,
          showUsage: {
            tree: false,
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
          text: bbn._('Export option for database'),
          icon: 'nf nf-fa-arrow_down',
          action: this.exportOption
        }, {
          text: bbn._('Export option for import'),
          icon: 'nf nf-fa-arrow_down',
          action: node => this.exportOption(node, 'simple')
        }, {
          text: bbn._('Export children for import'),
          icon: 'nf nf-fa-arrow_down',
          action: node => this.exportOption(node, 'schildren')
        }, {
          text: bbn._('Export children for database'),
          icon: 'nf nf-fa-arrow_down',
          action: node => this.exportOption(node, 'children')
        }, {
          text: bbn._('Export tree for import'),
          icon: 'nf nf-fa-arrow_down',
          action: node => this.exportOption(node, 'sfull')
        }, {
          text: bbn._('Export tree for database'),
          icon: 'nf nf-fa-arrow_down',
          action: node => this.exportOption(node, 'full')
        }],
        isAdmin: appui.user.isAdmin,
        appuiTree: false,
        dataObj: {
          appuiTree: false,
        },
        routerRoot: appui.plugins['appui-option'] + '/tree/'
      }
    },
    computed: {
      storageName() {
        if (this.closest('bbn-floater')) {
          return undefined;
        }
        return 'appui-option-tree';
      },
      hasChildren() {
        if (this.option) {
          return !!this.option?.num_children
        }
      },
      currentUrl() {
        if (this.$refs.router && this.$refs.router.routed) {
          return '/' + this.$refs.router.getCurrentURL();
        }

        return '';
      }
    },
    methods: {
      importOption(node) {
        this.closest('bbn-container').getPopup({
          title: 'Import into option ' + node.data.text,
          component: 'appui-option-import',
          source: {
            root: this.root,
            data: {
              id: node.data.id,
              option: ''
            }
          },
          width: '90%',
          height: '90%',
          closable: true,
          maximizable: false
        })
      },
      exportOption(node, mode) {
        let data = { id: node.data.id, mode: mode || 'single' };
        this.post(this.root + 'actions/export', data, (d) => {
          if (d.success) {
            this.getPopup({
              content: '<div class="bbn-overlay"><textarea class="bbn-100">' + d.export + '</textarea></div>',
              title: 'Export option ' + node.data.text + (node.data.code ? ' (' + node.data.code + ')' : ''),
              width: '90%',
              height: '90%',
              scrollable: false,
              closable: true,
              maximizable: false
            });
          }
        })
      },
      deleteOption(node) {
        bbn.fn.log(['ON DELETE OPTION', arguments]);
      },
      deleteCache(node) {
        this.post(this.root + 'actions/delete_cache', (d) => {
          if (d.success) {
            appui.success();
            this.$refs.listOptions.reset();
          }
          else {
            appui.error();
          }
        })
      },
      treeMapper(d, l, n) {
        if (!n.data) {
          n.data = bbn.fn.createOject();
        }
        n.data.text = d.text || (d.alias && d.alias.text ? '<em style="color:#4285f4">' + d.alias.text + '</em>' : d.code);
        if ((d.code !== undefined) && (d.code !== null)) {
          n.data.text += ' &nbsp; <span class="bbn-grey"> (' + d.code + ')</span>';
        }
        return n;
      },
      treeNodeActivate(node) {
        if (node && node.data && node.data.id) {
          this.optionSelected.id = node.data.id;
          this.optionSelected.code = node.data.code;
          this.optionSelected.text = node.data.text;
          bbn.fn.log(['treeNodeActivate', this.root + 'tree/option/' + node.data.id, this.currentUrl])
          bbn.fn.link(this.root + 'tree/option/' + node.data.id, true);
        }
      },
      moveOpt(node, nodeDest, ev) {
        if (ev.cancelable) {
          ev.preventDefault();
          this.post(this.root + 'actions/move', {
            idNode: node.data.id,
            idParentNode: nodeDest.data.id
          }, d => {
            if (d.success) {
              appui.success(bbn._('Option successfully moved'));
              this.getRef('listOptions').move(node, nodeDest, true);
            }
            else {
              appui.error(bbn._('Error!! Option not moved'))
            }
          });
        }
        else {
          nodeDest.reload();
        }
      }
    },
    beforeMount() {
      if (this.source.option) {
        let opt = this.source.option.info;
        this.cfg = this.source.option.cfg;
        this.option = this.source.option.info
        this.optionSelected.id = opt.id;
        this.optionSelected.code = opt.code;
        this.optionSelected.text = opt.text;
      }
      else {
        const ct = this.closest('bbn-container');
        if (ct.currentCurrent !== ct.currentURL) {
          bbn.fn.warning("JJJJJJJJJJJJ")
        }
      }
    },
    watch: {
      appuiTree(v) {
        this.dataObj.appuiTree = v;
        this.optionSelected.id = '';
        this.optionSelected.text = '';
        this.optionSelected.code = null;
        this.option = '{}';
        this.cfg = '{}';
        this.$refs.listOptions.updateData();
        delete this.dataObj.appuiTree;
      }
    }
  }
})();
