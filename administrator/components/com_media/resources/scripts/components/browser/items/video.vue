<template>
    <div class="media-browser-image" @dblclick="openPreview()" @mouseleave="hideActions()">
        <div class="media-browser-item-info">
            {{ item.name }} {{ item.filetype }}
        </div>
        <div class="media-browser-item-preview">
            <div class="file-background">
                <div class="file-icon">
                    <span class="fa fa-file-alt"></span>
                </div>
            </div>
        </div>
        <a href="#" class="media-browser-select"
          @click.stop="toggleSelect()"
          :aria-label="translate('COM_MEDIA_TOGGLE_SELECT_ITEM')">
        </a>
        <div class="media-browser-actions" :class="{'active': showActions}">
            <button type="button" class="action-toggle" ref="actionToggle" @keyup.enter="openActions()"
              :aria-label="translate('COM_MEDIA_OPEN_ITEM_ACTIONS')"
               @focus="focused(true)" @blur="focused(false)" @keyup.space="openActions()"
               @keyup.down="openActions()" @keyup.up="openLastActions()">
                <span class="image-browser-action fa fa-ellipsis-h" aria-hidden="true"
                      @click.stop="openActions()"></span>
            </button>
            <div v-if="showActions" class="media-browser-actions-list">
                <ul>
                    <li>
                        <button type="button" class="action-preview" ref="actionPreview" @keyup.enter="openPreview()"
                           :aria-label="translate('COM_MEDIA_ACTION_PREVIEW')" @keyup.space="openPreview()"
                           @focus="focused(true)" @blur="focused(false)" @keyup.esc="hideActions()"
                           @keyup.up="$refs.actionDelete.focus()" @keyup.down="$refs.actionDownload.focus()" @click.stop="openPreview()">
                            <span class="image-browser-action fa fa-search-plus" aria-hidden="true"></span>
                            <span class="image-browser-action-text">{{translate('COM_MEDIA_ACTION_PREVIEW')}}</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="action-download" ref="actionDownload" @keyup.enter="download()"
                           :aria-label="translate('COM_MEDIA_ACTION_DOWNLOAD')" @keyup.space="download()"
                           @focus="focused(true)" @blur="focused(false)" @keyup.esc="hideActions()"
                           @keyup.up="$refs.actionPreview.focus()" @keyup.down="$refs.actionRename.focus()" @click.stop="download()">
                            <span class="image-browser-action fa fa-download" aria-hidden="true"></span>
                            <span class="image-browser-action-text">{{translate('COM_MEDIA_ACTION_DOWNLOAD')}}</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="action-rename" ref="actionRename" @keyup.enter="openRenameModal()"
                          :aria-label="translate('COM_MEDIA_ACTION_RENAME')" @keyup.space="openRenameModal()"
                          @focus="focused(true)" @blur="focused(false)" @keyup.esc="hideActions()"
                          @keyup.up="$refs.actionDownload.focus()" @keyup.down="$refs.actionShare.focus()" @click.stop="openRenameModal()">
                            <span class="image-browser-action fa fa-text-width" aria-hidden="true"></span>
                            <span class="image-browser-action-text">{{translate('COM_MEDIA_ACTION_RENAME')}}</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="action-url" ref="actionShare" @keyup.enter="openShareUrlModal()"
                          :aria-label="translate('COM_MEDIA_ACTION_SHARE')" @keyup.space="openShareUrlModal()"
                          @focus="focused(true)" @blur="focused(false)" @keyup.esc="hideActions()"
                          @keyup.up="$refs.actionRename.focus()" @keyup.down="$refs.actionDelete.focus()" @click.stop="openShareUrlModal()">
                            <span class="image-browser-action fa fa-link" aria-hidden="true"></span>
                            <span class="image-browser-action-text">{{translate('COM_MEDIA_ACTION_SHARE')}}</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="action-delete" ref="actionDelete" @keyup.enter="openConfirmDeleteModal()"
                          :aria-label="translate('COM_MEDIA_ACTION_DELETE')" @keyup.space="openConfirmDeleteModal()"
                           @focus="focused(true)" @blur="focused(false)" @keyup.esc="hideActions()"
                           @keyup.up="$refs.actionShare.focus()" @keyup.down="$refs.actionPreview.focus()" @click.stop="openConfirmDeleteModal()">
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
    import * as types from './../../../store/mutation-types';

    export default {
        name: 'media-browser-item-video',
        data() {
            return {
                showActions: false,
                showInfoPopup: false
            }
        },
        props: ['item', 'focused'],
        methods: {
            /* Preview an item */
            openPreview() {
                this.$store.commit(types.SHOW_PREVIEW_MODAL);
                this.$store.dispatch('getFullContents', this.item);
            },
            /* Preview an item */
            download() {
                this.$store.dispatch('download', this.item);
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
            /* Open modal for share url */
            openShareUrlModal() {
                this.$store.commit(types.SELECT_BROWSER_ITEM, this.item);
                this.$store.commit(types.SHOW_SHARE_MODAL);
            },
            /* Open actions dropdown */
            openActions() {
                this.showActions = true;
                this.$nextTick(() => this.$refs.actionPreview.focus());
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
