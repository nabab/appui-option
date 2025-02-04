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
        bbn.fn.log("CANCEL ITEM TO DO")
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
          title: '',
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
    }
  }
})();
