// Javascript Document
(() => {
  return {
    props: ['source'],
    methods: {
      save(row, col, idx){
        if ( !row.text || !row.code ){
          this.getPopup().alert(bbn._("Text and Code are mandatory!"));
        }
        else {
          this.post(this.source.root + 'actions/' + (row.id ? 'update' : 'insert'), row, (d) => {
            if ( d.success ){
              this.$refs.table.updateData();
              this.$refs.table.editedRow = false;
              this.$refs.table.editedIndex = false;
              appui.success();
            }
            else{
              appui.error(d);
            }
          });
        }
      },
      remove(row, col, idx){
        if ( row.id ){
          this.confirm(bbn._('Are you sure you want to delete this entry?'), () => {
            this.post(this.source.root + 'actions/delete', {id: row.id}, (d) => {
              if ( d.success ){
                this.$refs.table.updateData();
                appui.success(bbn._('Deleted'));
              }
              else {
                appui.error(d);
              }
            });
          });
        }
      },
      getButtons(e){
        let res = [{
          text: bbn._("Options's page"),
          icon: 'nf nf-fa-list',
          action: () => {
            bbn.fn.link(this.source.root + 'list/' + e.id)
          },
          notext: true
        }];
        if ( e.write ){
          res.push({
            text: bbn._('Edit'),
            icon: 'nf nf-fa-edit',
            action: 'edit',
            notext: true
          });
        }
        if ( !e.num_children && e.write ){
          res.push({
            text: bbn._('Delete'),
            icon: 'nf nf-fa-trash',
            action: this.remove,
            notext: true
          });
        }
        return res;
      }
    }
  }
})();



