(() => {
  return {
    data(){
      return {
        ready: false,
        result: 0,
        treeData: []
      }
    },
    created(){
      this.post(appui.plugins['appui-options'] + "/data/stats", {id: this.source.option.id}, d => {
        this.treeData = d.tree
        this.result = d.totalReferences
        this.ready = true
      })
    }
  }
})()