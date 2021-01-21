(() => {
  return {
    data(){
      return {
        optionObj: {
          row: this.source.info ? JSON.parse(this.source.info) : {},
        },
        cfgObj: {
          cfg: this.source.cfg ? JSON.parse(this.source.cfg) : {}
        }
      }
    },
    computed: {
      tree(){
        return this.closest('bbn-container').getComponent()
      }
    },
    methods: {
      linkOption(){
        if (this.optionObj.row.id) {
          bbn.fn.link(appui.plugins['appui-option'] + "/list/" + this.optionObj.row.id);
        }
      }
    }
  };
})();