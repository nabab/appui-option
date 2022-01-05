<!-- HTML Document -->

<div class="bbn-overlay">
  <bbn-splitter orientation="horizontal"
                :resizable="true">

    <bbn-pane :size="300">
      <bbn-tree :source="currentSource"
                ref="tree"
                @select="selectTree"
                v-if="currentSource.length"
                :draggable="true"
                @dragEnd="isDragEnd"
                ></bbn-tree>
    </bbn-pane>
    <bbn-pane>
      <div class="bbn-w-100 bbn-padded">
        <bbn-button class="bbn-w-20 bbn-spadded"
                    @click="resetform"
                    text="<?= _('Create a new link') ?>"></bbn-button>
      </div>

      <div class="bbn-w-100 bbn-left-padded bbn-bottom-spadded bbn-grid-full">
        <label class="bbn-w-100"><?=_("URL")?></label>
        <bbn-input v-model="currentData.url"
                   class="bbn-lpadded bbn-w-40"></bbn-input>
      </div>
      <div class="bbn-w-20 bbn-left-padded bbn-bottom-spadded">
        <label class="bbn-w-100"><?=_("In which file ?")?></label>
        <bbn-dropdown :source="source.parents"
                      v-model="idParent"
                      class="bbn-lpadded"
                      placeholder="Is there a parent ?"
                      > </bbn-dropdown>
      </div>
      <div class="bbn-w-50 bbn-left-padded bbn-bottom-spadded">
        <label class="bbn-l bbn-w-100"><?=_("Title")?></label>
        <bbn-input v-model="currentData.title"
                   placeholder="Name of the URL"></bbn-input>
      </div>
      <div class="bbn-flex-fill bbn-left-padded bbn-bottom-lpadded bbn-w-100">
        <label class="bbn-l bbn-w-100"><?=_("URL's description")?></label>
        <bbn-textarea class="bbn-w-40" v-model="currentData.description"></bbn-textarea>
      </div>
      <div v-if="currentData.cover"
           style="max-height: 500px"
           class="bbn-flex-fill bbn-left-padded bbn-bottom-spadded bbn-w-100">
        <img :src="currentData.cover"
             style="max-width: 300px; max-height: 300px; width: auto; height: auto"
             class="bbn-flex-fill bbn-bottom-spadded bbn-w-100">
        <div class="bbn-flex-fill bbn-bottom-spadded bbn-w-100">
          <bbn-button v-if="currentData.images"
                      @click="showGallery = true"
                      class="bbn-flex-fill bbn-bottom-spadded bbn-w-20"
                      text="change cover picture"></bbn-button>
          <bbn-floater v-if="showGallery"
                       :title="_('Pick a cover picture')"
                       :closable="true"
                       :width="500"
                       :height="500"
                       :scrollable="false"
                       @close="showGallery = false">
            <bbn-gallery :source="currentData.images"
                         class="bbn-overlay"
                         @clickItem="selectImage"
                         :selecting-mode="true"
                         :zoomable="false"
                         :scrollable="true"
                         ></bbn-gallery>
          </bbn-floater>
        </div>
      </div>
      <div>
        <div class="bbn-w-100 bbn-padded" v-if="currentData.id === null">
          <bbn-button class="bbn-padded " text="<?= _('Add Link') ?>" @click="add"></bbn-button>
        </div>
        <div class="bbn-w-100 bbn-lpadded" v-else>
          <bbn-button class="bbn-lpadded " text="<?= _('Modify Link') ?>" @click="modify"></bbn-button>
          <bbn-button class="bbn-lpadded"
                      text="<?= _('Delete Link') ?>"
                      @click="deletePreference"></bbn-button>
        </div>
      </div>

    </bbn-pane>
  </bbn-splitter>
</div>