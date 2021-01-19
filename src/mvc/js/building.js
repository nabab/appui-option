/**
 * Created by BBN Solutions.
 * User: Vito Fava
 * Date: 07/08/17
 * Time: 15.47
 */
// Javascript Document
(function(){
  return function(ele, data){
   // var $tree = $("div.bbn_options_tree2", ele),
   //     $treeEmpty = $("div.bbn_options_tree3", ele),
    var $tree = ele.querySelectorAll("div.bbn_options_tree2"),
        $treeEmpty = ele.querySelectorAll("div.bbn_options_tree3"),
        src = function(id){
          return this.post(data.root + "building/" + id).promise().then(function(d){

            return bbn.fn.map(d.data, function(v){
              var r = {
                title: v.text,
                /** @todo apply a function on the icons for removing all which only have 'cogs' (without nf nf-fa-) */
                icon: v.icon && (v.icon.indexOf(" ") > -1) ? v.icon : 'nf nf-fa-cog',
                data: {}
              };
              if ( v.code ){
                r.title += ' <span class="bbn-grey">' + v.code + '</span>';
              }
              if ( v.num_children ){
                r.lazy = true;
              }
              for ( var n in v ){
                r.data[n] = v[n];
              }
              return r;
            });
          });
        },
        treeCfg = {
          extensions: ["filter"],
          keydown: function (e, d) {
            if ((e.key === 'Enter') || (e.key === ' ')) {
              //$(d.node.li).find("span.fancytree-title").click();
              bbn.fn.each(d.node.li.querySelectorAll("span.fancytree-title"), (ele,i) => {
                ele.click();
              });
            }
          },
          click: function (e, d) {
            if ( d.targetType === 'title' ){
              bbn.fn.link(data.root + "list/" + d.node.data.id);
              e.preventDefault();
            }
          },
          source: function(){
            return src(data.cat);
          },
          lazyLoad: function(e, d){
            d.result = src(d.node.data.id);
          },
          filter: {
            // Re-apply last filter if lazy data is loaded
            autoApply: true,
            // Expand all branches that contain matches while filtered
            autoExpand: true,
            // Hide expanders if all child nodes are hidden by filter
            hideExpanders: true,
            // Match end nodes only
            leavesOnly: false,
            nodata: "No menu element match your search",
            mode: "hide"
          }
        };
    if ( data.is_dev ){
      treeCfg.extensions.push("dnd");
      bbn.fn.extend(treeCfg, {
        dnd: {
          dragStart: function(node, data) {
            bbn.fn.log("DRAGSTART", node, data);
            // This function MUST be defined to enable dragging for the tree.
            // Return false to cancel dragging of node.
            //    if( data.originalEvent.shiftKey ) ...
            //    if( node.isFolder() ) { return false; }
            return true;
          },
          dragEnter: function(node, data) {
            /* data.otherNode may be null for non-fancytree droppables.
             * Return false to disallow dropping on node. In this case
             * dragOver and dragLeave are not called.
             * Return 'over', 'before, or 'after' to force a hitMode.
             * Return ['before', 'after'] to restrict available hitModes.
             * Any other return value will calc the hitMode from the cursor position.
             */
            // Prevent dropping a parent below another parent (only sort
            // nodes under the same parent):
            //    if(node.parent !== data.otherNode.parent){
            //      return false;
            //    }
            // Don't allow dropping *over* a node (would create a child). Just
            // allow changing the order:
            //    return ["before", "after"];
            // Accept everything:
            return true;
          },
          dragDrop: function(node, data) {
            // This function MUST be defined to enable dropping of items on the tree.
            // data.hitMode is 'before', 'after', or 'over'.
            // We could for example move the source to the new target:
            data.otherNode.moveTo(node, data.hitMode);
          }
        }
        /*
         dragAndDrop: true,
         drag: function(e){
         var dd = false,
         ds = this.dataItem(e.sourceNode),
         ok = 1;
         if ( e.dropTarget === undefined ){
         ok = false;
         }
         dd = this.dataItem(e.dropTarget);
         if ( ok ){
         if ( (dd.id_parent !== 0) && !dd.cfg.allow_children ){
         ok = false;
         }
         else if ( ds.id === dd.id ){
         ok = false;
         }
         else if ( !dd.cfg.sortable && (ds.id_parent === dd.id) ){
         ok = false;
         }
         }
         if ( !ok ){
         if ( e.setStatusClass !== undefined ){
         e.setStatusClass("k-denied");
         }
         if ( e.setValid !== undefined ){
         e.setValid(false);
         }
         }
         },
         drop: function(e){
         bbn.fn.log(e);
         var tree = this;
         if ( e.valid && confirm(data.lng.confirm_move) ){
         var dd = tree.dataItem(e.destinationNode),
         ds = tree.dataItem(e.sourceNode),
         prev = $(e.sourceNode).prev(),
         parent = $(e.sourceNode).parent();
         this.post(data.root + 'actions/move', {
         dest: dd.id,
         src: ds.id
         }, function(d){
         if ( !d.res ){
         e.setValid(false);
         e.preventDefault();
         appui.alert(data.lng.problem_while_moving, bbn.lng.error, 400);
         tree.dataSource.read();
         }
         });
         }
         else{
         e.preventDefault();
         }
         }
         */
      });
    };
    var treeCfgTwo = {
      extensions: ["filter"],
      keydown: function (e, d) {
        if ((e.key === 'Enter') || (e.key === ' ')) {
          //$(d.node.li).find("span.fancytree-title").click();
          bbn.fn.each(d.node.li.querySelectorAll("span.fancytree-title"), (ele,i) => {
            ele.click();
          });
        }
      },
      click: function (e, d) {
        if ( d.targetType === 'title' ){
          bbn.fn.link(data.root + "list/" + d.node.data.id);
          e.preventDefault();
        }
      },
      source: [
        {title: "Node 1", key: "1"},
        {title: "Folder 2", key: "2", folder: true, children: [
          {title: "Node 2.1", key: "3", myOwnAttr: "abc"},
          {title: "Node 2.2", key: "4"},
          {title: "Node 2.3", key: "4"}

        ]}
      ],
      lazyLoad: function(e, d){
        d.result = src(d.node.data.id);
      },
      filter: {
        // Re-apply last filter if lazy data is loaded
        autoApply: true,
        // Expand all branches that contain matches while filtered
        autoExpand: true,
        // Hide expanders if all child nodes are hidden by filter
        hideExpanders: true,
        // Match end nodes only
        leavesOnly: false,
        nodata: "No menu element match your search",
        mode: "hide"
      },
      dnd: {
        dragStart: function(node, data) {
          bbn.fn.log("DRAGSTART", node, data);
          return true;
        },
        dragEnter: function(node, data) {
          return true;
        },
        dragDrop: function(node, data) {

          data.otherNode.moveTo(node, data.hitMode);
        }
      }
    };
    bbn.fn.log(treeCfg);
    $tree.fancytree(treeCfg);
    $treeEmpty.fancytree(treeCfgTwo);
  }
})();