(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    data(){
      return {
        loaded: false,
        result: 0,
        treeData: []
      }
    },
    methods: {
      update(){
        this.post(
          appui.plugins['appui-option'] + "/data/stats",
          {id: this.source.option.id},
          d => {
            this.treeData = d.tree;
            this.result = d.totalReferences;
            this.loaded = true;
          }
        );
      }
    },
    mounted(){
      this.loaded = false;
      setTimeout(() => {
        this.update();
      }, 500)
    }
  }
})()