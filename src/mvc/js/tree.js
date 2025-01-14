// Javascript Document
(() => {
  bbn.cp.mixins['appui-option-tree'] = {
    props: {
      source: {
        type: Object,
        required: true,
        validation: a => {
          return !!a?.id_parent;
        }
      }
    },
    data() {
      return {
        root: appui.plugins['appui-option'] + '/',
        isCodeManual: false,
        isAdmin: appui.user.isAdmin,
      }
    },
    computed: {
      generatedCode() {
        return this.source.text ? bbn.fn.sanitize(this.source.text, '-').toLowerCase() : '';
      },
      currentText() {
        const d = this.data?.option || this.source;
        return d.text || d.alias?.text ||'';
      },
      currentCode() {
        const d = this.data?.option || this.source;
        return d.code || d.alias?.code || '';
      },
      currentIcon() {
        const d = this.data?.option || this.source;
        return d.icon || d.alias?.icon || '';
      },
      currentValue() {
        const d = this.data?.option || this.source;
        const res = bbn.fn.createObject();
        for (let n in d) {
          if (!['text', 'code', 'id', 'id_parent', 'id_alias', 'cfg', 'value'].includes(n)) {
            res[n] = d[n];
          }
        }

        return res;
      }
    },
    methods: {
      onCreate(res) {
        this.$emit('create', res);
      }
    },
    watch: {
      "source.text"(v) {
        if (!this.isCodeManual) {
          this.source.code = this.generatedCode;
        }
      },
      "source.code"(v) {
        if (!this.isCodeManual && (v !== this.generatedCode)) {
          this.isCodeManual = true;
        }
      }
    }
  };

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
      label: bbn._("Root tree"),
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
      select: node => t.changeOption(node),
      draggable: true
    };

    const apps = {
      id: 'apps',
      label: bbn._("Applications"),
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
                t.popnew('app', t.source.absoluteRoot);
              },
              icon: "nf nf-md-package_variant_plus"
            }]
          }],
        }, {
          text: bbn._("Options"),
          action: () => t.goToBlock(0)
        }
      ],
      source: t.source.roots.map(a => {
        const b = bbn.fn.extend({}, a);
        b.name = a.text;
        b.text = t.convertNodeText(a);
        b.numChildren = 0;
        return b;
      }),
      root: t.source.absoluteRoot,
      select: node => t.changeApp(node),
      draggable: false
    };

    const options = {
      id: 'options',
      label: bbn._("Options for %s", t.currentApp?.text),
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
                t.popnew('option', t.currentApp?.rootOptions);
              }
            }, {
              text: bbn._("New category as link"),
              action: () => {
                t.popnew('alias', t.currentApp?.rootOptions);
              }
            }, {
              text: bbn._("Templates"),
              action: () => {
                t.templateSelected = true;
                t.goToBlock(1);
              }
            }, {
              text: bbn._("Delete cache"),
              action: () => {
                t.deleteCache();
              }
            }, {
              text: bbn._("Refresh tree"),
              action: () => {
                t.getRef('treeoptions').updateData();
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
      select: node => t.changeOption(node),
      draggable: true
    };

    const rootTemplates = {
      id: 'rootTemplates',
      label: bbn._("Root templates"),
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
            t.popnew('template', t.source.rootTemplates);
          },
        }
      ],
      source: t.source.root + 'tree',
      root: t.source.rootTemplates,
      select: node => t.changeTemplate(node),
      draggable: true
    };

    const plugins = {
      id: 'plugins',
      label: bbn._("Plugins"),
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
                t.popnew('plugin', t.currentApp?.rootPlugins);
              }
            }, {
              text: bbn._("New Plugin alias"),
              icon: "nf nf-md-puzzle_plus",
              action: () => {
                t.popnew('alias', t.currentApp?.rootPlugins);
              }
            }]
          }],
        }
      ],
      source: t.currentApp?.plugins,
      select: node => t.changePlugin(node),
      draggable: false
    };

    const appTemplates = {
      id: 'appTemplates',
      label: bbn._("Templates"),
      index: 1,
      condition: () => t.templateSelected,
      buttons: [
        {
          text: bbn._("Back to Options"),
          icon: "nf nf-md-chevron_double_left",
          action: () => t.backFromTemplate()
        }, {
          text: bbn._("New template"),
          icon: "nf nf-md-receipt_text_plus_outline",
          action: () => {
            t.popnew('template', t.currentApp?.rootTemplates);
          },
        }
      ],
      source: t.source.root + 'tree',
      root: t.currentApp?.rootTemplates,
      select: node => t.changeTemplate(node),
      draggable: true
    };

    const plugin = {
      id: 'plugin',
      label: bbn._("Plugin %s", t.currentPlugin?.text),
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
                t.popnew('option', t.currentPlugin?.rootOptions);
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
      select: node => t.changeOption(node),
      draggable: true
    };

    const subplugins = {
      id: 'subplugins',
      label: bbn._("Subplugins for %s", t.currentPlugin?.text),
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
            t.popnew('subplugin', t.currentPlugin?.rootPlugins);
          },
        }
      ],
      source: t.source.root + 'tree',
      root: t.currentPlugin?.rootPlugins,
      select: node => t.changeOption(node),
      draggable: true
    };

    const pluginTemplates = {
      id: 'pluginTemplates',
      label: bbn._("Templates for plugin %s", t.currentPlugin?.text),
      index: 3,
      condition: () => t.templateSelected,
      buttons: [
        {
          text: bbn._("Back to Plugin"),
          icon: "nf nf-md-chevron_double_left",
          action: () => t.backFromTemplate()
        }, {
          text: bbn._("New template"),
          icon: "nf nf-md-receipt_text_plus_outline",
          action: () => {
            t.popnew('template', t.currentPlugin?.rootTemplates);
          },
        }
      ],
      source: t.source.root + 'tree',
      root: t.currentPlugin?.rootTemplates,
      select: node => t.changeTemplate(node),
      draggable: true
    };

    const subplugin = {
      id: 'subplugin',
      label: bbn._("Subplugin %s for plugin %s", t.currentSubplugin?.text, t.currentPlugin?.text),
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
              action: () => {
                t.popnew('option', t.currentApp?.rootOptions);
              },
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
      select: node => t.changeSubplugin(node),
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
        if (['values', 'cfg', 'preferences', 'stats', 'password'].includes(last)) {
          currentTab = last;
        }
      }

      return {
        root,
        currentTab,
        currentIndex: 0,
        option: '{}',
        cfg: '{}',
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
      popnew(type, id_parent) {
        this.getPopup({
          label: false,
          component: 'appui-option-new-' + type,
          componentEvents: {
            create: res => this.onCreate(res)
          },
          closable: false,
          source: {
            id_parent,
            text: null,
            code: null,
            id_alias: null
          }
        })
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
        if ((idx <= 3) && this.currentSubpluginId) {
          this.currentSubpluginId = null;
        }

        this.currentPosition = idx ? (-100*idx) + '%' : '0px';
        this.currentIndex = idx;
      },
      updateTrees(data, del) {
        const blocks = bbn.fn.filter(this.blocks, {root: data.id_parent});
        if (blocks.length) {
          bbn.fn.each(blocks, block => {
            if (bbn.fn.isArray(block.source)) {
              let src;
              if (data.id_parent === this.source.absoluteRoot) {
                src = this.source.roots;
              }
              else {
                src = block.source;
              }

              if (del) {
                let idx = bbn.fn.search(src, a => a.id === data.id);
                if (idx > -1) {
                  src.splice(idx, 1);
                }
                else {
                  throw new Error("Option not found");
                }
              }
              else {
                src.push(data);
              }
            }

            const tree = this.getRef('tree' + block.id);
            tree.updateData();
          });
        }
        else {
          bbn.fn.warning("Block not found", res.data);
        }
      },
      onCreate(res) {
        bbn.fn.log("ON CREATE", res)
        if (res.success && res.data) {
          this.updateTrees(res.data);
          this.changeOption(res);
        }
      },
      onDeleteApp(opt) {
        this.goToBlock(-1);
      },
      onDeletePlugin(opt) {
        this.goToBlock(1);
      },
      onDeleteSubplugin(opt) {
        this.goToBlock(3);
      },
      onDelete(opt) {
        this.updateTrees(opt, true);
        bbn.fn.link(this.root + 'tree/home');
      },
      importOption(node) {
        this.closest('bbn-container').getPopup({
          label: 'Import into option ' + node.data.text,
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
              label: 'Export option ' + node.data.text + (node.data.code ? ' (' + node.data.code + ')' : ''),
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
      deleteCache() {
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
        const data = node.data || node;
        if (!data.text && data.alias) {
          if (!data.num_children && data.alias.num_children) {
            data.num_children = data.alias.num_children;
            node.numChildren = data.num_children;
          }
        }

        return node;
      },
      changeOption(node) {
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
            bbn.fn.log(['changeOption', this.root + 'tree/option/' + data.id, this.currentTab])
          });
        }
      },
      changeApp(node) {
        const data = node.data;
        if (data?.id) {
          this.isReady = false;
          this.currentAppId = data.id;
          this.$nextTick(() => {
            this.goToBlock(0);
            this.optionSelected = {
              code: data.code,
              text: data.text,
              id: data.id
            };
            this.getRef('router').activateIndex(2);
            this.closest('bbn-container').router.changeURL(this.root + 'tree/app/' + data.id, data.name || data.text);
            setTimeout(() => {
              this.isReady = true;
            }, 100);
          });
        }
      },
      changeTemplate(node) {
        const data = node.data;
        if (data?.id) {
          this.isReady = false;
          this.$nextTick(() => {
            this.optionSelected = {
              code: data.code,
              text: data.text,
              id: data.id
            };
            this.getRef('router').activateIndex(3);
            this.closest('bbn-container').router.changeURL(this.root + 'tree/template/' + data.id + '/values', data.name || data.text);
            setTimeout(() => {
              this.isReady = true;
            }, 100);
          });
        }
      },
      changePlugin(node) {
        const data = node.data;
        if (data?.id) {
          this.isReady = false;
          this.currentPluginId = data.id;
          this.$nextTick(() => {
            this.goToBlock(2);
            this.optionSelected = {
              code: data.code,
              text: data.text,
              id: data.id
            };
            this.getRef('router').activateIndex(4);
            this.closest('bbn-container').router.changeURL(this.root + 'tree/plugin/' + data.id, data.name || data.text);
            setTimeout(() => {
              this.isReady = true;
            }, 100);
          });
        }
      },
      changeSubplugin(node) {
        const data = node.data;
        if (data?.id) {
          this.isReady = false;
          this.currentSubpluginId = data.id;
          this.$nextTick(() => {
            this.goToBlock(5);
            this.optionSelected = {
              code: data.code,
              text: data.text,
              id: data.id
            };
            this.getRef('router').activateIndex(5);
            this.closest('bbn-container').router.changeURL(this.root + 'tree/subplugin/' + data.id, data.name || data.text);
            setTimeout(() => {
              this.isReady = true;
            }, 100);
          });
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
    }
  }
})();
