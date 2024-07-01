<div class="bbn-overlay appui-option-list">
	<bbn-table :source="source.options"
             uid="id"
             ref="table"
             :toolbar="getToolbar"
             :editable="!!source.cfg.write"
             :showable="source.is_dev"
             editor="appui-option-form"
             :filterable="!source.cfg.orderable"
             :pageable="!source.cfg.orderable"
             :search="true"
             :map="mapTable"
						 v-if="showTable">
    <bbns-column field="id"
                :width="250"
                :hidden="true"
                title="<?= _('ID') ?>"
                :editable="false"/>
    <bbns-column field="id_parent"
                :hidden="true"
                :showable="false"
                :editable="false"
                title="<?= _('Parent') ?>"
                :default="source.id"/>
    <bbns-column field="source_children"
                :hidden="true"
                :showable="false"
                :editable="false"/>
    <bbns-column v-if="!!source.cfg.sortable"
                field="num"
                :width="80"
                title="<i class='nf nf-fa-sort_numeric_asc bbn-xl'></i>"
                ftitle="<?= _('Order in the list') ?>"
                :editable="!!source.cfg.sortable"
                type="number"
                cls="bbn-c"
                :component="$options.components['appui-option-list-fixnum']"/>
    <bbns-column v-if="!schemaHasField('text') && (!source.cfg.notext || !source.cfg.show_alias)"
                field="text"
                title="<?= _('Text') ?>"/>
    <bbns-column v-if="!!source.cfg.show_code && !schemaHasField('code')"
                field="code"
                :width="150"
                title="<?= _('Code') ?>"
                :editable="!!source.cfg.show_code"
                cls="bbn-c"/>
    <bbns-column v-for="(sch, idx) in schema"
                v-bind="sch"
                :type="sch.type === 'string' ? undefined: sch.type"
                :key="idx"
                v-if="showSchemaField(sch.field)"/>
    <bbns-column v-if="!!source.cfg.show_alias && !schemaHasField('id_alias')"
                field="id_alias"
                :width="!schemaHasField('text') && (!source.cfg.notext || !source.cfg.show_alias) ? 150 : null"
                :title="source.cfg.alias_name || '<?= st::escapeSquotes(_('Alias')) ?>'"
                :render="renderAlias"
                :editable="!!source.cfg.show_alias"/>
    <bbns-column field="value"
                :hidden="true"
                title="<?= _('Value') ?>"
                :showable="!!source.cfg.show_value"
                :editable="!!source.cfg.show_value"/>
    <bbns-column v-if="!!source.cfg.categories && !schemaHasField('tekname')"
                field="tekname"
                title="<?= _('Variable name') ?>"
                :showable="true"
                :editable="true"
                :width="150"
                cls="bbn-c"/>
    <bbns-column v-if="(!!source.cfg.categories || !!source.cfg.show_icon) && !schemaHasField('icon')"
                field="icon"
                title="<?= _('Icon') ?>"
                :showable="true"
                :editable="!!source.cfg.categories || !!source.cfg.show_icon"
                :width="50"
                :render="renderIcon"
                cls="bbn-c"/>
    <bbns-column v-if="!!source.cfg.allow_children || !!source.cfg.categories"
                field="num_children"
                title="<i class='nf nf-fa-sitemap bbn-xl'></i>"
                ftitle="<?= _('Sub options') ?>"
                :showable="!!source.cfg.allow_children || !!source.cfg.categories"
                :editable="false"
                :width="50"
                cls="bbn-c"
                type="number"/>
    <bbns-column :width="180"
                :buttons="renderButtons"
                ftitle="<?= _('Actions') ?>"
                :showable="false"
                :editable="false"
                cls="bbn-c"/>
  </bbn-table>
</div>