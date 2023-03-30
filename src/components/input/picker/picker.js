// Javascript Document

(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.inputComponent],
    props: {
      id_root: {
        type: String,
        default: null
      }
    },
    data(){
      return {
        root: appui.plugins['appui-option'] + '/',
        rootAlias: '',
        showFloater: false
      };
    },
    methods: {
      getText(d) {
        let st = d.text || (d.alias && d.alias.text ? '<em style="color:#4285f4">'+ d.alias.text +'</em>' : d.code);
        if ( (d.code !== undefined) && (d.code !== null) ){
          st += ' &nbsp; <span class="bbn-grey"> (' + d.code + ')</span>';
        }

        return st;
      },
      treeMapper(d, l, n){
        n.text = this.getText(d);
        return n;
      },
      optionSelect(d) {
        bbn.fn.log("SDELECT", d);
        this.emitInput(d.data.id);
        this.rootAlias = bbn.fn.html2text(d.data.text);
        this.showFloater = false;
      }
    },
    mounted() {
      this.post(this.root + 'root_options_tree', {
        id: this.id_root || false
      }, (d) => {
        this.ready = true;
      });
      if (this.value) {
        this.post(this.root + 'data/option', {id: this.value}, d => {
          this.rootAlias = d.data.text || (d.data.alias ? d.data.alias.text : d.data.code);
        });
      }
    },
    watch: {
      value(p) {
        if (!p) {
          this.rootAlias = '';
        }
      }
    }
  };
})();