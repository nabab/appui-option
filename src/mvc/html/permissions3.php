<!-- HTML Document -->
<bbn-splitter orientation="horizontal" 
              :collapsible="true" 
              :resizable="true"
>
  <bbn-pane :collapsible="true"
            :size="350"
            :resizable="true">
    <bbn-splitter orientation="vertical">
      <bbn-pane :size="38"
                :collapsible="false"
                :resizable="false">
        <!-- Toolbar -->
        <bbn-toolbar class="bbn-permissions-toolbar">
          <div>
            <bbn-button class="bbn-option-refresh-permissions"
                        icon="nf nf-fa-sync"
                        :title="source.lng.refresh_all_permissions"
                        @click="refreshPermissions"
            ></bbn-button>
          </div>
        </bbn-toolbar>
      </bbn-pane>
      <bbn-pane :collapsible="false"
                :resizable="false">
        <!-- Tree -->
        <bbn-tree :source="source.root + 'permissions3'"
                  class="bbn-permissions-list"          
                  uid="id"
                  :root="source.cat"
                  :map="treeMapper"
                  @select="permissionSelect"
                  ref="permsList"
        ></bbn-tree>
      </bbn-pane>
    </bbn-splitter>
  </bbn-pane>
  
  <bbn-pane :collapsible="true" :resizable="true">
    <div v-if="selected" class="bbn-header k-shadow bbn-c bbn-middle" style="height: 39px; font-size: large">
      <b><?=_("Permission for")?>
        <a :href="selected.path"
            v-text="selected.text"
        ></a>
      </b>
    </div>
    <h2 class="bbn-c" v-else><?=_("Select an item...")?></h2>
    <div v-if="selected" class="bbn-padded panel-container">
      <bbn-scroll>
        <bbn-panelbar :items="items"
                       @select="openSection"
                       :opened="0"
        ></bbn-panelbar>
        </bbn-scroll>  
      </div>
    
  </bbn-pane>
</bbn-splitter>

<script type="text/html" id="configuration">
  <div v-if="sections.configuration" class="" ref="configuration">
    <bbn-form :source="selected"
              class="bbn-block"
              :buttons="[]"
              :fixedFooter="false"
              ref="form_cfg"
    >
      <div class="bbn-grid-fields">
        <div><?=_('Type')?></div>
        <i class="bbn-l fa" :class="'fa-' + (selected.type ? selected.type : 'key')" style="font-size: large"></i>

        <div><?=_('Code')?></div>
        <div v-if="!selected.is_perm"
              v-text="selected.code"
        ></div>
        <bbn-input v-else v-model="selected.code" maxlength="255"></bbn-input>

        <div><?=_('Text')?></div>
        <bbn-input v-model="selected.text" maxlength="255"
                    @keydown.enter.prevent="submitConf"
                    class="bbn-w-100"
        ></bbn-input>

        <div><?=_('Help')?></div>
        <bbn-markdown v-model="selected.help"></bbn-markdown>


        <div><?=_('Public')?></div>
        <bbn-checkbox class="bbn-l" v-model="selected.public"></bbn-checkbox>

        <div><?=_('Cascade')?></div>
        <bbn-checkbox class="bbn-l" v-model="selected.cascade"></bbn-checkbox>

        <div class="bbn-grid-full bbn-margin bbn-l">
          <bbn-button @click="submitConf" icon="nf nf-fa-save"><?=_("Save")?></bbn-button>
          <bbn-button v-if="!selected.exist" @click="delPerm" icon="nf nf-fa-trash"><?=_("Delete")?></bbn-button>
        </div>
      </div>
    </bbn-form>
  </div>
</script>
<script type="text/html" id="new-permission">
  <div v-if="sections.newPermission" class="">
    <bbn-form class="bbn-block"
              :buttons="[]"
              :fixedFooter="false"
              :source="newPerm"
              ref="form_new"
    >
      <div class="bbn-grid-fields">
        <div><?=_('Code')?></div>
        <bbn-input v-model="newPerm.code"
                    required="required"
                    class="bbn-w-100"
                    @keydown.enter.prevent="submitNew"
        ></bbn-input>

        <div><?=_('Text')?></div>
        <bbn-input v-model="newPerm.text"
                    class="bbn-w-100"
                    required="required"
                    @keydown.enter.prevent="submitNew"
        ></bbn-input>

        <div><?=_('Help')?></div>
        <bbn-markdown v-model="newPerm.help"></bbn-markdown>

        <div class="bbn-grid-full bbn-margin bbn-left">
          <bbn-button @click="submitNew" icon="nf nf-fa-save"><?=_("Save")?></bbn-button>
        </div>
      </div>
    </bbn-form>
  </div>
</script>
<script type="text/html" id="groups">
  <div v-if="sections.groups" class="bbn-permissions-groups ">
    <div class="bbn-padded bbn-c">
      <!--div class="bbn-iblock bbn-s">
        <bbn-button @click="checkAllGroups"
                    title="<?=_("Check all")?>"
                    icon="nf nf-fa-check_square"
        ></bbn-button>
        <bbn-button @click="uncheckAllGroups"
                    title="<?=_("Uncheck all")?>"
                    icon="nf nf-fa-square"
        ></bbn-button>
      </div-->
      <ul style="list-style: none" class="bbn-left">
          <li v-for="g in groups">
            <bbn-checkbox v-if="!!selected.public"
                          :disabled="true"
                          :checked="true"
                          :label="g.nom || g.group"
                          :key="g.id+'a'"
            ></bbn-checkbox>
            <bbn-checkbox v-else
                          @click="setGroupPerm(g)"
                          v-model="selected['group' + g.id]"
                          :label="g.nom || g.group"
                          :novalue="false"
                          :key="g.id+'b'"
            ></bbn-checkbox>
          </li>
      </ul>
    </div>
  </div>
</script>
<script type="text/html" id="users">
  <div v-show="sections.users" class="bbn-padded bbn-left">
    <ul style="list-style: none">
        <li v-for="u in users">
          <bbn-checkbox v-if="!!selected.public || !!selected['group' + u.id_group]"
                        :disabled="true"
                        :checked="true"
                        :label="u.nom"
                        :key="u.id+'a'"
          ></bbn-checkbox>
          <bbn-checkbox v-else
                        v-model="selected['user' + u.id]"
                        @click="setUserPerm(u)"
                        :label="u.nom || u.username"
                        :novalue="false"
                        :key="u.id+'b'"
          ></bbn-checkbox>
        </li>
    </ul>
  </div>
</script>