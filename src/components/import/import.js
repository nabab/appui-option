// Javascript Document
(() => {
  return {
    data(){
      return this.source
    },
    computed: {
      root() {
        return appui.plugins['appui-option'] + '/'
      }

    }
  };
})()