// Javascript Document
/*(() => {
  return {
    props: ['source'],
    methods: {
      save(row, col, idx){
        if ( !row.text || !row.code ){
          this.getPopup().alert(bbn._("Text and Code are mandatory!"));
        }
        else {
          this.post(this.source.root + 'actions/' + (row.id ? 'update' : 'insert'), row, (d) => {
            if ( d.success ){
              if ( !row.id ){
                if ( d.data ){
                  this.$refs.table.add(d.data);
                  this.$refs.table.updateData();
                }
                else {
                  appui.error();
                }
              }
              else {
                this.source.options[idx] = row;
              }
              this.$refs.table.editedRow = false;
              this.$refs.table.editedIndex = false;
              appui.success();
            }
            else{
              appui.error();
            }
          });
        }
      },
      remove(row, col, idx){
        if ( row.id && this.source.options[idx] ){
          this.confirm('Are you sure you want to delete this entry?', () => {
            this.post(this.source.root + 'actions/delete', {id: row.id}, (d) => {
              if ( d.success ){
                this.source.options.splice(idx, 1);
                this.$refs.table.updateData();
                appui.success(bbn._('Deleted'));
              }
              else {
                appui.error();
              }
            });
          });
        }
      },
      getButtons(e){
        let res = [{
          text: bbn._("Options's page"),
          icon: 'nf nf-fa-list',
          action: () => {
            bbn.fn.link(this.source.root + 'list/' + e.id)
          },
          notext: true
        }];
        if ( e.write ){
          res.push({
            text: bbn._('Edit'),
            icon: 'nf nf-fa-edit',
            action: 'edit',
            notext: true
          });
        }
        if ( !e.num_children && e.write ){
          res.push({
            text: bbn._('Delete'),
            icon: 'nf nf-fa-trash',
            action: this.remove,
            notext: true
          });
        }
        return res;
      }
    }
  }
})();*/
/*
(function(){
  return function(ele, data){
    bbn.fn.log(data);
    $.fn.reverse = [].reverse;//save a new function from Array.reverse

    var selectedClass = 'bbn-state-selected',

    mainDataSource = new kendo.data.DataSource({
      schema: {
        model: dataModel
      },
      transport: {
        read: function(options){
          bbn.opt._cat = data.options;
          bbn.fn.order(bbn.opt._cat, "text");
          options.success(bbn.opt._cat);
        },
        create: function(options){
          var opt = bbn.fn.formdata($(".k-edit-form-container"));
          this.post(data.root + "actions/insert", bbn.fn.gridParse(opt), function(d){
            if ( (d !== undefined) && d.res ){
              data.options.push(d.res);
              if ( d.res.tekname ){
                bbn.opt.categories[d.res.id] = d.res.tekname;
                bbn.opt[d.res.tekname] = {};
              }
              options.success(d.res);
              mainDataSource.read();
              return d.res;
            }
            mainGrid.cancelChanges();
            appui.alert(data.lng.impossible_to_add_category);
          });
        },
        update: function(options){
          var opt = bbn.fn.formdata($(".k-edit-form-container"));
          opt.id = options.data.id;
          this.post(data.root + "actions/update", opt, function(d){
            if ( (typeof(d) !== 'undefined') && d.res ){
              var idx = bbn.fn.search(data.options, {"id": d.res.id});
              if ( idx > -1 ){
                data.options.splice(idx, 1, d.res);
              }
              if ( bbn.opt[d.res.id] !== d.res.tekname ){
                if ( d.res.tekname && !bbn.opt.categories[d.res.id] ){
                  bbn.opt.categories[d.res.id] = d.res.tekname;
                  bbn.opt[d.res.tekname] = d.res;
                }
                else if ( !d.res.tekname && bbn.opt.categories[d.res.id] ){
                  delete bbn.opt[bbn.opt.categories[d.res.id]];
                  delete bbn.opt.categories[d.res.id];
                }
                else if ( d.res.tekname && bbn.opt.categories[d.res.id] ){
                  bbn.opt[d.res.tekname] = bbn.opt[bbn.opt.categories[d.res.id]];
                  delete bbn.opt[bbn.opt.categories[d.res.id]];
                  bbn.opt.categories[d.res.id] = d.res.tekname;
                }
              }
              options.success(options.data);
              mainDataSource.read();
            }
            else{
              mainGrid.cancelChanges();
              appui.alert(data.lng.impossible_to_update_category);
            }
          });
        },
        destroy: function(options){
          appui.confirm(data.lng.are_you_sure_to_delete_category, function(){
            this.post(data.root + "actions/delete", {id: options.data.id}, function(d){
              if ( (typeof(d) !== 'undefined') && d.res ){
                if ( bbn.opt.categories[d.res.id] ){
                  delete bbn.opt.categories[d.res.id];
                }
                var idx = bbn.fn.search(data.options, {"id": d.res.id});
                if ( idx > -1 ){
                  data.options.splice(idx, 1, d.res);
                }
                options.success(d.res);
                mainDataSource.read();
              }
              else{
                mainGrid.cancelChanges();
                appui.alert(data.lng.impossible_to_delete_category);
              }
            });
          }, function(){
            mainGrid.cancelChanges();
          });
        }
      }
    }),

    mainGrid = $("div.bbn-options-grid", ele).kendoGrid({
      sortable: true,
      editable: {
        mode: "popup",
        window: {
          width: 720
        }
      },
      edit: function(e) {
        bbn.fn.hideUneditable(e);
        e.container.prev().find("span.k-window-title").html(e.model.id ? data.lng.update_of_option_category + " " + e.model.text : data.lng.new_option_category);
        // Champ pour la valeur par défaut invisible lors de la création de la catégorie
        bbn.fn.log(e);
      },
      columns: [{
        title: data.lng.id,
        field: "id",
        width: 100,
        hidden: !data.is_dev,
      }, {
        title: data.lng.parent,
        field: "id_parent",
        hidden: true
      }, {
        title: data.lng.name,
        field: "text",
      }, {
        title: data.lng.code,
        field: "code",
        width: 80,
      }, {
        title: data.lng.icon,
        field: "icon",
        width: 50,
        template: function(e){
          return '<i class="' + (e.icon ? e.icon : 'nf nf-fa-cog') + '"> </i>';
        },
        editor: function(container, o){
          var $input = $('<input type="hidden" name="' + o.field + '">'),
              $icon = $('<i class="' + (o.model.icon ? o.model.icon : 'nf nf-fa-cog') + '" style="font-size: large"> </i>'),
              $button = $('<button class="k-button">Choisir</button>');
          $button.click(function(){
            bbn.fn.window('iconology/picker', {}, 800, 500, function(ele){
              ele.on("click", ".k-button", function(){
                var cl = $(this).children("i")[0].className;
                $input.val(cl).change();
                $icon[0].className = cl;
                bbn.fn.closePopup();
              });
            });
          });
          container.append($input, $icon, '&nbsp;&nbsp;', $button);
        }
      }, {
        title: data.lng.subcategories,
        field: "num_children",
        width: 40,
      }, {
        title: data.lng.accessible,
        field: "tekname",
        width: 150,
        template: function(e){
          return e.tekname ? e.tekname : "-";
        }
      }, {
        title: data.lng.actions,
        field: "id",
        width: 120,
        template: function(e){
          var st = '';
          if ( e.write ){
            st += '<a href="#" class="k-button k-grid-edit" title="Modifier"><i class="nf nf-fa-edit"> </i></a>';
          }
          if ( !e.num_children && e.write ){
            st += '<a href="#" class="k-button k-grid-delete" title="Supprimer"><i class="nf nf-fa-times"> </i></a>';
          }
          st += '<a href="javascript:;" class="k-button" title="Page des options" onclick="bbn.fn.link(\'' + data.root + 'list/' + e.id + '\');"><i class="nf nf-fa-list"> </i></a>';
          return st;
        }
      }],
      toolbar: [{
        name: "create",
        text: data.lng.new_category
      }],
      dataSource: mainDataSource
    }).data("kendoGrid");
  }
})();
*/
