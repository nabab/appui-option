/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 25/10/17
 * Time: 13.44
 */
(() => {
  return {
    data(){
      return {
        isMounted: false,
        cat: '',
        root: appui.plugins['appui-option'] + '/'
      }
    },
    methods: {
      treeMapper(d, l, n){
        n.text = d.text || (d.alias && d.alias.text ? '<em style="color:#4285f4">'+ d.alias.text +'</em>' : d.code);
        if ( (d.code !== undefined) && (d.code !== null) ){
          n.text += ' &nbsp; <span class="bbn-grey"> (' + d.code + ')</span>';
        }
        return n;
      },
      optionSelect(d) {
        let keys = Object.keys(this.source.data);
        bbn.fn.log("optionSelect", d.data, this.source, keys);
        if (keys.includes('id_root_alias')) {
          this.$set(this.source.data, 'id_root_alias', d.data.id);
          this.$set(this.source.data, 'root_alias', bbn.fn.html2text(d.data.text));
        }
        else if (keys.includes('id_alias')) {
          this.$set(this.source.data, 'id_alias', d.data.id);
          this.$set(this.source.data, 'alias', d.data);
        }
        setTimeout(() => {
          this.getPopup().close();
        }, 250);
      }
    },
    mounted(){
      this.post(this.root + 'root_options_tree', {
        id: bbn.vue.find(this.getPopup(), 'appui-option-config') ? false : (this.source.idRootTree || false)
      }, (d) => {
        this.isMounted = true;
        this.cat = d.data.cat;
      });
    }
  }
})();
