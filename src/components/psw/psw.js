// Javascript Document
(() => {
  return {
    props: ['source'],
    data() {
      return {
        ready: false,
        showInput: false,
        root: appui.plugins['appui-options'],
        url: appui.plugins['appui-options'] + '/actions/store_psw',
        password: '',
        newPassword: ''
      }
    },
    computed: {
      tab(){
        let tab = this.closest('bbn-container');
        if ( tab ){
          return tab;
        }
        return false
      },
      list(){
        return this.tab ? (this.tab.find('appui-options-list') || null) : null
      },
      tree(){
        return this.closest('appui-options-option') || null
      },
      currentSource(){
        return {
          id_option: this.source.id,
          new_password: this.newPassword
        }
      },
    },
    methods: {
      changePsw(){
        this.$set(this, 'showInput', !this.showInput);
      },
      beforeSend(d){
        if ( this.password === this.newPassword ){
          return false;
        }
        return true;
      },
      onSuccess(){
        this.$set(this, 'password', this.newPassword);
        this.$nextTick(()=>{
          this.$set(this, 'newPassword', '');
        })
        appui.success(bbn._('Password changed successfully'));
      }
    },
    mounted(){
      bbn.fn.post( this.root + '/actions/get_psw',{
        id_option: this.source.id
      }, d =>{
        if ( d.success ){
          this.password = d.psw;
        }
      })
      this.ready = true;
    }
  }
})();
