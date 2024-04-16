<!-- HTML Document -->
<bbn-form :action="url"
          :class="['appui-option-form', 'bbn-overlay']"
          :source="currentSource"
          @success="onSuccess"
          :validation="beforeSend"
          :scrollable="true"
>
<div class="bbn-grid-fields bbn-padded">
    <div>
      <label class="bbn-xl"><?= _('Password') ?></label>
      <i class="nf nf-mdi-key bbn-xl bbn-smargin"></i>
    </div>
    <bbn-input readonly
               v-model='password'
               class="bbn-w-50"
               :type="inputType"
               :buttonRight="'nf nf-fa-eye' + (inputType === 'text' ? '_slash' : '')"
               @clickrightbutton="inputType = inputType === 'text' ? 'password' : 'text'"
    ></bbn-input>
    <bbn-button icon="nf nf-mdi-key_plus"
                :title="_('Change Passwod')"
                @click="changePsw"
                :text="_('New password')"
    ></bbn-button>
    <bbn-input v-if="showInput"
              class="bbn-w-50"
              v-model='newPassword'
              :placeholder="_('Insert new passwod')"
    ></bbn-input>
  </div>
</bbn-form>
