// Javascript Document
(() => {
  return {
    props: ['source'],
    data() {
      const root = appui.plugins['appui-option'] + '/';
      return {
        ready: false,
        showInput: false,
        root,
        url: root + 'actions/store_psw',
        password: '',
        newPassword: '',
        inputType: 'password'
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
        return this.tab ? (this.tab.find('appui-option-list') || null) : null
      },
      tree(){
        return this.closest('appui-option-option') || null
      },
      currentSource(){
        return {
          id_option: this.source.option.id,
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
      bbn.fn.post( this.root + 'data/get_psw',{
        id_option: this.source.option.id
      }, d =>{
        if ( d.success ){
          this.password = d.psw;
        }
      })
      this.ready = true;
    }
  }
})();
