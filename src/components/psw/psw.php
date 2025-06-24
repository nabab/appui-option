<!-- HTML Document -->
<div>
  <div class="bbn-padding bbn-centered-block">
    <div class="bbn-vlmargin bbn-card">
      <bbn-form :action="url"
                :source="currentSource"
                @success="onSuccess"
                :validation="beforeSend"
                :scrollable="false"
                mode="big">
        <h4 class="bbn-padding">
          <?= _("You can associate a password with an option. It will be kept safely in an encrypted way") ?>
        </h4>
        <div class="bbn-grid-fields bbn-padding">
          <div class="bbn-label">
            <label class="bbn-xl"><?= _('Password') ?></label>
            <i class="nf nf-md-key bbn-xl bbn-smargin"/>
          </div>
          <bbn-input readonly
                    bbn-model='password'
                    class="bbn-wide"
                    :type="inputType"
                    :buttonRight="'nf nf-fa-eye' + (inputType === 'text' ? '_slash' : '')"
                    @clickrightbutton="inputType = inputType === 'text' ? 'password' : 'text'"/>

          <bbn-button icon="nf nf-md-key_plus"
                      :title="_('Change Passwod')"
                      @click="changePsw"
                      :label="_('New password')"/>
          <bbn-input bbn-if="showInput"
                    class="bbn-wide"
                    bbn-model='newPassword'
                    :placeholder="_('Insert new passwod')"/>
        </div>
      </bbn-form>
    </div>
  </div>
</div>