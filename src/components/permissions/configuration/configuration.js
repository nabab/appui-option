// Javascript Document

(() => {
  return {
    props: ['source', 'parent'],
    data(){
      return {};
    },
    computed: {
      conf(){
        return {
          id: this.source.id,
          code: this.source.code,
          text: this.source.text,
          help: this.source.help,
          public: this.source.public || false,
          cascade: this.source.cascade || false
        }
      },
    },
    methods: {
      success(d) {
        if ( d && d.success ){
          appui.success(bbn._('Saved!'));
        }
        else {
          appui.error(bbn._('Error!'));
        }
      }
    }
  }
})();