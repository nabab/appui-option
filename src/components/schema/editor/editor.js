(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    data() {
      return {
        showFlabel: !!this.source.flabel,
        widthType: this.source.width ? 'fixed' : (this.source.maxWidth || this.source.minWidth ? 'dynamic' : 'auto'),
        widthRadio: [
          {text: bbn._("Auto"), value: "auto"},
          {text: bbn._("Pre-set"), value: "fixed"},
          {text: bbn._("Dynamic"), value: "dynamic"}
        ],
        optionsType: this.source.source ? 'source' : (this.source.options ? 'options' : 'auto'),
        optionsRadio: [
          {text: bbn._("None"), value: null},
          {text: bbn._("Only source"), value: 'source'},
          {text: bbn._("Full options"), value: 'options'}
        ],
        types: [
          "url",
          "boolean",
          "string",
          "number",
          "json",
          "textarea",
          "bool",
        ]
      }
    },
    computed: {},
    methods: {
      onSubmit() {
        this.$emit('save', this.source)
      }
    }
  }
})();
