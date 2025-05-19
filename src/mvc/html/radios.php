<!-- HTML Document -->
<bbn-dashboard>
  <bbn-widget bbn-for="r of radios"
              :label="r.name"
              :key="r.src"
              :buttons-right="[{text: _('Reset stream'), icon: 'nf nf-fa-refresh', action: reset}]"
              :closable="false">
    <bbn-audio :source="r.src"
               @play="onPlay"/>
  </bbn-widget>
  <!--bbn-widget label="Arcade Fire"
              key="ar"
              :buttons-right="[{text: _('Reset stream'), icon: 'nf nf-fa-refresh', action: reset}]"
              :closable="false">
    <bbn-audio source="/02. Pink Elephant.flac"
               @play="onPlay"/>
  </bbn-widget-->
</bbn-dashboard>