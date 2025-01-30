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
      saveItem() {
        bbn.fn.log("SAVE ITEM TO DO")
      },
      addItem() {
        this.source.push({
          text: '',
          value: ''
        });
        this.edited = this.source[this.source.length - 1];
        this.isEditing = true;
      },
      deleteItem(idx) {
        
      }
    }
  }
})();
