<template>
    <input type="file" class="hidden"
           :name="name"
           :multiple="multiple"
           :accept="accept"
           @change="upload"
           ref="fileInput">
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
            },
        },
        methods: {
            /* Open the choose-file dialog */
            chooseFiles() {
                this.$refs['fileInput'].click();
            },
            /* Upload files */
            upload(e) {
                e.preventDefault();

                this.$store.commit(types.SHOW_UPLOAD_MEDIA_MODAL)

                const files = e.target.files;
                // Loop through array of files and upload each file
                for (let file of files) {
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
                }
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
            }
        },
        created() {
            // Listen to the toolbar upload click event
            MediaManager.Event.listen('onClickUpload', () => this.chooseFiles());
        },
    }
</script>