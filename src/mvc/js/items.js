(function(){
  return {
    props: ['source'],
    data(){
      return {
        widgets: bbn.fn.map(this.source.categories, (a) => {
          return {
            title: '<a href="' + this.source.root + 'list/' + a.id + '"><i class="' + a.icon + '"> </i> ' + a.text + '</a>',
            content: a.desc ? a.desc : '...'
          };
        })
      }
    }
  };
})();