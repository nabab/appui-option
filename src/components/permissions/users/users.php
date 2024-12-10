<!-- HTML Document -->
<div class="bbn-block bbn-lmargin bbn-lpadding bbn-border bbn-radius">
  <ul style="list-style: none">
    <li bbn-for="u in users">
      <bbn-checkbox bbn-if="!!source.public || !!source['group' + u.id_group]"
                    :disabled="true"
                    :checked="true"
                    :label="u.nom || u.username"
                    :key="u.id+'a'"/>
      <bbn-checkbox bbn-else
                    bbn-model="source['user' + u.id]"
                    @click="setUserPerm(u)"
                    :label="u.nom || u.username"
                    :novalue="false"
                    :key="u.id+'b'"/>
    </li>
  </ul>
</div>
