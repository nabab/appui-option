(() => {
  return {
    mixins: [bbn.cp.mixins.basic, bbn.cp.mixins.input],
    data(){
      return {
        sourceURL: appui.plugins['appui-option'] + '/data/permissions/sources',
        currentValue: this.value,
        dropdown: false
      }
    },
    methods: {
      setDropdown(){
        this.dropdown = this.getRef('dropdown');
      }
    },
    computed: {
      currentCode(){
        let code = '';
        if (this.value && this.dropdown) {
          let data = bbn.fn.getField(this.dropdown.currentData, 'data', {'data.rootAccess': this.value});
          if (data) {
            code = data.code;
          }
        }
        return code;
      }
    },
    watch: {
      currentValue(v){
        this.emitInput(v);
      },
      value(newVal){
        this.currentValue = newVal;
      },
      currentCode(newVal){
        this.$emit('code', this.currentCode);
      }
    }
  }
})()