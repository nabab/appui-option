(() => {
  return {
    mixins: [bbn.vue.basicComponent, bbn.vue.inputComponent],
    data(){
      return {
        sourceURL: appui.plugins['appui-option'] + '/data/permissions/sources',
        currentValue: this.value
      }
    },
    computed: {
    },
    methods: {
    },
    watch: {
      currentValue(v) {
        this.emitInput(v)
      }
    }
  }
})()