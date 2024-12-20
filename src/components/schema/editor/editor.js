(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    data() {
      return {
        showFtitle: !!this.source.ftitle,
        widthType: this.source.width ? 'fixed' : (this.source.maxWidth || this.source.minWidth ? 'dynamic' : 'auto'),
        widthRadio: [
          {text: bbn._("Auto"), value: "auto"},
          {text: bbn._("Fixed"), value: "fixed"},
          {text: bbn._("Dynamic"), value: "dynamic"}
        ],
        optionsType: this.source.source ? 'source' : (this.source.options ? 'options' : 'auto'),
        optionsRadio: [
          {text: bbn._("None"), value: null},
          {text: bbn._("Only source"), value: 'source'},
          {text: bbn._("Full options"), value: 'options'}
        ]
      }
    },
    computed: {},
    methods: {}
  }
})();
