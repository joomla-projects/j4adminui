<template>
    <div class="media-browser-item-directory" @mouseleave="hideActions()">
        <div class="media-browser-item-info">
            {{ item.name }}
        </div>
        <div class="media-browser-item-preview"
             @click.stop.prevent="onPreviewDblClick()">
            <div class="file-background">
                <div class="folder-icon">
                    <span class="fa fa-folder"></span>
                </div>
            </div>
        </div>
        <a href="#" class="media-browser-select"
          @click.stop="toggleSelect()"
          :aria-label="translate('COM_MEDIA_TOGGLE_SELECT_ITEM')"
          @focus="focused(true)" @blur="focused(false)">
        </a>
        <div class="media-browser-actions" :class="{'active': showActions}">
            <button class="action-toggle" type="button" ref="actionToggle"
              :aria-label="translate('COM_MEDIA_OPEN_ITEM_ACTIONS')" @keyup.enter="openActions()"
               @focus="focused(true)" @blur="focused(false)" @keyup.space="openActions()"
               @keyup.down="openActions()" @keyup.up="openLastActions()">
                <span class="image-browser-action fa fa-ellipsis-h" aria-hidden="true"
                      @click.stop="openActions()"></span>
            </button>
            <div v-if="showActions" class="media-browser-actions-list">
                <ul>
                    <li>
                        <button type="button" class="action-rename" ref="actionRename" @keyup.enter="openRenameModal()"
                          :aria-label="translate('COM_MEDIA_ACTION_RENAME')" @keyup.space="openRenameModal()"
                          @focus="focused(true)" @blur="focused(false)" @keyup.esc="hideActions()"
                          @keyup.up="$refs.actionDelete.focus()" @keyup.down="$refs.actionDelete.focus()" @click.stop="openRenameModal()">
                            <span class="image-browser-action fa fa-text-width" aria-hidden="true"></span>
                            <span class="image-browser-action-text">{{translate('COM_MEDIA_ACTION_RENAME')}}</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="action-delete" ref="actionDelete" @keyup.enter="openConfirmDeleteModal()"
                          :aria-label="translate('COM_MEDIA_ACTION_DELETE')" @keyup.space="openConfirmDeleteModal()"
                           @focus="focused(true)" @blur="focused(false)" @keyup.esc="hideActions()"
                           @keyup.up="$refs.actionRename.focus()" @keyup.down="$refs.actionRename.focus()" @click.stop="openConfirmDeleteModal()">
                            <span class="image-browser-action fa fa-trash" aria-hidden="true"></span>
                            <span class="image-browser-action-text">{{translate('COM_MEDIA_ACTION_DELETE')}}</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" href="#" class="action-info"
                        @click.stop="showInfoBar()"
                        :aria-label="translate('COM_MEDIA_TOGGLE_INFO')">
                            <span class="image-browser-action fa fa-info" aria-hidden="true"></span>
                            <span class="image-browser-action-text">{{translate('COM_MEDIA_TOGGLE_INFO')}}</span>
                        </button>
                    </li>
                </ul>
            </div>
            <media-infobar-popup v-if="showInfoPopup" :item="item" @hideInfoPopup="hideInfoPopup"></media-infobar-popup>
        </div>
    </div>
</template>
<script>
    import navigable from "../../../mixins/navigable";
    import * as types from './../../../store/mutation-types';

    export default {
        name: 'media-browser-item-directory',
        data() {
            return {
                showActions: false,
                showInfoPopup: false
            }
        },
        props: ['item', 'focused'],
        mixins: [navigable],
        methods: {
            /* Handle the on preview double click event */
            onPreviewDblClick() {
                this.navigateTo(this.item.path);
            },
            /* Opening confirm delete modal */
            openConfirmDeleteModal(){
	            this.$store.commit(types.UNSELECT_ALL_BROWSER_ITEMS);
	            this.$store.commit(types.SELECT_BROWSER_ITEM, this.item);
	            this.$store.commit(types.SHOW_CONFIRM_DELETE_MODAL);
            },
           /* Rename an item */
           openRenameModal() {
	           this.$store.commit(types.SELECT_BROWSER_ITEM, this.item);
	           this.$store.commit(types.SHOW_RENAME_MODAL);
           },
           /* Toggle the item selection */
           toggleSelect() {
	           this.$store.dispatch('toggleBrowserItemSelect', this.item);
           },
           /* Open actions dropdown */
           openActions() {
               this.showActions = true;
               this.$nextTick(() => this.$refs.actionRename.focus());
           },
           /* Open actions dropdown and focus on last element */
           openLastActions() {
               this.showActions = true;
               this.$nextTick(() => this.$refs.actionDelete.focus());
           },
           /* Hide actions dropdown */
           hideActions() {
               this.showActions = false;
               this.$nextTick(() => this.$refs.actionToggle.focus());
           },
            showInfoBar() {
                this.showInfoPopup = true;
            },
            hideInfoPopup() {
                this.showInfoPopup = false;
            }
        }
    }
</script>
