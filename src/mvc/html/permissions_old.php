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
        <bbn-toolbar class="bbn-permissions-toolbar bbn-widget" style="height: 100%">
          <div>
            <bbn-button class="bbn-option-refresh-permissions"
                        icon="nf nf-fa-refresh"
                        title="<?= _("Refresh all permissions") ?>"
                        @click="refreshPermissions"
            ></bbn-button>
          </div>
        </bbn-toolbar>
      </bbn-pane>
      <bbn-pane :collapsible="false"
                :resizable="false">
        <!-- Tree -->
        <bbn-tree :source="source.root + 'permissions'"
                  uid="id"
                  :root="source.cat"
                  :map="treeMapper"
                  @select="permissionSelect"
                  ref="permsList"
                  class="bbn-permissions-list"
        ></bbn-tree>
      </bbn-pane>
    </bbn-splitter>
  </bbn-pane>
  <bbn-pane :collapsible="true" :resizable="true">
    <div class="bbn-permissions-form bbn-nopadding bbn-100">
      <div class="bbn-full-screen">
        <div class="bbn-flex-height">
          <div bbn-if="selected" class="bbn-header bbn-border bbn-c bbn-middle" style="height: 39px; font-size: large">
            <b><?= _("Permission for") ?>
              <a :href="selected.path"
                  bbn-text="selected.text"
              ></a>
            </b>
          </div>
          <h2 bbn-else><?= _("Select an item...") ?></h2>
          <transition name="expand"
                      @enter="enter"
                      @after-enter="afterEnter"
                      @leave="leave">
            <div bbn-if="selected" class="bbn-flex-fill bbn-margin">
              <bbn-scroll>
                <div class="bbn-block bbn-w-100 bbn-widget bbn-no-border">
                  <div :class="['bbn-header', 'bbn-c', 'bbn-p', 'bbn-b','bbn-padding', {'header-no-border': !sections.configuration}]"
                       @click="openSection('configuration')"
                  >
                    <span style="position: absolute; left: 10px; top: 0;height:100%" class="bbn-middle">
                      <i :class="{
                          'nf nf-fa-angle_up': sections.configuration,
                          'nf nf-fa-angle_down': !sections.configuration
                        }"
                      ></i>
                    </span>
                    <?= _("Configuration") ?>
                  </div>
                  <transition name="expand">
                    <div bbn-show="sections.configuration" class="bbn-block bbn-w-100 bbn-padding bbn-widget bbn-no-border">
                      <bbn-form :source="selected"
                                :buttons="[]"
                                :fixedFooter="false"
                                ref="form_cfg"
                      >
                        <div class="bbn-grid-fields">
                          <div><?= _('Type') ?></div>
                          <i class="fa" :class="'fa-' + (selected.type ? selected.type : 'key')" style="font-size: large"></i>

                          <div><?= _('Code') ?></div>
                          <div bbn-if="!selected.is_perm"
                               bbn-text="selected.code"
                          ></div>
                          <bbn-input bbn-else bbn-model="selected.code" maxlength="255"></bbn-input>

                          <div><?= _('Text') ?></div>
                          <bbn-input bbn-model="selected.text" maxlength="255"
                                     @keydown.enter.prevent="submitConf"
                                     class="bbn-w-100"
                          ></bbn-input>

                          <div><?= _('Help') ?></div>
                          <bbn-markdown bbn-model="selected.help"></bbn-markdown>


                          <div><?= _('Public') ?></div>
                          <bbn-checkbox bbn-model="selected.public"></bbn-checkbox>

                          <div><?= _('Cascade') ?></div>
                          <bbn-checkbox bbn-model="selected.cascade"></bbn-checkbox>

                          <div class="bbn-grid-full bbn-margin">
                            <bbn-button @click="submitConf" icon="nf nf-fa-save"><?= _("Save") ?></bbn-button>
                            <bbn-button bbn-if="!selected.exist" @click="delPerm" icon="nf nf-fa-trash"><?= _("Delete") ?></bbn-button>
                          </div>
                        </div>
                      </bbn-form>
                    </div>
                  </transition>
                </div>
                <div class="bbn-block bbn-w-100 bbn-widget bbn-no-border">
                  <div :class="['bbn-header', 'bbn-c', 'bbn-p', 'bbn-b', 'bbn-padding', {'header-no-border': !sections.newPermission}]"
                       @click="openSection('newPermission')"
                  >
                    <span style="position: absolute; left: 10px; top: 0;height:100%" class="bbn-middle">
                      <i :class="{
                          'nf nf-fa-angle_up': sections.newPermission,
                          'nf nf-fa-angle_down': !sections.newPermission
                          }"
                      ></i>
                    </span>
                    <?= _("New permission (under this one)") ?>
                  </div>
                  <transition name="expand">
                    <div bbn-show="sections.newPermission" class="bbn-block bbn-w-100 bbn-padding bbn-widget bbn-no-border">
                      <bbn-form class="bbn-w-100"
                                :buttons="[]"
                                :fixedFooter="false"
                                :source="newPerm"
                                ref="form_new"
                      >
                        <div class="bbn-grid-fields">
                          <div><?= _('Code') ?></div>
                          <bbn-input bbn-model="newPerm.code"
                                     required="required"
                                     class="bbn-w-100"
                                     @keydown.enter.prevent="submitNew"
                          ></bbn-input>

                          <div><?= _('Text') ?></div>
                          <bbn-input bbn-model="newPerm.text"
                                     class="bbn-w-100"
                                     required="required"
                                     @keydown.enter.prevent="submitNew"
                          ></bbn-input>

                          <div><?= _('Help') ?></div>
                          <bbn-markdown bbn-model="newPerm.help"></bbn-markdown>

                          <div class="bbn-grid-full bbn-margin">
                            <bbn-button @click="submitNew" icon="nf nf-fa-save"><?= _("Save") ?></bbn-button>
                          </div>
                        </div>
                      </bbn-form>
                    </div>
                  </transition>
                </div>
                <div class="bbn-permissions-groups bbn-block bbn-w-100 bbn-widget bbn-no-border">
                  <div :class="['bbn-header', 'bbn-c', 'bbn-p', 'bbn-b', 'bbn-padding',{'header-no-border': !sections.groups}]"
                       @click="openSection('groups')"
                  >
                    <span style="position: absolute; left: 10px; top: 0;height:100%" class="bbn-middle">
                      <i :class="{
                            'nf nf-fa-angle_up': sections.groups,
                            'nf nf-fa-angle_down': !sections.groups
                          }"
                      ></i>
                    </span>
                    <div class="bbn-iblock"><?= _("Groups") ?></div>
                    <div bbn-if="sections.groups" class="bbn-iblock bbn-s bbn-hlmargin">
                      <bbn-button @click="checkAllGroups"
                                  title="<?= _("Check all") ?>"
                                  style="padding: 0 4px"
                                  icon="nf nf-fa-check_square"
                      ></bbn-button>
                      <bbn-button @click="uncheckAllGroups"
                                  title="<?= _("Uncheck all") ?>"
                                  style="padding: 0 4px"
                                  icon="nf nf-fa-square"
                      ></bbn-button>
                    </div>
                  </div>
                  <transition name="expand">
                    <div bbn-show="sections.groups" class="bbn-padding">
                      <ul style="list-style: none">
                          <li bbn-for="g in source.groups">
                            <bbn-checkbox bbn-if="!!selected.public"
                                          :disabled="true"
                                          :checked="true"
                                          :label="g.nom || g.group"
                                          :key="g.id+'a'"
                            ></bbn-checkbox>
                            <bbn-checkbox bbn-else
                                          @click="setGroupPerm(g)"
                                          bbn-model="selected['group' + g.id]"
                                          :label="g.nom || g.group"
                                          :novalue="false"
                                          :key="g.id+'b'"
                            ></bbn-checkbox>
                          </li>
                      </ul>
                    </div>
                  </transition>
                </div>
                <div class="bbn-permissions-users bbn-block bbn-w-100 bbn-widget bbn-no-border">
                  <div :class="['bbn-header', 'bbn-c', 'bbn-p', 'bbn-b', 'bbn-padding', {'header-no-border': !sections.users}]"
                       @click="openSection('users')"
                  >
                    <span style="position: absolute; left: 10px; top: 0;height:100%" class="bbn-middle">
                      <i :class="{
                            'nf nf-fa-angle_up': sections.users,
                            'nf nf-fa-angle_down': !sections.users
                          }"
                      ></i>
                    </span>
                    <?= _('Users') ?>
                  </div>
                  <transition name="expand">
                    <div bbn-show="sections.users" class="bbn-padding">
                      <ul style="list-style: none">
                          <li bbn-for="u in source.users">
                            <bbn-checkbox bbn-if="!!selected.public || !!selected['group' + u.id_group]"
                                          :disabled="true"
                                          :checked="true"
                                          :label="u.nom"
                                          :key="u.id+'a'"
                            ></bbn-checkbox>
                            <bbn-checkbox bbn-else
                                          bbn-model="selected['user' + u.id]"
                                          @click="setUserPerm(u)"
                                          :label="u.nom || u.username"
                                          :novalue="false"
                                          :key="u.id+'b'"
                            ></bbn-checkbox>
                          </li>
                      </ul>
                    </div>
                  </transition>
                </div>
              </bbn-scroll>
            </div>
          </transition>
        </div>
      </div>
    </div>
  </bbn-pane>
</bbn-splitter>