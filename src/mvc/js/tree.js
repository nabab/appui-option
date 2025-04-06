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
        blocks: null
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

  return {
    mixins: [bbn.cp.mixins.basic],
    data() {
      const root = appui.plugins['appui-option'] + '/';
      let currentTab = 'values';
      let routerURL = 'home';
      if (bbn.env.path.indexOf(root + 'tree/') === 0) {
        let tmp = bbn.env.path.substr(root.length + 5);
        tmp = tmp.split('/');
        if (tmp.length) {
          routerURL = tmp.shift();
          if (tmp.length) {
            const last = tmp.pop();
            if (['values', 'cfg', 'preferences', 'stats', 'password'].includes(last)) {
              currentTab = last;
            }
          }
        }
      }

      return {
        root,
        blocks: null,
        currentTab,
        currentIndex: 0,
        currentNode: null,
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
        routerRoot: root + 'tree/',
        isReady: true,
        readyTimeout: null,
        templateSelected: false,
        templateObj: {
          id: '',
        },
        changingRoot: false,
        currentPosition: 0,
        currentAppId: this.source.appId,
        currentPluginId: null,
        currentSubpluginId: null,
        routerURL,
        debug: JSON.stringify(this.source)
      }
    },
    computed: {
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
      genBlockRoot() {
        return {
          id: 'root',
          label: bbn._("Root tree"),
          index: -2,
          condition: () => this.isAdmin,
          buttons: [
            {
              menu: [{
                text: bbn._("Menu"),
                items: [{
                  text: bbn._("Delete cache"),
                  action: () => {
                    this.deleteCache();
                  }
                }, {
                  text: bbn._("Refresh tree"),
                  action: () => {
                    this.getRef('treeroot').updateData();
                  }
                }]
              }],
            }, {
              text: bbn._("Back to Apps"),
              icon: "nf nf-md-chevron_double_right",
              iconPosition: 'right',
              action: () => this.goToBlock(-1)
            }
          ],
          source: this.source.root + "tree",
          root: this.source.absoluteRoot,
          select: node => this.changeOption(node),
          draggable: true
        };
      },
      genBlockApps() {
        return {
          id: 'apps',
          label: bbn._("Applications"),
          index: -1,
          condition: () => this.isAdmin,
          buttons: [
            {
              text: bbn._("Full tree"),
              icon: "nf nf-md-chevron_double_left",
              action: () => this.goToBlock(-2)
            }, {
              menu: [{
                text: bbn._("Menu"),
                items: [{
                  text: bbn._("Root templates"),
                  action: () => {
                    this.templateSelected = true;
                    this.goToBlock(0);
                  }
                }, {
                  text: bbn._("New app"),
                  action: () => this.popnew('app', this.source.absoluteRoot),
                  icon: "nf nf-md-package_variant_plus"
                }, {
                  text: bbn._("Delete cache"),
                  action: () => this.deleteCache()
                }]
              }],
            }, {
              text: bbn._("Options"),
              action: () => this.goToBlock(0)
            }
          ],
          source: this.source.roots.map(a => {
            const b = bbn.fn.extend({}, a);
            b.name = a.text;
            b.text = this.convertNodeText(a);
            b.numChildren = 0;
            return b;
          }),
          root: this.source.absoluteRoot,
          select: node => this.changeApp(node),
          draggable: false
        };
      },
      genBlockOptions() {
        return {
          id: 'options',
          label: bbn._("Options for %s", this.currentApp?.text),
          index: 0,
          condition: () => !this.templateSelected,
          buttons: [
            {
              text: bbn._("Apps"),
              icon: "nf nf-md-chevron_double_left",
              action: () => this.goToBlock(-1)
            }, {
              menu: [{
                text: bbn._("Menu"),
                items: [{
                  text: bbn._("New category"),
                  action: () => {
                    this.popnew('option', this.currentApp?.rootOptions);
                  }
                }, {
                  text: bbn._("New category as link"),
                  action: () => {
                    this.popnew('alias', this.currentApp?.rootOptions);
                  }
                }, {
                  text: bbn._("Templates"),
                  action: () => {
                    this.templateSelected = true;
                    this.goToBlock(1);
                  }
                }, {
                  text: bbn._("Delete cache"),
                  action: () => {
                    this.deleteCache();
                  }
                }, {
                  text: bbn._("Refresh tree"),
                  action: () => {
                    this.getRef('treeoptions').updateData();
                  }
                }]
              }],
            }, {
              text: bbn._("Plugins"),
              action: () => this.goToBlock(1),
              iconPosition: 'right',
              icon: "nf nf-md-chevron_double_right",
            }
          ],
          noData: 'appui-option-nodata-options',
          source: this.source.root + 'tree',
          root: this.currentApp?.rootOptions,
          select: node => this.changeOption(node),
          draggable: true
        };
      },
      genBlockTemplates() {
        return {
          id: 'rootTemplates',
          label: bbn._("Root templates"),
          index: 0,
          condition: () => this.templateSelected,
          buttons: [
            {
              text: bbn._("Apps"),
              icon: "nf nf-md-chevron_double_left",
              action: () => this.backFromTemplate()
            }, {
              menu: [{
                text: bbn._("Menu"),
                items: [{
                  text: bbn._("Delete cache"),
                  action: () => {
                    this.deleteCache();
                  }
                }, {
                  text: bbn._("Refresh tree"),
                  action: () => {
                    this.getRef('treeroot').updateData();
                  }
                }]
              }],
            }, {
              text: bbn._("New"),
              icon: "nf nf-md-receipt_text_plus_outline",
              action: () => {
                this.popnew('template', this.source.rootTemplates);
              },
            }
          ],
          noData: 'appui-option-nodata-templates',
          source: this.source.root + 'tree',
          root: this.source.rootTemplates,
          select: node => this.changeTemplate(node),
          draggable: true
        };
      },
      genBlockPlugins() {
        return {
          id: 'plugins',
          label: bbn._("Plugins"),
          index: 1,
          buttons: [
            {
              text: bbn._("Options"),
              action: () => this.goToBlock(0),
              icon: "nf nf-md-chevron_double_left"
            }, {
              menu: [{
                text: bbn._("Menu"),
                items: [{
                  text: bbn._("New Plugin"),
                  icon: "nf nf-md-puzzle_plus",
                  action: () => {
                    this.popnew('plugin', this.currentApp?.rootPlugins);
                  }
                }, {
                  text: bbn._("New Plugin alias"),
                  icon: "nf nf-md-puzzle_plus",
                  action: () => {
                    this.popnew('alias', this.currentApp?.rootPlugins);
                  }
                }, {
                  text: bbn._("Delete cache"),
                  action: () => {
                    this.deleteCache();
                  }
                }, {
                  text: bbn._("Refresh tree"),
                  action: () => {
                    this.getRef('treeplugins').updateData();
                  }
                }]
              }],
            }
          ],
          noData: 'appui-option-nodata-plugins',
          source: this.currentApp?.plugins,
          select: node => this.changePlugin(node),
          draggable: false
        };
      },
      genBlockAppTemplates() {
        return {
          id: 'appTemplates',
          label: bbn._("Templates"),
          index: 1,
          condition: () => this.templateSelected,
          buttons: [
            {
              text: bbn._("Options"),
              icon: "nf nf-md-chevron_double_left",
              action: () => this.backFromTemplate()
            }, {
              menu: [{
                text: bbn._("Menu"),
                items: [{
                  text: bbn._("Delete cache"),
                  action: () => {
                    this.deleteCache();
                  }
                }, {
                  text: bbn._("Refresh tree"),
                  action: () => {
                    this.getRef('treeappTemplates').updateData();
                  }
                }]
              }],
            }, {
              text: bbn._("New"),
              icon: "nf nf-md-receipt_text_plus_outline",
              action: () => {
                this.popnew('template', this.currentApp?.rootTemplates);
              },
            }
          ],
          noData: 'appui-option-nodata-templates',
          source: this.source.root + 'tree',
          root: this.currentApp?.rootTemplates,
          select: node => this.changeTemplate(node),
          draggable: true
        };
      },
      genBlockPlugin() {
        return {
          id: 'plugin',
          label: bbn._("Plugin %s", this.currentPlugin?.text || ''),
          index: 2,
          buttons: [
            {
              text: bbn._("Plugins"),
              action: () => this.goToBlock(1),
              icon: "nf nf-md-chevron_double_left"
            }, {
              menu: [{
                text: bbn._("Menu"),
                items: [{
                  text: bbn._("Plugin templates"),
                  action: () => {
                    this.templateSelected = true;
                    this.goToBlock(3);
                  }
                }, {
                  text: bbn._("New option"),
                  icon: "nf nf-md-table_column_plus_after",
                  action: () => {
                    this.popnew('option', this.currentPlugin?.rootOptions);
                  },
                }, {
                  text: bbn._("Delete cache"),
                  action: () => {
                    this.deleteCache();
                  }
                }, {
                  text: bbn._("Refresh tree"),
                  action: () => {
                    this.getRef('treeplugin').updateData();
                  }
                }]
              }],
            }, {
              text: bbn._("Subplugins"),
              action: () => this.goToBlock(3),
              iconPosition: 'right',
              icon: "nf nf-md-chevron_double_right"
            }
          ],
          noData: 'appui-option-nodata-option',
          source: this.source.root + 'tree',
          root: this.currentPlugin?.rootOptions,
          select: node => this.changeOption(node),
          draggable: true
        };
      },
      genBlockSubplugins() {
        return {
          id: 'subplugins',
          label: bbn._("Subplugins for %s", this.currentPlugin?.text),
          index: 3,
          buttons: [
            {
              text: bbn._("Plugin"),
              action: () => this.goToBlock(2),
              icon: "nf nf-md-chevron_double_left"
            }, {
              menu: [{
                text: bbn._("Menu"),
                items: [{
                  text: bbn._("Back to options"),
                  action: () => this.goToBlock(0),
                  icon: "nf nf-md-chevron_triple_left"
                }, {
                  text: bbn._("Delete cache"),
                  action: () => {
                    this.deleteCache();
                  }
                }, {
                  text: bbn._("Refresh tree"),
                  action: () => {
                    this.getRef('treesubplugins').updateData();
                  }
                }]
              }],
            }, {
              text: bbn._("New"),
              icon: "nf nf-md-table_column_plus_after",
              action: () => {
                this.popnew('subplugin', this.currentPlugin?.rootPlugins);
              },
            }
          ],
          noData: 'appui-option-nodata-plugins',
          source: this.source.root + 'tree',
          root: this.currentPlugin?.rootPlugins,
          select: node => this.changeOption(node),
          draggable: true
        };
      },
      genBlockPluginTemplates() {
        return {
          id: 'pluginTemplates',
          label: bbn._("Templates for plugin %s", this.currentPlugin?.text),
          index: 3,
          condition: () => this.templateSelected,
          buttons: [
            {
              text: bbn._("Back to Plugin"),
              icon: "nf nf-md-chevron_double_left",
              action: () => this.backFromTemplate()
            }, {
              menu: [{
                text: bbn._("Menu"),
                items: [{
                  text: bbn._("Delete cache"),
                  action: () => {
                    this.deleteCache();
                  }
                }, {
                  text: bbn._("Refresh tree"),
                  action: () => {
                    this.getRef('treesubplugins').updateData();
                  }
                }]
              }],
            }, {
              text: bbn._("New"),
              icon: "nf nf-md-receipt_text_plus_outline",
              action: () => {
                this.popnew('template', this.currentPlugin?.rootTemplates);
              },
            }
          ],
          noData: 'appui-option-nodata-templates',
          source: this.source.root + 'tree',
          root: this.currentPlugin?.rootTemplates,
          select: node => this.changeTemplate(node),
          draggable: true
        };
      },
      genBlockSubplugin() {
        return {
          id: 'subplugin',
          label: bbn._("Subplugin %s for plugin %s", this.currentSubplugin?.text, this.currentPlugin?.text),
          index: 4,
          buttons: [
            {
              text: bbn._("Subplugins"),
              action: () => this.goToBlock(3)
            }, {
              menu: [{
                text: bbn._("Menu"),
                items: [{
                  text: bbn._("New option"),
                  action: () => {
                    this.popnew('option', this.currentApp?.rootOptions);
                  },
                  icon: "nf nf-md-table_column_plus_after"
                }, {
                  text: bbn._("Back to plugin %s", this.currentPlugin?.code),
                  action: () => {
                    this.goToBlock(2);
                  }
                }, {
                  text: bbn._("Back to plugins"),
                  action: () => {
                    this.goToBlock(1);
                  }
                }, {
                  text: bbn._("Back to options"),
                  action: () => {
                    this.goToBlock(0);
                  }
                }, {
                  text: bbn._("Back to apps"),
                  action: () => {
                    this.goToBlock(-1);
                  }
                }, {
                  text: bbn._("Delete cache"),
                  action: () => {
                    this.deleteCache();
                  }
                }, {
                  text: bbn._("Refresh tree"),
                  action: () => {
                    this.getRef('treesubplugin').updateData();
                  }
                }]
              }],
            }, {
              text: bbn._("Options"),
              action: () => this.goToBlock(0)
            }
          ],
          noData: 'appui-option-nodata-option',
          source: this.source.root + 'tree',
          root: this.currentPlugin?.rootOptions,
          select: node => this.changeSubplugin(node),
          draggable: true
        };
      },
      getBlocks() {
        return [
          this.genBlockRoot(), // 0
          this.genBlockApps(), // 1
          this.genBlockOptions(), // 2
          this.genBlockTemplates(), // 3
          this.genBlockPlugins(), // 4
          this.genBlockAppTemplates(), // 5
          this.genBlockPlugin(), // 6
          this.genBlockSubplugins(), // 7
          this.genBlockPluginTemplates(), // 8
          this.genBlockSubplugin() // 9
        ]
      },
      getTreeMenu(node) {
        const tree = this;
        const arr = [{
          text: bbn._('Delete'),
          icon: 'nf nf-fa-times',
          action: node => tree.removeOpt(node)
        }, {
          text: bbn._('Delete fully (with history)'),
          icon: 'nf nf-fa-times',
          action: node => tree.removeOptHistory(node)
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
        if (node.template) {
          arr.push({
            text: bbn._('Apply template'),
            icon: 'nf nf-cod-notebook_template',
            action: node => tree.applyTemplate(node)
          })
        }

        return arr;
      },
      popnew(type, id_parent) {
        const source = {
          id_parent,
          text: null,
          code: null,
          id_alias: null
        };
        if (type === 'plugin') {
          source.prefix = null;
        }

        this.getPopup({
          label: false,
          component: 'appui-option-new-' + type,
          componentEvents: {
            create: res => this.onCreate(res)
          },
          closable: false,
          source
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
      async onDelete(data) {
        bbn.fn.log("ON DELETE", arguments);
        if (this.currentNode?.isConnected && this.currentNode.parent) {
          const idx = this.currentNode.idx;
          const parent = this.currentNode.parent;
          await parent.reload();
          this.$nextTick(() => {
            let node = parent.getNodeByIdx(idx);
            if (node) {
              node.select();
            }
            else {
              parent.node.select();
            }
          })
        }

        appui.success(bbn._('Deleted'));
        this.updateTrees(data, true);
        //bbn.fn.link(this.currentUrl);
      },
      applyTemplate(node) {
        bbn.fn.log("APPLY TPL", node);
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
          this.goToBlock(2);
        }
        else {
          this.goToBlock(0);
        }

        this.$nextTick(() => {
          this.templateSelected = false;
        })
      },
      removeOpt(node) {
        this.confirm(bbn._('Are you sure you want to delete this option?'), ()=>{
          this.post(this.root + 'actions/remove', node.data, d => {
              if (d.success) {
                this.onDelete(node.data)
              }
            }
          )
        })
      },
      removeOptHistory(node) {
        this.confirm(bbn._('Are you sure you want to delete this option\'s history?'), () => {
          this.post(this.root + 'actions/remove',
            bbn.fn.extend({}, node.data, {history : true}),
            d => {
              if ( d.success ) {
                this.onDelete(node.data)
              }
            }
          )
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
      launchReady(url, title) {
        if (this.readyTimeout) {
          clearTimeout(this.readyTimeout);
        }

        this.readyTimeout = setTimeout(() => {
          this.isReady = true;
          this.$nextTick(() => {
            bbn.fn.log("URL ON NEXT TICJ", url);
            this.closest('bbn-container').router.changeURL(this.root + 'tree/' + url, title);
          })
        }, 250);

      },
      changeOption(node) {
        this.currentNode = node;
        const data = node.data;
        if (data && data.id) {
          this.isReady = false;
          this.routerURL = 'option';
          this.$nextTick(() => {
            this.optionSelected = {
              code: data.code,
              text: data.text,
              id: data.id
            };
            this.launchReady('option/' + data.id + '/' + this.currentTab, data.name || data.text);
            bbn.fn.log(['changeOption', this.root + 'tree/option/' + data.id, this.currentTab])
          });
        }
      },
      changeApp(node) {
        this.currentNode = node;
        const data = node.data;
        if (data?.id) {
          this.isReady = false;
          this.currentAppId = data.id;
          this.routerURL = 'app';
          this.$nextTick(() => {
            this.blocks.splice(2, 8, 
              this.genBlockOptions(),
              this.genBlockTemplates(),
              this.genBlockPlugins(),
              this.genBlockAppTemplates(), 
              this.genBlockPlugin(),
              this.genBlockSubplugins(),
              this.genBlockPluginTemplates(),
              this.genBlockSubplugin()
            );
            this.goToBlock(0);
            this.optionSelected = {
              code: data.code,
              text: data.text,
              id: data.id
            };
            this.launchReady('app/' + data.id, data.name || data.text);
          });
        }
      },
      changeTemplate(node) {
        this.currentNode = node;
        const data = node.data;
        if (data?.id) {
          this.isReady = false;
          this.routerURL = 'template';
          this.$nextTick(() => {
            this.optionSelected = {
              code: data.code,
              text: data.text,
              id: data.id
            };
            this.launchReady('template/' + data.id + '/values', data.name || data.text);
          });
        }
      },
      changePlugin(node) {
        this.currentNode = node;
        const data = node.data;
        if (data?.id) {
          this.isReady = false;
          this.currentPluginId = data.id;
          this.routerURL = 'plugin/' + data.id;
          this.$nextTick(() => {
            this.blocks.splice(6, 4,
              this.genBlockPlugin(),
              this.genBlockSubplugins(),
              this.genBlockPluginTemplates(),
              this.genBlockSubplugin(),
            );
            this.goToBlock(2);
            this.optionSelected = {
              code: data.code,
              text: data.text,
              id: data.id
            };
            bbn.fn.log("DATA", data)
            this.launchReady('plugin/' + data.id, data.name || data.text);
          });
        }
      },
      changeSubplugin(node) {
        this.currentNode = node;
        const data = node.data;
        if (data?.id) {
          this.isReady = false;
          this.currentSubpluginId = data.id;
          this.routerURL = 'subplugin';

          this.$nextTick(() => {
            this.blocks.splice(9, 1,
              this.genBlockSubplugin()
            );
            this.goToBlock(5);
            this.optionSelected = {
              code: data.code,
              text: data.text,
              id: data.id
            };

            this.launchReady('subplugin/' + data.id, data.name || data.text);
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
      },

    },
    created() {
      this.blocks = this.getBlocks();
    },
    beforeMount() {
      if (this.source.info?.option) {
        let opt = this.source.info.option;
        this.cfg = this.source.info.cfg;
        this.option = opt;
        this.optionSelected.id = opt.id;
        this.optionSelected.code = opt.code;
        this.optionSelected.text = opt.text;
      }
      else {
        const ct = this.closest('bbn-container');
        if (ct.currentCurrent !== ct.currentURL) {
          bbn.fn.warning("CURRENT AND URL ARE DIFFERENT: " + ct.currentCurrent + ' - ' + ct.currentURL)
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
      optionSelected(v) {
        if (appui.user.isAdmin) {
          this.debug = JSON.stringify(v, null, 2);
        }
      },
      currentPluginId(v) {
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
