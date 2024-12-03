<bbn-table :source="appui.plugins['appui-option'] + '/data/preferences/list'"
           editable="popup"
           :pageable="true"
           :data="{id: source.option.id}"
           :toolbar="$options.components.toolbar"
           ref="table"
           :expander="$options.components.bits">
  <bbns-column :hidden="true"
               :showable="true"
               field="id_option"
               :default="source.option.id"/>
  <bbns-column title="<?= _('ID') ?>"
               field="id"
               :width="isMine ? undefined : '250'"/>
  <bbns-column title="<?= _('Type') ?>"
               :render="renderType"
               :width="100"
               cls="bbn-c"
               v-if="isMine"/>
  <bbns-column title="<?= _('User') ?>"
               field="id_user"
               :source="users"
               cls="bbn-c"
               v-if="!isMine"/>
  <bbns-column title="<?= _('Group') ?>"
               field="id_group"
               :source="groups"
               cls="bbn-c"
               v-if="!isMine"/>
  <bbns-column :buttons="[{
                 icon: 'nf nf-fa-edit',
                 text: '<?= _('Edit') ?>',
                 notext: true,
                 action: edit
               }, {
                 icon: 'nf nf-fa-trash',
                 text: '<?= _('Delete') ?>',
                 notext: true,
                 action: remove
               }]"
               :width="100"
               cls="bbn-c"/>
</bbn-table>
