<template>
    <div v-if="$store.state.showUploadMediaPanel" class="joomla-docker-panel joomla-docker-bottom-right joomla-media-docker-panel" label-element="joomlaDockerPanel">
        <div class="joomla-docker-panel-header">
            <div class="joomla-docker-panel-title"> 
                <span v-if="onProcessingItems > 0"> {{onProcessingItems}} Files Uploading </span>
                <span v-if="onProcessingItems === 0"> {{completedItems}} Files Uploaded </span>
            </div>
            <div class="joomla-docker-panel-action">
                <span @click="collapse()" class="joomla-docker-panel-collapse-btn" :class="isCollapse? 'collapse-out' : 'collapse-in'">
                    <i v-if="isCollapse" class="fas fa-chevron-down"></i>
                    <i v-if="!isCollapse" class="fas fa-chevron-up"></i>
                </span>
                <span @click="close()" class="joomla-docker-panel-close-btn" :class="onProcessingItems > 0 ? 'disable-btn': ''" ><i class="fas fa-times"></i></span>
            </div>
            
        </div>
        <div class="joomla-docker-panel-body" :class="bodyClass">
            <div class="joomla-recent-uploaded-media" v-if="uploadedItems.length > 0">
                <div class="joomla-recent-uploaded-media-item" v-for="image in uploadedItems">
                    <div class="joomla-recent-upload-file">
                        <span :class="image.mediaClass"></span>
                        <span class="joomla-upload-file-name">{{stringTruncate(image.name, 16, 6, 20)}}</span>
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
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import * as types from "./../../store/mutation-types";
    import {notifications} from "../../app/Notifications";
    import translate from "../../plugins/translate";
    export default {
        name: 'media-upload-panel',
        data() {
            return {
                isCollapse : true,
                onProcessingItems: [],
                completedItems: [],
            }
        },
        props: {
            accept: {
                type: String,
            },
            extensions: {
                default: () => [],
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
                this.onProcessingItems = this.$store.state.lastUploadedFile.filter( file => !file.success && ( typeof file.error !== 'undefined' && file.error === '') ).length
                this.completedItems = this.$store.state.lastUploadedFile.filter( file => file.success && ( typeof file.error !== 'undefined' && file.error === '') ).length
                return this.$store.state.lastUploadedFile;
            },
            bodyClass(){
                return {'joomla-panel-collapse-in' : !this.isCollapse }
            }
        },
        methods: {
            onCancelUploadProcess(item, event) {
                const {xhrRequest} = item
                
                if (typeof xhrRequest !== 'undefined' && xhrRequest !== null) { 
                    if( typeof item.error !== 'undefined' && item.error !== '' ){
                        this.$store.commit(types.REMOVE_LAST_UPLOADED_FILES, { fileName: item.name });    
                    }else{ 
                        if (notifications.ask(translate.sprintf('Are you sure want to cancel upload process?', item.name), {})) {
                            xhrRequest.abort();
                            this.$store.commit(types.REMOVE_LAST_UPLOADED_FILES, { fileName: item.name });    
                        }
                    }
                }
            },
            onRemoveFile(item, event) {
                this.$store.commit(types.UNSELECT_ALL_BROWSER_ITEMS);
	            this.$store.commit(types.SELECT_BROWSER_ITEM, item);
                this.$store.commit(types.SHOW_CONFIRM_DELETE_MODAL);
            },
            /* Close modal */
            close() {
                if( this.onProcessingItems !== 0 ){
                    return false;
                }
                this.$store.commit(types.HIDE_UPLOAD_MEDIA_MODAL);
                this.$store.commit(types.REMOVE_LAST_UPLOADED_FILES, { empty: true });
            },
            collapse(){
                this.isCollapse = !this.isCollapse
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

        }
    }
</script>