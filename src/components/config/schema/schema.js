(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    props: {
      source: {
        type: Array,
        default() {
          return []
        }
      },
      frozen: {
        type: Boolean,
        default: false
      }
    },
    data() {
      return {
        isEditing: false,
        edited: null,
        newElement: false
      }
    },
    methods: {
      cancel() {
        bbn.fn.log('cancel');
        this.isEditing = false;
        this.edited = null;
        if (this.newElement) {
          this.newElement = false;
          this.source.pop();
        }
      },
      saveItem(item) {
        bbn.fn.log("SAVE ITEM DONE", item)
        if (item) {
          this.source.push(item);
          this.isEditing = false;
          this.edited = null;
        }
      },
      editItem(idx) {
        if (this.source[idx]) {
          this.edited = this.source[idx];
          this.isEditing = true;
        }
      },
      addItem() {
        if (!this.newElement) {
          this.newElement = true;
          this.source.push({
            label: '',
            field: '',
            type: '',
          });
          this.edited = this.source[this.source.length - 1];
          this.isEditing = true;
        }
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
            component: "appui-option-config-schema-editor",
            source: this.edited,
            onClose: () => {
              this.isEditing = false;
              this.edited = null;
            },
            events: {
              save: this.saveItem,
              cancel: this.cancel
            }
          })
        }
        else if (!val) {
          this.edited = null;
          if (this.newElement) {
            this.newElement = false;
          }
        }
      }
    }
  }
})();
