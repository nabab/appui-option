(() => {
  return {
    props: {
      message: {
      }
    },
    methods: {
      onCreate() {
        this.$emit('create');
        const ct = this.closest('bbn-container');
        if (ct) {
          const cp = ct.getComponent();
          if (cp?.popnew) {
            if (cp.currentPlugin) {
              return cp.popnew('template', cp.currentPlugin.rootTemplates);
            }

            if (cp.currentApp) {
              return cp.popnew('template', cp.currentApp.rootTemplates);
            }
          }
        }
      },
      onImport() {
        this.$emit('import');
        bbn.fn.log(this);
      },
    }
  };
})();
