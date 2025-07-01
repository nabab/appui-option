<div class="bbn-button-group" style="width: auto">
  <bbn-button icon="nf nf-cod-copy"
              @click="copyId"
              :label="_('Copy ID %s', source.option.id)"
              :notext="true"/>
  <bbn-button icon="nf nf-fa-link"
              @click="linkOption"
              bbn-if="source.parentCfg.allow_children"
              :label="'<?= _('Go to') ?> ' + source.option.text"
              :notext="true"/>
  <bbn-button icon="nf nf-fa-history"
              @click="deleteCache"
              label="<?= _('Delete cache option') ?>"
              :notext="true"/>
  <bbn-button icon="nf nf-fa-trash_o"
              @click=" removeOpt"
              title="<?= _('Remove option from db') ?>"
              label="<?= _('Remove') ?>"
              :notext="true"/>
  <bbn-button icon="nf nf-fa-trash"
              @click="removeOptHistory"
              title="<?= _('Remove option\'s history') ?>"
              bbn-if="isAdmin"
              label="<?= _('Remove history') ?>"
              class="bbn-bg-red"
              :notext="true"/>
</div>
