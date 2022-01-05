// Javascript Document

(()=> {
  return {
    props: {
    },
    data() {
      return {
        root: appui.plugins['appui-option'] + '/',
        checkTimeout: 0,
        delId: "",
        idParent: "",
        currentNode: null,
        showGallery: false,
        currentData: {
          url: "",
          title: "", //input
          image: "",
          description: "", //textarea
          id: null,
          images: [],
          image: ""
        },
        currentSource: [],
        drag: true,
      }
    },
    methods: {
      getData () {
        this.currentSource = [];
        bbn.fn.post(this.root + "bookmark/action/data", d => {
          this.currentSource = d.data;
        });
      },
      resetform() {
        this.currentData = {
          url: "",
          title: "",
          image: "",
          description: "",
          id: null,
          images: [],
          cover: null,
        };
        this.idParent = "";
      },
      isDragEnd(event, nodeSrc, nodeDest) {
        if (nodeDest.data.url) {
          event.preventDefault();
        }
        else {
          bbn.fn.post(this.root + "bookmark/action/move", {
						source: nodeSrc.data.id,
            dest: nodeDest.data.id
          }, d => {
            bbn.fn.log(nodeSrc, nodeDest, "nodes");
          });
        }
        bbn.fn.log(event);
      },
      checkUrl() {
        if (!this.currentData.id && bbn.fn.isURL(this.currentData.url)) {
          bbn.fn.post(
            this.root + "bookmark/action/preview",
            {
              url: this.currentData.url,
            },
            d => {
              if (d.success) {
                this.currentData.title = d.data.title;
                this.currentData.description = d.data.description;
                this.currentData.cover = d.data.cover ||null;
                if (d.data.images) {
                  this.currentData.images = bbn.fn.map(d.data.images, (a) => {
                    return {
                      content: a,
                      type: 'img'
                    }
                  })
                }
                bbn.fn.log("d.data.iamges :", this.currentData.images);
              }
              return false;
            },
            e => {
              bbn.fn.log(e);
            }
          );
        }
      },
      selectTree(node) {
        this.currentNode = node;
      },
      add() {
        bbn.fn.log("values", this.currentTitle, this.currentUrl, this.currentDescription, "id parent", this.source.id_parent, this);
        bbn.fn.post(
          this.root + "bookmark/action/add",
          {
            url: this.currentData.url,
            description: this.currentData.description,
            title: this.currentData.title,
            id_parent:  this.idParent,
            cover: this.currentData.cover
          },  d => {
            if (d.success) {
              this.getData();
            }
          });
      },
      selectImage(img) {
        this.currentData.cover = img.data.content;
        this.showGallery = false;
      },
      modify() {
        /*bbn.fn.post(
          "action/delete",
          {
            id: this.currentData.id
          },  d => {
            if (d.success) {
              bbn.fn.log("d = ", d);
            }
          });
        bbn.fn.post(
          "action/add",
          {
            url: this.currentData.url,
            description: this.currentData.description,
            title: this.currentData.title,
            id_parent:  this.idParent,
          },  d => {
            if (d.success) {
              this.$refs.tree.reload();
            }
          });*/
        bbn.fn.post(this.root + "bookmark/action/modify", {
          url: this.currentData.url,
          description: this.currentData.description,
          title: this.currentData.title,
          id: this.currentData.id,
          cover: this.currentData.cover
        },  d => {
          if (d.success) {
            this.getData();
          }
        });
      },
      deletePreference() {
        bbn.fn.log("values", this.currentTitle, this.currentUrl, this.currentDescription, "id parent", this.source.id_parent, this.source.items, "ALL ID ", this.source.delId);
        bbn.fn.post(
          this.root + "bookmark/action/delete",
          {
            id: this.currentData.id
          },  d => {
            if (d.success) {
              this.getData();
            }
          });
        return;
      },
    },
    mounted() {
      this.getData();
    },
    watch: {
      'currentData.url'() {
        if (!this.currentData.id) {
          clearTimeout(this.checkTimeout);
          this.checkTimeout = setTimeout(() => {
            this.checkUrl();
          }, 250);
        }
      },
      currentNode(v) {
        if (v) {
          this.currentData = {
            url: v.data.url || "",
            title: v.data.text || "",
            description: v.data.description || "",
            id: v.data.id || "",
            cover: v.data.cover || null
          };
        }
        else {
          this.resetForm();
        }
      },
    }
  }
})();