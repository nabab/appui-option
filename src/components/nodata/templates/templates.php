<div class="bbn-block bbn-textbox">
  <div class="bbn-padded bbn-c">
    <p class="bbn-lg">
      <?= _("There is no template yet!") ?><br><br>
      <bbn-button class="bbn-primary"
                  @click="onCreate"><?= _("Create a new template") ?></bbn-button>
      <br><br>
      <?= _("Or") ?><br><br>
      <bbn-button class="bbn-secondary"
                  @click="onImport"><?= _("Import a template") ?></bbn-button>
      <br>
    </p>
  </div>
</div>

