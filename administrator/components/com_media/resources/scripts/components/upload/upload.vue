<template>
    <media-modal v-if="$store.state.showUploadMediaModal" :className="'joomla-upload-modal'" :size="'sm'" @close="close()" :showClose="false" label-element="uploadMediaTitle">
        <div slot="header">
            <a href="#" @click="close()" class="joomla-upload-modal-cancel-btn"><i class="fas fa-times"></i></a>
        </div>
        <div slot="body">
            <div class="joomla-recent-uploaded-media" v-if="uploadedItems.length > 0">
                <div class="joomla-recent-uploaded-media-item" v-for="image in uploadedItems">
                    <div class="joomla-recent-upload-file">
                        <span :class="image.mediaClass"></span>
                        <span class="joomla-upload-file-name">{{stringTruncate(image.name, 18, 6, 22)}}</span>
                    </div>
                    <div class="joomla-progress-container" v-if="image.error === '' && !image.success">
                        <div class="joomla-progress">
                            <div class="joomla-progress-bar" :style="{width:image.progress+'%'}"></div>
                        </div>
                        <span>{{image.progress}}%</span>
                    </div>
                    <div class="joomla-media-upload-error" v-if="image.error && image.error!==''">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span> {{ (image.error_message && image.error_message !== '') ? translate(image.error_message) : translate(getErrorMessage(image))}} </span>
                    </div>
                    <div class="joomla-upload-complete" v-if="(!image.error || image.error==='') && image.success === true">
                        <i class="fa fa-check-circle"></i>
                        <span> Done </span>
                    </div>
                    <a v-if="!image.success" class="joomla-file-upload-cancel-btn" href="#" @click="onCancelUploadProcess(image, $event)"> Cancel </a>
                    <a v-if="image.success" class="joomla-file-remove-btn" href="#" @click="onRemoveFile(image, $event)"><i class="fas fa-times-circle"></i> Remove </a>
                </div>
            </div>
            <div 
                class="joomla-media-upload-drag-container"
                @dragenter="onDragEnter"
                @drop="onDrop"
                @dragover="onDragOver"
                @dragleave="onDragLeave"
                >
                <div class="joomla-upload-img" v-if="uploadedItems.length < 1"></div>
                <button class="btn btn-primary" @click="chooseFiles"> Upload File </button>
                <p class="joomla-upload-tips"> or drop files to upload (max 30MB) </p>
            </div>
            <input type="file" class="hidden"
                :name="name"
                :multiple="multiple"
                :accept="accept"
                @change="upload_file"
                ref="fileInput">
        </div>
        <div slot="footer">
            <button class="btn btn-secondary" @click="close()">{{ translate('JCANCEL') }}</button>
        </div>
    </media-modal>
