(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.inputComponent],
    props: {
      root: {
        type: String,
        required: true
      },
      permission: {
        type: String,
        default: ''
      }
    },
    data(){
      return {
        sourceURL: appui.plugins['appui-option'] + '/permissions/tree',
        currentValue: this.value,
        currentPermission: this.permission
      }
    },
    computed: {
    },
    methods: {
      selectPermission(node) {
        this.currentValue = node.data.id;
        this.currentPermission = node.data.text;
      },
      mapPermissions(a){
        a.text += ' &nbsp; <span class="bbn-grey">' +  "(" + a.code +  ")" + '</span>';
        a.selectable = a.icon === 'nf nf-fa-file';
        return a;
      },
    },
    watch: {
      currentValue(v) {
        this.emitInput(v)
      },
      "obj.icon"(v) {
        this.currentValue = v;
      },
      root(){
        let tree = this.getRef('tree');
        if (tree) {
          //tree.updateData();
        }
      }
    }
  }
})();

