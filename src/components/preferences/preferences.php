<bbn-table :source="appui.plugins['appui-option'] + '/data/preferences/list'"
           editable="popup"
           :pageable="true"
           :data="{id: source.option.id}"
           :toolbar="$options.components.toolbar"
           :showable="true"
           ref="table"
           :expander="$options.components.bits">
  <bbns-column :invisible="true"
               field="id_option"
               :default="source.option.id"/>
  <bbns-column :invisible="true"
               label="<?= _('ID') ?>"
               field="id"
               :width="isMine ? undefined : '250'"/>
  <bbns-column label="<?= _('Type') ?>"
               :render="renderType"
               :width="100"
               cls="bbn-c"
               bbn-if="isMine"/>
  <bbns-column label="<?= _('Text') ?>"
               field="text"
               cls="bbn-c"/>
  <bbns-column label="<?= _('User') ?>"
               field="id_user"
               :source="users"
               cls="bbn-c"
               bbn-if="!isMine"/>
  <bbns-column label="<?= _('Group') ?>"
               field="id_group"
               :source="groups"
               cls="bbn-c"
               bbn-if="!isMine"/>
  <bbns-column :buttons="[{
                 icon: 'nf nf-fa-edit',
                 text: '<?= _('Edit') ?>',
                 notext: true,
                 action: edit
               }, {
                 icon: 'nf nf-fa-trash',
                 text: '<?= _('Delete') ?>',
                 notext: true,
                 action: removeItem
               }]"
               :width="100"
               cls="bbn-c"/>
</bbn-table>
