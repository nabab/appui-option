// Javascript Document
(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    data(){
      return {
        selected: false,
        root: appui.plugins['appui-option'] + '/permissions/',
        mode: 'access',
        sections:{
          configuration: true,
          newPermission: false,
          groups: false,
          users: false
        },
        modes: [
          {
            text: bbn._("Access"),
            value: 'access'
          }, {
            text: bbn._("Options"),
            value: 'options'
          }
        ],
        currentSource: this.source.rootAccess,
        currentSection: 0,
        currentPlugin: this.source.sources[0],
        panelSource: []
      }
    },
    computed: {
      idParent(){
        return this.selected.id || null;
      },
    },
    methods: {
      delPerm(){
        if ( this.selected.id ){
          this.confirm(bbn._('Are you sure you want to delete this permission?'), ()  => {
            this.post(
              this.root + 'actions/delete',
              {id: this.selected.id},
              d => {
                if ( d && d.success ){
                  appui.success(bbn._('Deleted!'));
                  this.selected = {};
                  this.getRef('tree').selectedNode.parent.updateData();
                  /** @todo to remove it from the permissions list (tree) and to select its parent */
                }
              }
            );
          });
        }
      },
      changeSection(idx) {
        this.currentSection = idx
      },
      enter(element) {
        const width = getComputedStyle(element).width;

        element.style.width = width;
        element.style.position = 'absolute';
        element.style.visibility = 'hidden';
        element.style.height = 'auto';

        const height = getComputedStyle(element).height;

        element.style.width = null;
        element.style.position = null;
        element.style.visibility = null;
        element.style.height = 0;

        // Force repaint to make sure the
        // animation is triggered correctly.
        getComputedStyle(element).height;

        // Trigger the animation.
        // We use `requestAnimationFrame` because we need
        // to make sure the browser has finished
        // painting after setting the `height`
        // to `0` in the line above.
        requestAnimationFrame(() => {
          element.style.height = height;
        });
      },
      afterEnter(element) {
        element.style.height = 'auto';
      },
      leave(element) {
        const height = getComputedStyle(element).height;

        element.style.height = height;

        // Force repaint to make sure the
        // animation is triggered correctly.
        getComputedStyle(element).height;

        requestAnimationFrame(() => {
          element.style.height = 0;
        });
      },
      refresh(){
        let cp = this;
        this.getPopup({
          label: bbn._("Choose plugins to refresh"),
          width: 400,
          component: 'appui-core-form-plugins',
          componentOptions: {
            source: {
              plugins: bbn.fn.filter(this.source.sources, a => {
                return !a.code || appui.plugins[a.code];
              }).map(a => {
                return {value: a.rootAccess, text: a.text}
              }),
              action: this.root + 'actions/scan'
            },
            confirmMessage: bbn._("Are you sure you want to update the chosen permissions?") +
            								"<br>" + bbn._("Depending on the size of your app it might take a while"),
            success(d) {
              if (d && d.res && d.res.total) {
                appui.info(d.res.total + ' ' + bbn._("permissions have been added"));
                cp.getRef('tree').updateData();
              }
              else if (d && d.res) {
                appui.info(bbn._("No permission has been added"));
              }
              else {
                appui.error(d);
              }
		        }
          }
        })
      },
      cleanUp(){
        let cp = this;
        this.getPopup({
          label: bbn._("Choose plugins to refresh"),
          width: 400,
          component: 'appui-core-form-plugins',
          componentOptions: {
            source: {
              plugins: this.source.sources.map(a => {
                return {value: a.rootAccess, text: a.text}
              }),
              action: this.root + 'actions/cleanup'
            },
            confirmMessage: bbn._("Are you sure you want to clean up the permissions?") +
            								"<br>" + bbn._("It will delete only obsoletes ones which don't correspond to any file and have no user option defined.") +
            								"<br>" + bbn._("Depending on the size of your app it might take a while"),
            success(d) {
              if (d && d.success) {
                let msg = d.total ?
                    d.total + ' ' + bbn._("permissions have been removed") :
                bbn._("All good but no need to delete anything");
                appui.success(msg);
                cp.getRef('tree').updateData();
              }
              else {
                appui.error(d);
              }
		        }
          }
        })
      },
      treeMapper(n){
        let addedCls = ''
        if (!n.text && n.data?.alias) {
          n.text = n.data.alias.text + ' <span class="bbn-permissions-list-code bbn-blue">' + n.data.alias.code + '</span>';
        }
        else {
          n.text += ' <span class="bbn-permissions-list-code">' + n.data?.code + '</span>';
        }

        return n;
      },
      permissionSelect(n){
        this.post(this.root + 'actions/get', {
          id: n.data.id,
          full: 1
        }, (d) => {
          this.selected = d.data || false;
          //bbn.fn.extend(r, d.data);
        });
      },
      openSection(section){
        bbn.fn.each(this.sections, (s, i) => {
           this.sections[i] = i === section
        });
      },
      setPanelSource(selected){
        if (selected) {
          this.panelSource =  [
            {
              header: '<span class="bbn-lg bbn-b">' + bbn._("Configuration") + '</span>',
              component: 'appui-option-permissions-configuration',
              componentOptions: {
                source: selected,
                parent: this
            	}
            }, {
              header: '<span class="bbn-lg bbn-b">' + bbn._("Groups") + '</span>',
              component: 'appui-option-permissions-groups',
              componentOptions: {
                users: this.source.users,
                groups: this.source.groups,
                source: selected,
                parent: this
              }
            }, {
              header: '<span class="bbn-lg bbn-b">' + bbn._("Users") + '</span>',
              component: 'appui-option-permissions-users',
              componentOptions: {
                users: this.source.users,
                groups: this.source.groups,
                source: selected,
                parent: this
              }
            }, {
              header: '<span class="bbn-lg bbn-b">' + bbn._("New permission (under this one)") + '</span>',
              component: 'appui-option-permissions-new',
              componentOptions: {
                source: {
                  selected: selected
                },
                parent: this
              }
            }
          ];
        }
        else {
          this.panelSource = [];
        }
      }
    },
    mounted(){
      if (this.selected && !this.panelSource.length) {
        this.setPanelSource(this.selected);
      }
    },
    watch: {
      currentSource(v) {
        const prop = this.mode === 'options' ? 'rootOptions' : 'rootAccess';
        const idx = bbn.fn.search(this.source.sources, {[prop]: v});
        this.currentPlugin = this.source.sources[idx];
        this.$nextTick(() => {
          this.getRef('tree').updateData()
        })
      },
      mode(v) {
        const prop = v === 'options' ? 'rootOptions' : 'rootAccess';
        this.currentSource = this.currentPlugin[prop];
      },
      selected(v, o){
        if (v && (!o || (v.id !== o.id))) {
          this.setPanelSource(v);
        }
      }
    }
  };
})();