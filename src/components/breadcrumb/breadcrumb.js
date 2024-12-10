(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    data() {
      return {
        root: appui.plugins['appui-option'] + '/',
        isCodeManual: false,
      }
    },
    computed: {
      options() {
        const res = this.source.slice();
        if (this.source[this.source.length-1].id_parent === null) {
          res.reverse();
        }

        return res;
      }
    }
  };
})()