(() => {
  return {
    mixins: [bbn.cp.mixins['appui-option-tree']],
    props: {
      prefixes: {
        type: Array,
        default(){
          return [{
            text: 'None',
            value: null
          }, {
            text: 'appui',
            value: 'appui'
          }, {
            text: bbn._('Other'),
            value: 'other'
          }];
        }
      }
    },
    data: {
      currentPrefix: ''
    },
    methods: {
      validate() {
        if (this.source.prefix && (bbn.fn.sanitize(this.source.prefix) !== this.source.prefix)) {
          return bbn._('The prefix contains invalid characters');
        }
        if (bbn.fn.sanitize(this.source.code) !== this.source.code) {
          return bbn._('The code contains invalid characters');
        }

        return true;
      }
    },
    watch: {
      currentPrefix(v) {
        this.source.prefix = v === 'other' ? '' : v;
      }
    }
    
  };
})()