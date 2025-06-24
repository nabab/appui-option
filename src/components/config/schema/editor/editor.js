(() => {
  const forbidden = ['id', 'id_alias', 'id_parent', 'code', 'value', 'num_children', 'num'];
  const getDefaultConfig = obj => bbn.fn.extend({
    type: '',
    label: '',
    flabel: '',
    field: '',
    editable: 0,
    required: 0,
    nullable: 0,
    invisible: 0,
    showable: 0,
    filterable: 0,
    cls: '',
    width: '',
    maxWidth: '',
    minWidth: '',
    source: null,
    options: null,
    defaultValue: null,
    component: '',
    componentOptions: {},
    editor: '',
    editorOptions: {},
  }, obj || {});
  return {
    mixins: [bbn.cp.mixins.basic],
    data() {
      const currentSource = getDefaultConfig(this.source);
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
        editorOptionsType: this.source.editorOptions ? 'options' : (this.source.source ? 'source' : 'auto'),
        currentSource,
        currentOptions: this.source.options || '{}',
        tree: appui.getRegistered('appui-option-tree') || null,
        types: [
          "html",
          "url",
          "boolean",
          "string",
          "number",
          "json",
          "textarea",
          "bool",
          "datetime",
          "date",
          "time",
          "email",
          "url",
          'color',
          "percent",
          "money",
          "multilines"
        ]
      }
    },
    methods: {
      onCancel() {
        bbn.fn.log("onCancel");
        this.$emit('cancel');
      },
      onSubmit() {
        if (forbidden.includes(this.source.field.trim().toLowerCase())) {
          appui.error(bbn._("The field name cannot be one of the following: ") + forbidden.join(', '));
          return false;
        }

        bbn.fn.log("onSubmit", this.source);
        const witness = getDefaultConfig();
        bbn.fn.iterate(this.source, (value, key) => {
          if ((value === witness[key]) && (key in this.source)) {
            delete this.source[key];
            bbn.fn.log("deleting key " + key);
          }
        });
        this.$emit('save', this.source)
      },
    },
    watch: {
      currentSource: {
        deep: true,
        handler(v) {
          bbn.fn.log("currentSource changed");
          const witness = getDefaultConfig();
          bbn.fn.iterate(v, (value, key) => {
            if ((value !== witness[key]) && (this.source[key] !== value)) {
              this.source[key] = value;
              bbn.fn.log(key + "set to " + value);
            }
          });
        }
      },
      currentOptions(v) {
        if (v) {
          this.source.options = bbn.fn.isString(v) ? JSON.parse(v) : v;
        }
        else {
          delete this.source.options;
        }
      },
    }
  }
})();
