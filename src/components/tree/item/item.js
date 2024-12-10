(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    computed: {
      isAlias() {
        return !this.source.data.text && this.source.data.alias;
      },
      realCode() {
        let st = '<em>' + bbn._('No code') + '</em>';
        if (this.source.data.code) {
          st = '(' + this.source.data.code + ')';
        }
        else if (this.source.data.alias?.code) {
          st = '(' + this.source.data.alias.code + ')';
        }

        return st;
      },
      realText() {
        let st = '<em>' + bbn._('No text') + '</em>';
        if (this.source.data.text) {
          st = this.source.data.text;
        }
        else if (this.source.data.alias?.text) {
          st = this.source.data.alias.text;
        }

        return st;
      },
      realIcon() {
        let st = 'nf nf-fa-file';
        if (this.source.data.icon) {
          st = this.source.data.icon;
        }
        else if (this.source.data.alias?.icon) {
          st = this.source.data.alias.icon;
        }

        return st;
      }
    }
  }
})();