<!-- HTML Document -->
<div class="bbn-block bbn-lmargin bbn-lpadding bbn-border bbn-radius">
  <div>
    <div class="bbn-iblock bbn-s bbn-hlmargin">
      <bbn-button @click="checkAllGroups"
                  title="<?= _("Check all") ?>"
                  style="padding: 0 4px"
                  icon="nf nf-fa-check_square"/>
      <bbn-button @click="uncheckAllGroups"
                  title="<?= _("Uncheck all") ?>"
                  style="padding: 0 4px"
                  icon="nf nf-fa-square"/>
    </div>
  </div>
  <div>
    <ul style="list-style: none">
      <li bbn-for="g in groups">
        <bbn-checkbox bbn-if="!!source.public"
                      :disabled="true"
                      :checked="true"
                      :label="g.nom || g.group"
                      :key="g.id+'a'"/>
        <bbn-checkbox bbn-else
                      @click="setGroupPerm(g)"
                      bbn-model="source['group' + g.id]"
                      :label="g.nom || g.group"
                      :novalue="false"
                      :value="true"
                      :key="g.id+'b'"/>
      </li>
    </ul>
  </div>
</div>
