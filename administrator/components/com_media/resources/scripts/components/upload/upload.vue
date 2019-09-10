<template>
    <media-modal v-if="$store.state.showUploadMediaModal" :className="'joomla-upload-modal'" :size="'sm'" @close="close()" :showClose="false" label-element="uploadMediaTitle">
        <div slot="body">
            <div class="joomla-recent-uploaded-media" v-if="uploadedItems.length > 0">
                <div class="joomla-recent-uploaded-media-item" v-for="image in uploadedItems">
                    <!-- <img :src="image.src" /> -->
                    <span :class="image.mediaClass"></span>
                    <span v-if="image.success"> Success </span>
                    <span>{{ image.progress }}</span>
                    <a v-if="!image.success" href="#" @click="onCancelUploadProcess(image, $event)"> Cancel </a>
                </div>
            </div>
            <div 
                class="joomla-media-upload-drag-container"
                @dragenter="onDragEnter"
                @drop="onDrop"
                @dragover="onDragOver"
                @dragleave="onDragLeave"
                >
                
                <button class="btn btn-success" @click="chooseFiles"> Upload File </button>
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
            },
            fineMe(){
                console.log(this)
                return 'fa-fa';
            }
        },
        methods: {
            onCancelUploadProcess(item, event) {
                const index = this.$store.state.lastUploadedFile.findIndex( file => file.name.toLowerCase() === item.name.toLowerCase() )
                const {xhrRequest} = this.$store.state.lastUploadedFile[index]
                if (typeof xhrRequest !== 'undefined' && xhrRequest !== null) { 
                    xhrRequest.abort();
                    this.$store.commit(types.REMOVE_LAST_UPLOADED_FILES, { file: item });
                }
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

            getMediaClass( extension ){
                const imageExtension = ['jpg', 'jpeg', 'png', 'gif', 'mp4'];
                const mediaExtension = ['mp4'];
                const docExtension = ['pdf','docs','zip'];
                if (this.isExtensionMatched(imageExtension, extension)) { 
                    return 'fa fa-file-image-o';
                }
                if (this.isExtensionMatched(mediaExtension, extension)) { 
                    return 'fa-file-audio-o';
                }
                if (this.isExtensionMatched(docExtension, extension)) { 
                    return 'fa fa-file-image-o';
                }
                return 'fa-exclamation-circle';
            }
        },
        created() {
            // Listen to the toolbar upload click event
            MediaManager.Event.listen('onClickUpload', () => this.$store.commit(types.SHOW_UPLOAD_MEDIA_MODAL));
        },
    }
</script>