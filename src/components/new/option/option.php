<div class="bbn-padding bbn-background">
  <div class="bbn-section bbn-c">
    <legend><?= _("Option information") ?></legend>
    <bbn-form :action="root + 'actions/add'"
              :source="source"
              @success="onCreate">
      <h4>
        <?= _("We call the option at the root of your applications categories, because theorically they should hold the different options lists.") ?><br><br>
        <?= _("This form allows you to create new options at the root of your categories.") ?><br><br>
        <?= _("You can also create new options inside existing options by selecting it and going into the list mode.") ?>
      </h4>
      <div class="bbn-grid-fields bbn-c">
        <label><?= _("Option name") ?></label>
        <bbn-input bbn-model="source.text"
                  class="bbn-wide"
                  :required="true"/>

        <label><?= _("Option code") ?></label>
        <bbn-input bbn-model="source.code"
                  class="bbn-wide"
                  :required="true"/>
      </div>
    </bbn-form>
  </div>
</div>
