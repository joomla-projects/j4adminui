import Vue from "vue";
import Event from './app/Event';
import App from "./components/app.vue";
import TreeItem from "./components/tree/item.vue";
import Toolbar from "./components/toolbar/toolbar.vue";
import Breadcrumb from "./components/breadcrumb/breadcrumb.vue";
import Browser from "./components/browser/browser.vue";
import BrowserItem from "./components/browser/items/item";
import BrowserItemRow from "./components/browser/items/row.vue";
import Modal from "./components/modals/modal.vue";
import CreateFolderModal from "./components/modals/create-folder-modal.vue";
import PreviewModal from "./components/modals/preview-modal.vue";
import RenameModal from "./components/modals/rename-modal.vue";
import ShareModal from "./components/modals/share-modal.vue";
import ConfirmDeleteModal from "./components/modals/confirm-delete-modal.vue";
import Infobar from "./components/infobar/infobar.vue";
import InfobarPopup from "./components/infobar/infobar-popup.vue";
import Upload from "./components/upload/upload.vue";
import UploadPanel from "./components/upload/upload-panel.vue";
import Translate from "./plugins/translate";
import store from './store/store';
import Lock from 'vue-focus-lock';

// Add the plugins
Vue.use(Translate);

// Register the vue components
Vue.component('media-tree-item', TreeItem);
Vue.component('media-toolbar', Toolbar);
Vue.component('media-breadcrumb', Breadcrumb);
Vue.component('media-browser', Browser);
Vue.component('media-browser-item', BrowserItem);
Vue.component('media-browser-item-row', BrowserItemRow);
Vue.component('media-modal', Modal);
Vue.component('media-create-folder-modal', CreateFolderModal);
Vue.component('media-preview-modal', PreviewModal);
Vue.component('media-rename-modal', RenameModal);
Vue.component('media-share-modal', ShareModal);
Vue.component('media-confirm-delete-modal', ConfirmDeleteModal);
Vue.component('media-infobar', Infobar);
Vue.component('media-infobar-popup', InfobarPopup);
Vue.component('media-upload-panel', UploadPanel);
Vue.component('media-upload', Upload);
Vue.component('tab-lock', Lock);

// Register MediaManager namespace
window.MediaManager = window.MediaManager || {};
// Register the media manager event bus
window.MediaManager.Event = new Event();


Vue.directive('click-outside', {
    bind(el, binding, vnode) {
        var vm = vnode.context;
        var callback = binding.value;

        el.clickOutsideEvent = function (event) {
            if (!(el == event.target || el.contains(event.target))) {
                return callback.call(vm, event);
            }
        };
        document.body.addEventListener('click', el.clickOutsideEvent);
    },
    unbind(el) {
        document.body.removeEventListener('click', el.clickOutsideEvent);
    }
});

// Create the root Vue instance
document.addEventListener("DOMContentLoaded",
    (e) => new Vue({
        el: '#com-media',
        store,
        render: h => h(App)
    })
)
