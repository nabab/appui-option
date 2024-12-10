<div class="bbn-overlay bbn-flex-height">
  <div class="bbn-padding bbn-w-100 bbn-c"
       :style="{
          backgroundColor: closest('bbn-container').closest('bbn-container').currentBcolor,
          color: closest('bbn-container').closest('bbn-container').currentFcolor,
          height: '4rem',
          alignItems: 'center'
        }">
    <div class="bbn-b bbn-c bbn-xl">
      <i :class="closest('bbn-container')?.closest('bbn-container')?.currentIcon"/>
      <?= _("Options Manager") ?>
    </div>
  </div>
  <div class="bbn-flex-fill">
    <div class="bbn-overlay bbn-middle">
      <div class="bbn-card bbn-vmiddle bbn-c bbn-lpadding">
        <div class="bbn-xxxl bbn-c">
          <?= _("Select Option") ?>
        </div>
      </div>
    </div>
  </div>
</div>
