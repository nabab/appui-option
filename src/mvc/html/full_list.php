<bbn-table :source="source.root + 'full_list'"
           :pageable="true"
           :info="true"
           :filterable="true"
           :showable="true"
           :sortable="true"
           :order="[{field: 'text', dir: 'ASC'}]"
           :limit="50"
>
  <bbns-column label="UID"
               field="id"               
               :showable="true"
               cls="bbn-c"
  ></bbns-column>
  <bbns-column label="<?= _("Text") ?>"
               field="text"               
               :showable="true"
               width="250"
               cls="bbn-c"               
  ></bbns-column>
  <bbns-column label="<?= _("Code") ?>"
               field="code"                            
               :showable="true"               
               cls="bbn-c"               
  ></bbns-column>
  <bbns-column label="<?= _("ID Alias") ?>"
               field="id_alias"               
               :showable="true"               
  ></bbns-column>
  <bbns-column label="<?= _("Parent") ?>"
               field="parent"               
               :showable="true"
               :filterable="false"               
               width="250"
               cls="bbn-c"               
  ></bbns-column>  
</bbn-table>