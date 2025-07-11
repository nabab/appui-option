(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    data() {
      return {
        isMine: this.closest('bbn-container').url === 'preferences'
      }
    },
    computed: {
      users(){
        return appui.users
      },
      groups(){
        return appui.groups.map(a => ({text: a.nom, value: a.id}))
      }
    },
    methods: {
      renderType(row){
        let r = '<span class="'
        if ( !!row.public ){
          r += 'bbn-green">' + bbn._('Public')
        }
        else if ( !!row.id_user ){
          r += 'bbn-red">' + bbn._('User')
        }
        else if ( !!row.id_group ){
          r += 'bbn-orange">' + bbn._('Group')
        }
        return r + '</span>'
      },
      add(){
        this.getPopup({
          label: bbn._('Add preference'),
          component: this.$options.components.form,
          source: {
            id_option: this.source.id,
            id_user: null,
            id_group: null,
            public: 0,
            id_alias: null,
            id_link: null,
            text: null,
            num: null
          },
          width: '90%',
        })
      },
      edit(row){
        this.getPopup({
          label: bbn._('Edit preference'),
          component: this.$options.components.form,
          source: row,
          width: '90%'
        })
      },
      removeItem(row){
        if ( row.id ){
          this.confirm(bbn._('Are you sure you want to to delete this preference?'), () => {
            this.post(appui.plugins['appui-option'] + '/actions/preferences/remove', {id: row.id} , d => {
              if ( d.success ){
                let idx = bbn.fn.search(this.source[this.isMine ? 'prefs' : 'uprefs'], {id: row.id})
                if ( idx > -1 ){
                  this.source[this.isMine ? 'prefs' : 'uprefs'].splice(idx, 1)
                  this.$refs.table.updateData()
                }
                appui.success(bbn._('Deleted'))
              }
              else {
                appui.error(d);
              }
            });
          })
        }
      },
      removeAll(){
        this.confirm(bbn._('Are you sure you want to delete these preferences?'), () => {
          this.post(appui.plugins['appui-option'] + '/actions/preferences/remove', {
            ids: bbn.fn.map(this.source[this.isMine ? 'prefs' : 'uprefs'], p => {
              return p.id;
            })
          } , d => {
            if ( d.success ){
              this.source[this.isMine ? 'prefs' : 'uprefs'].splice(0)
              this.$refs.table.updateData()
              appui.success(bbn._('Deleted'))
            }
            else {
              appui.error(d);
            }
          });
        })
      }
    },
    components: {
      form: {
        mixins: [bbn.cp.mixins.basic],
        props: ['source'],
        template: `
<bbn-form :action="root + 'actions/preferences/' + (source.id ? 'edit' : 'add')"
          :source="formData"
          :data="{
            id: source.id || undefined,
            id_option: source.id_option
          }"
          @success="afterSubmit"
>
  <div style="height: 500px">
    <bbn-json-editor bbn-model="formData"></bbn-json-editor>
  </div>
</bbn-form>
        `,
        data(){
          let fd = bbn.fn.extend(true, {}, this.source);
          delete fd.id
          delete fd.id_option
          return {
            root: appui.plugins['appui-option'] + '/',
            formData: fd
          }
        },
        methods: {
          afterSubmit(d){
            let tab = this.closest('bbn-container').find('appui-option-preferences')
            if ( tab && d.success && (d.prefs !== undefined) ){
              this.$set(tab.source, 'prefs', d.prefs)
              this.$nextTick(() => {
                tab.$refs.table.updateData()
                appui.success()
              })
            }
            else {
              appui.error(d);
            }
          }
        }
      },
      bits: {
        mixins: [bbn.cp.mixins.basic],
        props: ['source'],
        template: `
<div class="bbn-w-100">
  <h5>` + bbn._('Preference bits') + `</h5>
  <bbn-json-editor bbn-model="bits" bbn-if="ready" readonly="readonly"></bbn-json-editor>
  <h5>` + bbn._('Preference value') + `</h5>
  <bbn-json-editor bbn-model="source.value" bbn-if="ready" readonly="readonly"></bbn-json-editor>
        `,
        data(){
          return {
            bits: [],
            ready: false
          }
        },
        created(){
          this.post(appui.plugins['appui-option'] + '/data/preferences/bits', {id: this.source.id}, d => {
            if ( d.success ){
              this.bits = d.bits
              this.$nextTick(() => {
                this.ready = true
              })
            }
          })
        }
      },
      toolbar: {
        template: `
<div class="bbn-flex-width bbn-header bbn-vmiddle bbn-h-100 bbn-spadding">
  <div class="bbn-flex-fill">
    <bbn-button icon="nf nf-fa-plus"
                label="` + bbn._('Add') + `"
                @click="add"
    ></bbn-button>  
  </div>
  <bbn-button icon="nf nf-fa-trash"
              label="` + bbn._('Delete all') + `"
              @click="removeAll"
  ></bbn-button>
</div>
        `,
        methods: {
          add(){
            this.closest('appui-option-preferences').add()
          },
          removeAll(){
            this.closest('appui-option-preferences').removeAll()
          }
        }
      }
    }
  };
})();