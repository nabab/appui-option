<div class="bbn-nowrap bbn-xs bbn-w-100">
  <bbn-scroll axis="x"
              invisible="x">
    <div class="bbn-nowrap">
      <div bbn-for="(o, i) in options"
           class="bbn-iblock"
           style="white-space: collapse">
        <span bbn-if="i"
             class="nf nf-fa-angle_right bbn-hxsmargin"/>
        <a :href="root + 'tree/' + o.id">
          <span bbn-if="o.text"
                bbn-text="o.text"/>
          <span bbn-elseif="o.alias?.text"
                class="bbn-i"
                bbn-text="o.alias?.text"/>
          <span bbn-else><?= _("No Text") ?></span> 
    
          <span bbn-if="o.code"
                bbn-text="'(' + o.code + ')'"
                style="opacity: 0.6"/>
          <span bbn-elseif="o.alias?.code"
                class="bbn-i"
                style="opacity: 0.6"
                bbn-text="'(' + o.alias?.code + ')'"/>
        </a>
      </div>
    </div>
  </bbn-scroll>
</div>
