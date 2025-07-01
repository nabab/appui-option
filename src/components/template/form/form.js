// Javascript Document

(() => {
  return {
    mixins: [bbn.cp.mixins.basic, bbn.cp.mixins['appui-option-tree']],
    computed: {
      currentIcon: {
        get() {
          return this.source.option.icon || '';
        },
        set(value) {
          this.source.option.icon = value;
          return true;
        }
      },
    },
    methods: {
      success(d) {
        if ( d.success && d.data ){
          if (this.tree) {
            let list = this.tree.getRef('tree' + bbn.fn.getField(this.tree.blocks, 'id', a => a.index === this.tree.currentIndex));
            const node = this.tree.currentNode;
            this.$nextTick(() => {
              if (node){
                node.parent.reload()
              }
              else {
                list.reload();
              }
            })
          }
          appui.success(bbn._('Saved'));
        }
        else {
          appui.error(d);
        }
      },
      selectIcon() {
        this.getPopup({
          width: '80%',
          height: '80%',
          label: bbn._('Icon Picker'),
          component: 'appui-core-popup-iconpicker',
          source: {
            field: 'currentIcon',
            obj: this
          }
        });
      }
    }
  }
})();