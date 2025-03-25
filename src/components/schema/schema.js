(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    props: {
      source: {
        type: Array,
        default() {
          return []
        }
      }
    },
    data() {
      return {
        isEditing: false,
        edited: null
      }
    },
    methods: {
      cancel() {
        this.isEditing = false;
        this.source.pop();
        this.edited = null;
      },
      saveItem(item) {
        bbn.fn.log("SAVE ITEM DONE", item)
        if (item) {
          this.source.push(item);
          this.isEditing = false;
          this.edited = null;
        }

      },
      addItem() {
        this.source.push({
          label: '',
          field: '',
          type: '',
        });
        this.edited = this.source[this.source.length - 1];
        this.isEditing = true;
      },
      deleteItem(idx) {
        if (this.source[idx]) {
          this.source.splice(idx, 1);
        }
      }
    },
    watch: {
      isEditing(val) {
        if (val && this.edited) {
          this.getPopup({
            label: bbn._("Schema editor"),
            component: "appui-option-schema-editor",
            source: this.edited,
            onClose: () => { this.edited = false; this.isEditing = false},
            events: {
              save: this.saveItem
            }
          })
        }
      }
    }
  }
})();
