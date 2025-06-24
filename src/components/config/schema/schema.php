<div class="bbn-box bbn-w-100">
  <div class="bbn-header-alt bbn-c bbn-no-border-left bbn-no-border-top bbn-no-border-right bbn-spadding bbn-radius-top-left bbn-radius-top-right bbn-c">
    <span><?= _('Schema') ?></span>
    <div class="bbn-top-right bbn-xspadding">
      <bbn-button icon="nf nf-fa-plus"
                  @click="addItem"
                  :notext="true"
                  :title="_('Add a new field')"/>
    </div>
  </div>
  <ul bbn-if="frozen"
      class="bbn-spadding bbn-no-margin bbn-ul">
    <li bbn-for="sch in currentSchema"
        class="">
      <span bbn-text="sch.label" class="bbn-b bbn-right-smargin"/>
      <span bbn-text="sch.type"/>
    </li>
  </ul>
  <div bbn-else
       class="bbn-w-100 bbn-spadding">
    <div class="bbn-w-100"
         bbn-if="!source?.length"
         bbn-text="_('No data structure is defined')"/>
    <div bbn-else
        class="bbn-w-100">
      <div class="bbn-flex"
          style="flex-flow: column; margin: auto">
        <div bbn-for="(item, i) in source">
          <bbn-button :notext="true"
                      icon="nf nf-fa-edit"
                      @click="editItem(i)"
                      class="bbn-right-xxsmargin"/>
          <bbn-button :notext="true"
                      icon="nf nf-fa-trash"
                      @click="deleteItem(i)"
                      class="bbn-right-xxsmargin"/>
          <div class="bbn-iblock">
            <span bbn-text="source[i].label"/> 
            <span bbn-if="item.field">(<em bbn-text="item.field"/></em>)</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