</template>
<script>
    import * as types from "./../../store/mutation-types";
    export default {
        name: 'media-upload',
        props: {
            accept: {
                type: String,
            },
            extensions: {
                default: () => [],
            },
            name: {
                type: String,
                default: 'file',
            },
            multiple: {
                type: Boolean,
                default: true,
            }
        },
        computed: {
            isLoading() {
                return this.$store.state.isLoading;
            },
            uploadedItems(){
                return this.$store.state.lastUploadedFile;
            }
        },
        methods: {
            onCancelUploadProcess(item, event) {
                const index = this.$store.state.lastUploadedFile.findIndex( file => file.name.toLowerCase() === item.name.toLowerCase() )
                const {xhrRequest} = this.$store.state.lastUploadedFile[index]
                if (typeof xhrRequest !== 'undefined' && xhrRequest !== null) { 
                    xhrRequest.abort();
                    this.$store.commit(types.REMOVE_LAST_UPLOADED_FILES, { fileName: item.name });
                }
            },
            onRemoveFile(item, event) {
                this.$store.commit(types.UNSELECT_ALL_BROWSER_ITEMS);
	            this.$store.commit(types.SELECT_BROWSER_ITEM, item);
                this.$store.commit(types.SHOW_CONFIRM_DELETE_MODAL);
            },
            /* Close modal */
            close() {
                this.$store.commit(types.HIDE_UPLOAD_MEDIA_MODAL);
                this.$store.commit(types.REMOVE_LAST_UPLOADED_FILES, { empty: true });
            },
            /* Open the choose-file dialog */
            chooseFiles(e) {
                this.$refs['fileInput'].click();
            },
            /* Upload files */
            upload_file(e) {
                e.preventDefault();
                const files = e.target.files;
                // Loop through array of files and upload each file
                for (let file of files) {
                    this.upload(file);
                }
            },
             // Listeners for drag and drop
            // Fix for Chrome
            onDragEnter(e) {
                e.stopPropagation();
                return false;
            },


            // Notify user when file is over the drop area
            onDragOver(e) {
                e.preventDefault();
                document.querySelector('.joomla-media-upload-drag-container').classList.add('active');
                return false;
            },

            /* Upload files */
            upload(file) {
                // Create a new file reader instance
                let reader = new FileReader();

                // Add the on load callback
                reader.onload = (progressEvent) => {
                    const result = progressEvent.target.result,
                        extension = file.name.split('.').pop().toLowerCase(),
                        mediaClass = this.getMediaClass(extension),
                        splitIndex = result.indexOf('base64') + 7,
                        content = result.slice(splitIndex, result.length),
                        payload = {src:result, name:file.name, success: false, progress: 0, xhrRequest: null, extension, mediaClass };
                        payload.name = payload.name.replace(/[\])}[{(]/g, '');
                        
                    // Add file to the upload queue
                    this.$store.commit(types.SET_LAST_UPLOADED_FILES, payload )
                    // Dispatch file for Upload process
                    this.$store.dispatch('uploadFile', {
                        name: file.name,
                        parent: this.$store.state.selectedDirectory,
                        content: content,
                    });
                };

                reader.readAsDataURL(file);
            },

            // Logic for the dropped file
            onDrop(e) {
                e.preventDefault();

                // Loop through array of files and upload each file
                if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                    for (let i = 0, f; f = e.dataTransfer.files[i]; i++) {
                        document.querySelector('.joomla-media-upload-drag-container').classList.remove('active');
                        this.upload(f);
                    }
                }
                document.querySelector('.joomla-media-upload-drag-container').classList.remove('active');
            },

            // Reset the drop area border
            onDragLeave(e) {
                e.stopPropagation();
                e.preventDefault();
                document.querySelector('.joomla-media-upload-drag-container').classList.remove('active');
                return false;
            },
            
            isExtensionMatched( extensionList, extension ){
                let founded = false;
                for (const ext of extensionList) {
                    if (ext.toLowerCase() === extension.toLowerCase()) {founded = true; break; }
                }
                return founded;
            },

            getMediaClass(extension){
                const imageExtension = ['jpg', 'jpeg', 'png', 'gif', 'mp4'];
                const mediaExtension = ['mp4','mp3'];
                const docExtension = ['pdf','docs','zip'];
                if (this.isExtensionMatched(imageExtension, extension)) { 
                    return 'joomla-image-item';
                }
                if (this.isExtensionMatched(mediaExtension, extension)) { 
                    return 'joomla-media-item';
                }
                if (this.isExtensionMatched(docExtension, extension)) { 
                    return 'joomla-docs-item';
                }
                return 'joomla-file-item';
            },
            stringTruncate(txt, start, end, maxLength) {
                const txt_trim = txt.split('.'),
                    ext = txt_trim.pop(),
                    _txt = txt_trim.join('');
                if( _txt.length > maxLength ){
                    const _start = _txt.substring(0, start);
                    const _end = _txt.substring(_txt.length - end, _txt.length);
                    return _start+'...'+_end+'.'+ext;
                }
                return txt; 
            },
            getErrorMessage(item){
                if( item.error === '')
                    return ''
                let error = ''
                switch (item.error) {
                    case 409:
                        error = 'COM_MEDIA_FILE_EXISTS_AND_OVERRIDE';
                        break;
                    case 404:
                        error = 'COM_MEDIA_ERROR_NOT_FOUND';
                        break;
                    case 401:
                        error = 'COM_MEDIA_ERROR_NOT_AUTHENTICATED';
                        break;
                    case 403:
                        error = 'COM_MEDIA_ERROR_NOT_AUTHORIZED';
                        break;
                    case 500:
                        error = 'COM_MEDIA_SERVER_ERROR';
                        break;
                    default:
                        error = 'COM_MEDIA_ERROR';
                }
                return error;
            }

        },
        created() {
            // Listen to the toolbar upload click event
            MediaManager.Event.listen('onClickUpload', () => this.$store.commit(types.SHOW_UPLOAD_MEDIA_MODAL));
        },
    }
</script>