<?php
use bbn\Str;
?><div class="bbn-overlay appui-option-list">
	<bbn-table :source="source.options"
             uid="id"
             ref="table"
             :toolbar="getToolbar"
             :editable="!!source.cfg.write"
             :showable="source.is_dev"
             editor="appui-option-form"
             :editor-options="{
               configuration: source.cfg,
             }"
             :filterable="!source.cfg.orderable"
             :pageable="!source.cfg.orderable"
             :search="true"
             :map="mapTable"
						 bbn-if="showTable">
    <bbns-column field="id"
                :width="250"
                :invisible="true"
                label="<?= _('ID') ?>"
                :editable="false"/>
    <bbns-column field="id_parent"
                :invisible="true"
                :showable="false"
                :editable="false"
                label="<?= _('Parent') ?>"
                :default="source.id"/>
    <bbns-column field="source_children"
                :invisible="true"
                :showable="false"
                :editable="false"/>
    <bbns-column bbn-if="!!source.cfg.sortable"
                field="num"
                :width="80"
                label="<i class='nf nf-fa-sort_numeric_asc bbn-xl'></i>"
                flabel="<?= _('Order in the list') ?>"
                :editable="!!source.cfg.sortable"
                type="number"
                cls="bbn-c"
                :component="$options.components['appui-option-list-fixnum']"/>
    <bbns-column bbn-if="!schemaHasField('text') && (!source.cfg.notext || (source.cfg.relations !== 'alias'))"
                field="text"
                label="<?= _('Text') ?>"/>
    <bbns-column bbn-if="!!source.cfg.show_code && !schemaHasField('code')"
                field="code"
                :width="150"
                label="<?= _('Code') ?>"
                :editable="!!source.cfg.show_code"
                cls="bbn-c"/>
    <bbns-column bbn-for="(sch, idx) in schema"
                bbn-bind="sch"
                :type="sch.type === 'string' ? undefined: sch.type"
                :key="idx"
                bbn-if="showSchemaField(sch.field)"/>
    <bbns-column bbn-if="(source.cfg.relations === 'alias') && !schemaHasField('id_alias')"
                field="id_alias"
                :width="!schemaHasField('text') && (!source.cfg.notext || (source.cfg.relations !== 'alias')) ? 150 : null"
                :label="source.cfg.alias_name || '<?= Str::escapeSquotes(_('Alias')) ?>'"
                :render="renderAlias"
                :editable="source.cfg.relations === 'alias'"/>
    <bbns-column field="value"
                :invisible="true"
                label="<?= _('Value') ?>"
                :showable="!!source.cfg.show_value"
                :editable="!!source.cfg.show_value"/>
    <bbns-column bbn-if="!!source.cfg.categories && !schemaHasField('tekname')"
                field="tekname"
                label="<?= _('Variable name') ?>"
                :showable="true"
                :editable="true"
                :width="150"
                cls="bbn-c"/>
    <bbns-column bbn-if="(!!source.cfg.categories || !!source.cfg.show_icon) && !schemaHasField('icon')"
                field="icon"
                label="<?= _('Icon') ?>"
                :showable="true"
                :editable="!!source.cfg.categories || !!source.cfg.show_icon"
                :width="50"
                :render="renderIcon"
                cls="bbn-c"/>
    <bbns-column bbn-if="!!source.cfg.allow_children || !!source.cfg.categories"
                field="num_children"
                label="<i class='nf nf-fa-sitemap bbn-xl'></i>"
                flabel="<?= _('Sub options') ?>"
                :showable="!!source.cfg.allow_children || !!source.cfg.categories"
                :editable="false"
                :width="50"
                cls="bbn-c"
                type="number"/>
    <bbns-column :width="80"
                :buttons="renderButtons"
                label="<?= _('Actions') ?>"
                :showable="false"
                :editable="false"
                cls="bbn-c"/>
  </bbn-table>
</div>