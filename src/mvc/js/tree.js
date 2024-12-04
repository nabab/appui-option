// Javascript Document
(() => {
  const getTreeMenu = (tree) => {
    return [{
      text: bbn._('Delete'),
      icon: 'nf nf-fa-times',
      action: node => tree.deleteOption(node)
    }, {
      text: bbn._('Import'),
      icon: 'nf nf-fa-arrow_up',
      action: node => tree.importOption(node)
    }, {
      text: bbn._('Export option for database'),
      icon: 'nf nf-fa-arrow_down',
      action: node => tree.exportOption(node)
    }, {
      text: bbn._('Export option for import'),
      icon: 'nf nf-fa-arrow_down',
      action: node => tree.exportOption(node, 'simple')
    }, {
      text: bbn._('Export children for import'),
      icon: 'nf nf-fa-arrow_down',
      action: node => tree.exportOption(node, 'schildren')
    }, {
      text: bbn._('Export children for database'),
      icon: 'nf nf-fa-arrow_down',
      action: node => tree.exportOption(node, 'children')
    }, {
      text: bbn._('Export tree for import'),
      icon: 'nf nf-fa-arrow_down',
      action: node => tree.exportOption(node, 'sfull')
    }, {
      text: bbn._('Export tree for database'),
      icon: 'nf nf-fa-arrow_down',
      action: node => tree.exportOption(node, 'full')
    }];
  };

  const generateBlocks = t => {
    const root = {
      id: 'root',
      index: -2,
      condition: () => t.isAdmin,
      buttons: [
        {
          text: bbn._("Back to Apps"),
          icon: "nf nf-md-chevron_double_right",
          iconPosition: 'right',
          action: () => t.goToBlock(-1)
        }
      ],
      source: t.source.root + "tree",
      root: t.source.absoluteRoot,
      select: node => t.treeNodeActivate(node),
      draggable: true
    };

    const apps = {
      id: 'apps',
      index: -1,
      condition: () => t.isAdmin,
      buttons: [
        {
          text: bbn._("Full tree"),
          icon: "nf nf-md-chevron_double_left",
          action: () => t.goToBlock(-2)
        }, {
          menu: [{
            text: bbn._("Menu"),
            items: [{
              text: bbn._("Root templates"),
              action: () => {
                t.templateSelected = true;
                t.goToBlock(0);
              }
            }, {
              text: bbn._("New app"),
              action: () => {
                t.resetNewItem(t.source.absoluteRoot);
                bbn.fn.link(t.source.root + 'tree/new_app');
              },
              icon: "nf nf-md-package_variant_plus"
            }]
          }],
        }, {
          text: bbn._("Options"),
          action: () => t.goToBlock(0)
        }
      ],
      source: t.roots,
      select: node => t.changeApp(node),
      draggable: false
    };

    const options = {
      id: 'options',
      index: 0,
      condition: () => !t.templateSelected,
      buttons: [
        {
          text: bbn._("Apps"),
          icon: "nf nf-md-chevron_double_left",
          action: () => t.goToBlock(-1)
        }, {
          menu: [{
            text: bbn._("Menu"),
            items: [{
              text: bbn._("New category"),
              action: () => {
                t.resetNewItem(t.currentApp?.rootOptions);
                bbn.fn.link(t.source.root + 'tree/new_option');
              }
            }, {
              text: bbn._("New category as link"),
              action: () => {
                t.resetNewItem(t.currentApp?.rootOptions);
                bbn.fn.link(t.source.root + 'tree/new_alias');
              }
            }, {
              text: bbn._("App templates"),
              action: () => {
                t.templateSelected = true;
                t.goToBlock(1);
              }
            }]
          }],
        }, {
          text: bbn._("Plugins"),
          action: () => t.goToBlock(1),
          iconPosition: 'right',
          icon: "nf nf-md-chevron_double_right",
        }
      ],
      source: t.source.root + 'tree',
      root: t.currentApp?.rootOptions,
      select: node => t.treeNodeActivate(node),
      draggable: true
    };

    const rootTemplates = {
      id: 'rootTemplates',
      index: 0,
      condition: () => t.templateSelected,
      buttons: [
        {
          text: bbn._("Back to Apps"),
          icon: "nf nf-md-chevron_double_left",
          action: () => t.backFromTemplate()
        }, {
          text: bbn._("New root template"),
          icon: "nf nf-md-receipt_text_plus_outline",
          action: () => {
            t.resetNewItem(t.source.rootTemplates);
            bbn.fn.link(t.source.root + 'tree/new_template');
          },
        }
      ],
      source: t.source.root + 'tree',
      root: t.source.rootTemplates,
      select: node => t.treeNodeActivate(node),
      draggable: true
    };

    const plugins = {
      id: 'plugins',
      index: 1,
      buttons: [
        {
          text: bbn._("Options"),
          action: () => t.goToBlock(0),
          icon: "nf nf-md-chevron_double_left"
        }, {
          menu: [{
            text: bbn._("Menu"),
            items: [{
              text: bbn._("New Plugin"),
              icon: "nf nf-md-puzzle_plus",
              action: () => {
                t.resetNewItem(t.currentApp?.rootPlugins);
                bbn.fn.link(t.source.root + 'tree/new_plugin');
              }
            }, {
              text: bbn._("New Plugin alias"),
              icon: "nf nf-md-puzzle_plus",
              action: () => {
                t.resetNewItem(t.currentApp?.rootPlugins);
                bbn.fn.link(t.source.root + 'tree/new_alias');
              }
            }]
          }],
        }
      ],
      source: t.currentApp?.plugins,
      select: node => t.activatePlugin(node),
      draggable: false
    };

    const appTemplates = {
      id: 'appTemplates',
      index: 1,
      condition: () => t.templateSelected,
      buttons: [
        {
          text: bbn._("Back to Apps"),
          icon: "nf nf-md-chevron_double_left",
          action: () => t.backFromTemplate()
        }, {
          text: bbn._("New template"),
          icon: "nf nf-md-receipt_text_plus_outline",
          action: () => {
            t.resetNewItem(t.currentApp?.rootTemplates);
            bbn.fn.link(t.source.root + 'tree/new_template');
          },
        }
      ],
      source: t.source.root + 'tree',
      root: t.currentApp?.rootTemplates,
      select: node => t.treeNodeActivate(node),
      draggable: true
    };

    const plugin = {
      id: 'plugin',
      index: 2,
      buttons: [
        {
          text: bbn._("Plugins"),
          action: () => t.goToBlock(1),
          icon: "nf nf-md-chevron_double_left"
        }, {
          menu: [{
            text: bbn._("Menu"),
            items: [{
              text: bbn._("Plugin templates"),
              action: () => {
                t.templateSelected = true;
                t.goToBlock(3);
              }
            }, {
              text: bbn._("New option"),
              icon: "nf nf-md-table_column_plus_after",
              action: () => {
                t.resetNewItem(t.currentPlugin?.rootOptions);
                bbn.fn.link(t.source.root + 'tree/new_option');
              },
            }]
          }],
        }, {
          text: bbn._("Subplugins"),
          action: () => t.goToBlock(3),
          iconPosition: 'right',
          icon: "nf nf-md-chevron_double_right"
        }
      ],
      source: t.source.root + 'tree',
      root: t.currentPlugin?.rootOptions,
      select: node => t.treeNodeActivate(node),
      draggable: true
    };

    const subplugins = {
      id: 'subplugins',
      index: 3,
      buttons: [
        {
          text: bbn._("Plugin"),
          action: () => t.goToBlock(2),
          icon: "nf nf-md-chevron_double_left"
        }, {
          text: bbn._("Options"),
          action: () => t.goToBlock(0),
          icon: "nf nf-md-chevron_triple_left"
        }, {
          text: bbn._("New"),
          icon: "nf nf-md-table_column_plus_after",
          action: () => {
            t.resetNewItem(t.currentPlugin?.rootPlugins);
            bbn.fn.link(t.source.root + 'tree/new_subplugin');
          },
        }
      ],
      source: t.source.root + 'tree',
      root: t.currentPlugin?.rootPlugins,
      select: node => t.treeNodeActivate(node),
      draggable: true
    };

    const pluginTemplates = {
      id: 'pluginTemplates',
      index: 3,
      condition: () => t.templateSelected,
      buttons: [
        {
          text: bbn._("Back to Apps"),
          icon: "nf nf-md-chevron_double_left",
          action: () => t.backFromTemplate()
        }
      ],
      source: t.source.root + 'tree',
      root: t.currentPlugin?.rootTemplates,
      select: node => t.treeNodeActivate(node),
      draggable: true
    };

    const subplugin = {
      id: 'subplugin',
      index: 4,
      buttons: [
        {
          text: bbn._("Subplugins"),
          action: () => t.goToBlock(3)
        }, {
          menu: [{
            text: bbn._("Menu"),
            items: [{
              text: bbn._("New option"),
              url: t.source.root + 'tree/new_app',
              icon: "nf nf-md-table_column_plus_after"
            }, {
              text: bbn._("Back to plugin %s", t.currentPlugin?.code),
              action: () => {
                t.goToBlock(2);
              }
            }, {
              text: bbn._("Back to plugins"),
              action: () => {
                t.goToBlock(1);
              }
            }, {
              text: bbn._("Back to options"),
              action: () => {
                t.goToBlock(0);
              }
            }, {
              text: bbn._("Back to apps"),
              action: () => {
                t.goToBlock(-1);
              }
            }]
          }],
        }, {
          text: bbn._("Options"),
          action: () => t.goToBlock(0)
        }
      ],
      source: t.source.root + 'tree',
      root: t.currentPlugin?.rootOptions,
      select: node => t.treeNodeActivate(node),
      draggable: true
    };

    return [root, apps, options, rootTemplates, plugins, appTemplates, plugin, subplugins, pluginTemplates, subplugin];
  };

  return {
    mixins: [bbn.cp.mixins.basic],
    data() {
      const root = appui.plugins['appui-option'] + '/';
      let currentTab = 'values';
      if (bbn.env.path.indexOf(root + 'tree/option/') === 0) {
        const last = bbn.env.path.split('/').pop();
        if (['values', 'cfg', 'preferences', 'upreferences', 'stats', 'password'].includes(last)) {
          currentTab = last;
        }
      }

      return {
        root,
        roots: this.source.roots.map(a => {
          const b = bbn.fn.extend({}, a);
          b.name = a.text;
          b.text = this.convertNodeText(a);
          b.numChildren = 0;
          return b;
        }),
        currentTab,
        currentIndex: 0,
        option: '{}',
        cfg: '{}',
        newItem: {
          id: null,
          id_parent: null,
          text: null,
          id_alias: null,
          code: null
        },
        newAlias: {
          id_plugin: ''
        },
        optionSelected: this.source.info || {
          id: '',
          text: '',
          code: null,
          showUsage: {
            tree: false,
            occourences: false,
            dataTables: false
          }
        },
        isAdmin: appui.user.isAdmin,
        appuiTree: false,
        dataObj: {
          appuiTree: false,
        },
        treeMenu: getTreeMenu(this),
        routerRoot: appui.plugins['appui-option'] + '/tree/',
        isReady: true,
        templateSelected: false,
        templateObj: {
          id: '',
        },
        changingRoot: false,
        currentPosition: 0,
        currentAppId: this.source.appId,
        currentPluginId: null,
        currentSubpluginId: null,
        currentURL: '',
      }
    },
    computed: {
      blocks() {
        return generateBlocks(this)
      },
      currentApp() {
        if (this.currentAppId) {
          return bbn.fn.getRow(this.source.roots, {id: this.currentAppId});
        }

        return null;
      },
      currentPlugin() {
        if (this.currentApp && this.currentPluginId) {
          return bbn.fn.getRow(this.currentApp.plugins, {id: this.currentPluginId});
        }

        return null;
      },
      rootOptions() {
        if (this.currentApp) {
          return this.currentApp.rootOptions;
        }

        return null
      },
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
      resetNewItem(id_parent, hasAlias) {
        this.newItem.id_parent = id_parent;
        this.newItem.text = hasAlias ? null : '';
        this.newItem.code = hasAlias ? null : '';
        this.newItem.id_alias = null;
      },
      setDefaultTab(route) {
        const bits = route.split('/');
        if (bits.length > 1) {
          this.currentTab = bits[1];
        }
      },
      goToBlock(idx) {
        if ((idx <= 1) && this.currentPluginId) {
          this.currentPluginId = null;
        }

        this.currentPosition = idx ? (-100*idx) + '%' : '0px';
        this.currentIndex = idx;
      },
      onCreate(res) {
        if (res.success && res.data) {
          const block = bbn.fn.getRow(this.blocks, {root: res.data.id_parent});
          if (block) {
            this.getRef('tree' + block.id).updateData();
          }
          else {
            bbn.fn.warning("Block not found", res.data);
          }

          this.treeNodeActivate(res);
        }

        this.resetNewItem(null);
      },
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
      backFromTemplate() {
        if (this.currentIndex === 0) {
          this.goToBlock(-1);
        }
        else if (this.currentPlugin) {
          this.goToBlock(1);
        }
        else {
          this.goToBlock(0);
        }

        this.$nextTick(() => {
          this.templateSelected = false;
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
            appui.error(d);
          }
        })
      },
      convertNodeText(data) {
        let text = data.text;
        if (!data.text && data.alias?.text) {
          text = '<em style="var(--primary-background)">' + data.alias.text;
          if (!data.code && data.alias.code) {
            text += '&nbsp; <span class="bbn-grey"> (' + data.alias.code + ')</span>';
          }

          text += '</em>';
        }
        else if (![undefined, null].includes(data.code)) {
          text += ' &nbsp; <span class="bbn-grey"> (' + data.code + ')</span>';
        }

        return text;
      },
      treeMapper(node) {
        if (node.text.indexOf('(') === -1) {
          node.text = this.convertNodeText(node.data || node);
        }

        return node;
      },
      treeNodeActivate(node) {
        const data = node.data;
        if (data && data.id) {
          this.isReady = false;
          this.$nextTick(() => {
            this.optionSelected = {
              code: data.code,
              text: data.text,
              id: data.id
            };
            this.getRef('router').activateIndex(1);
            this.closest('bbn-container').router.changeURL(this.root + 'tree/option/' + data.id + '/' + this.currentTab, data.name || data.text);
            setTimeout(() => {
              this.isReady = true;
            }, 100);
            bbn.fn.log(['treeNodeActivate', this.root + 'tree/option/' + data.id, this.currentTab])
          });
        }
      },
      changeApp(node) {
        const data = node.data;
        if (data?.id) {
          this.currentAppId = data.id;
          this.$nextTick(() => {
            this.goToBlock(0);
            this.treeNodeActivate(node);
          });
        }
      },
      activatePlugin(node) {
        const data = node.data;
        bbn.fn.log("activatePlugin", data);
        if (data?.id) {
          this.currentPluginId = data.id;
          this.goToBlock(2);
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
      if (this.source.option?.info) {
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

      if (this.source.info?.parentPlugin) {
        this.currentPluginId = this.source.info.parentPlugin;
        setTimeout(() => {
          this.goToBlock(2);
        }, 250);
      }
    },
    watch: {
      currentPluginId() {
        this.changingRoot = 'plugin';
        setTimeout(() => {
          this.changingRoot = false;
        }, 250);
      },
      currentAppId() {
        this.changingRoot = 'options';
        setTimeout(() => {
          this.changingRoot = false;
        }, 250);
      },
      appuiTree(v) {
        bbn.fn.log("appuiTree", v);
        this.dataObj.appuiTree = v;
        this.dataObj.id = '';
        bbn.fn.log(JSON.stringify(this.dataObj));
        this.optionSelected.id = '';
        this.optionSelected.text = '';
        this.optionSelected.code = null;
        this.option = '{}';
        this.cfg = '{}';
        this.$nextTick(() => {
          this.$refs.listOptions.updateData();
        });
      }
    }
  }
})();
