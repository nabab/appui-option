<!-- HTML Document -->
<div class="bbn-lpadded">
  <div class="bbn-w-100 bbn-lpadded bbn-bordered bbn-radius">
    <ul style="list-style: none">
      <li v-for="u in users">
        <bbn-checkbox v-if="!!source.public || !!source['group' + u.id_group]"
                      :disabled="true"
                      :checked="true"
                      :label="u.nom"
                      :key="u.id+'a'"/>
        <bbn-checkbox v-else
                      v-model="source['user' + u.id]"
                      @click="setUserPerm(u)"
                      :label="u.nom || u.username"
                      :novalue="false"
                      :key="u.id+'b'"/>
      </li>
    </ul>
  </div>
</div>
