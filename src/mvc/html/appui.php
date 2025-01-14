<bbn-table :source="source.root +'data/get_appui_categories'"
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
              :invisible="true"
              :editable="false"
  ></bbns-column>
	<bbns-column field="id_parent"
              :invisible="true"
              :editable="false"
              :default="source.id_root"
  ></bbns-column>
	<bbns-column field="text"
              label="<?= _('Categorie\'s name') ?>"
              :required="true"
  ></bbns-column>
	<bbns-column field="code"
              label="<?= _('Code') ?>"
              :width="150"
              :required="true"
              cls="bbn-c"
  ></bbns-column>
	<bbns-column field="icon"
              label="<?= _('Icon') ?>"
              :width="50"
              :render="(e) => {return '<i class=\'bbn-lg ' + (e.icon ? e.icon : 'nf nf-fa-cog') + '\'> </i>'}"
              cls="bbn-c"
  ></bbns-column>
	<bbns-column field="num_children"
              label="<i class='nf nf-fa-sitemap bbn-xl'></i>"
              :editable="false"
              flabel="<?= _('Number of items') ?>"
              :width="50"
              cls="bbn-c"
  ></bbns-column>
	<bbns-column field="tekname"
              label="<?= _('Access name') ?>"
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
              :invisible="true"
              :editable="false"
  ></bbns-column>
	<bbns-column field="id_parent"
              :invisible="true"
              :editable="false"
              :default="source.id_root"
  ></bbns-column>
	<bbns-column field="text"
              label="<?= _('Categorie\'s name') ?>"
              :required="true"
  ></bbns-column>
	<bbns-column field="code"
              label="<?= _('Code') ?>"
              :width="150"
              :required="true"
              cls="bbn-c"
  ></bbns-column>
	<bbns-column field="icon"
              label="<?= _('Icon') ?>"
              :width="50"
              :render="(e) => {return '<i class=\'bbn-lg ' + (e.icon ? e.icon : 'nf nf-fa-cog') + '\'> </i>'}"
              cls="bbn-c"
  ></bbns-column>
	<bbns-column field="num_children"
              label="<i class='nf nf-fa-sitemap bbn-xl'></i>"
              :editable="false"
              flabel="<?= _('Number of items') ?>"
              :width="50"
              cls="bbn-c"
  ></bbns-column>
	<bbns-column field="tekname"
              label="<?= _('Access name') ?>"
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
