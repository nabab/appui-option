<bbn-table :source="source.root +'data/get_categories'"
           ref="table"
           :toolbar="[{
             text: '<?= _('Add') ?>',
             icon: 'nf nf-fa-plus',
             action: 'edit'
           }]"
           :editable="true"
           :sortable="true"
           @saverow="save"
           :order="[{
            field: 'text',
            dir: 'ASC'
           }]"
>
	<bbns-column field="id"
              :hidden="true"
              :editable="false"
  ></bbns-column>
	<bbns-column field="id_parent"
              :hidden="true"
              :editable="false"
              :default="source.id_root"
  ></bbns-column>
	<bbns-column field="text"
              title="<?= _('Categorie\'s name') ?>"
              :required="true"
  ></bbns-column>
	<bbns-column field="code"
              title="<?= _('Code') ?>"
              :width="150"
              :required="true"
              cls="bbn-c"
  ></bbns-column>
	<bbns-column field="icon"
              title="<?= _('Icon') ?>"
              :width="50"
              :render="(e) => {return '<i class=\'bbn-lg ' + (e.icon ? e.icon : 'nf nf-fa-cog') + '\'> </i>'}"
              cls="bbn-c"
  ></bbns-column>
	<bbns-column field="num_children"
              title="<i class='nf nf-fa-sitemap bbn-xl'></i>"
              :editable="false"
              ftitle="<?= _('Number of items') ?>"
              :width="50"
              cls="bbn-c"
  ></bbns-column>
	<bbns-column field="tekname"
              title="<?= _('Access name') ?>"
              :width="150"
              :render="(e) => {return e.tekname ? e.tekname : '-'}"
              cls="bbn-c"
  ></bbns-column>
	<bbns-column :width="150"
              :buttons="getButtons"
              cls="bbn-c"
  ></bbns-column>
</bbn-table>
<!--
 <bbn-table :source="source.options"
           ref="table"
           :toolbar="[{
             text: '<?= _('Add') ?>',
             icon: 'nf nf-fa-plus',
             action: 'edit'
           }]"
           :editable="true"
           :sortable="true"
           @saverow="save"
           :order="[{
            field: 'text',
            dir: 'ASC'
           }]"
>
	<bbns-column field="id"
              :hidden="true"
              :editable="false"
  ></bbns-column>
	<bbns-column field="id_parent"
              :hidden="true"
              :editable="false"
              :default="source.id_root"
  ></bbns-column>
	<bbns-column field="text"
              title="<?= _('Categorie\'s name') ?>"
              :required="true"
  ></bbns-column>
	<bbns-column field="code"
              title="<?= _('Code') ?>"
              :width="150"
              :required="true"
              cls="bbn-c"
  ></bbns-column>
	<bbns-column field="icon"
              title="<?= _('Icon') ?>"
              :width="50"
              :render="(e) => {return '<i class=\'bbn-lg ' + (e.icon ? e.icon : 'nf nf-fa-cog') + '\'> </i>'}"
              cls="bbn-c"
  ></bbns-column>
	<bbns-column field="num_children"
              title="<i class='nf nf-fa-sitemap bbn-xl'></i>"
              :editable="false"
              ftitle="<?= _('Number of items') ?>"
              :width="50"
              cls="bbn-c"
  ></bbns-column>
	<bbns-column field="tekname"
              title="<?= _('Access name') ?>"
              :width="150"
              :render="(e) => {return e.tekname ? e.tekname : '-'}"
              cls="bbn-c"
  ></bbns-column>
	<bbns-column :width="150"
              :buttons="getButtons"
              cls="bbn-c"
  ></bbns-column>
</bbn-table>
-->
