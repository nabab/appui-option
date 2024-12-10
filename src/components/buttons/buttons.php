<div class="bbn-button-group" style="width: auto">
  <bbn-button icon="nf nf-fa-link"
              @click="linkOption"
              :text="'<?= _('Go to') ?> ' + source.text"
              :notext="true"/>
  <bbn-button icon="nf nf-fa-history"
              @click="deleteCache"
              text="<?= _('Delete cache option') ?>"
              :notext="true"/>
  <bbn-button icon="nf nf-fa-trash_o"
              @click=" removeOpt"
              title="<?= _('Remove option from db') ?>"
              text="<?= _('Remove') ?>"
              :notext="true"/>
  <bbn-button icon="nf nf-fa-trash"
              @click="removeOptHistory"
              title="<?= _('Remove option\'s history') ?>"
              bbn-if="isAdmin"
              text="<?= _('Remove history') ?>"
              class="bbn-bg-red"
              :notext="true"/>
</div>
