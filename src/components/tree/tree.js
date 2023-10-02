/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 25/10/17
 * Time: 13.44
 */
(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    data(){
      return {
        isMounted: false,
        cat: '',
        root: appui.plugins['appui-option'] + '/'
      }
    },
    methods: {
      treeMapper(d, l, n){
        n.text = d.text || (d.data.alias && d.data.alias.text ? '<em style="color:#4285f4">'+ d.data.alias.text +'</em>' : d.data.code);
        if ( (d.data.code !== undefined) && (d.data.code !== null) ){
          n.text += ' &nbsp; <span class="bbn-grey"> (' + d.data.code + ')</span>';
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
        id: this.getPopup().find('appui-option-config') ? false : (this.source.idRootTree || false)
      }, (d) => {
        this.isMounted = true;
        this.cat = d.data.cat;
      });
    }
  }
})();
