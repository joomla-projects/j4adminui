<template>
    <div class="media-infobar-popup" v-if="item"  v-click-outside="hideInfoBar">
        <span class="infobar-close" @click="hideInfoBar()">×</span>
        <div v-if="item.path === '/'" class="text-center">
            <span class="fa fa-file placeholder-icon"></span>
            Select file or folder to view its details.
        </div>
        <ul v-else>
            <li>
                <span class="media-info-title">{{ translate('COM_MEDIA_FOLDER') }}</span>
                <span class="media-info-details">{{ item.directory }}</span>
            </li>

            <li>
                <span class="media-info-title">{{ translate('COM_MEDIA_MEDIA_TYPE') }}</span>
                <span class="media-info-details">{{ item.type || '-' }}</span>
            </li>

            <li>
                <span class="media-info-title">{{ translate('COM_MEDIA_MEDIA_DATE_CREATED') }}</span>
                <span class="media-info-details">{{ item.create_date_formatted }}</span>
            </li>

            <li>
                <span class="media-info-title">{{ translate('COM_MEDIA_MEDIA_DATE_MODIFIED') }}</span>
                <span class="media-info-details">{{ item.modified_date_formatted }}</span>
            </li>

            <li>
                <span class="media-info-title">{{ translate('COM_MEDIA_MEDIA_DIMENSION') }}</span>
                <span class="media-info-details" v-if="item.width || item.height">{{ item.width }} x {{ item.height}}</span>
                <span class="media-info-details" v-else> - </span>
            </li>
            <!-- <dd v-if="item.width || item.height">{{ item.width }} x {{ item.height}}</dd> -->
            <!-- <dd v-else>-</dd> -->

            <li>
                <span class="media-info-title">{{ translate('COM_MEDIA_MEDIA_SIZE') }}</span>
                <span class="media-info-details">{{ item.size || '-' }}</span>
            </li>

            <li>
                <span class="media-info-title">{{ translate('COM_MEDIA_MEDIA_MIME_TYPE') }}</span>
                <span class="media-info-details">{{ item.mime_type }}</span>
            </li>

            <li>
                <span class="media-info-title">{{ translate('COM_MEDIA_MEDIA_EXTENSION') }}</span>
                <span class="media-info-details">{{ item.extension || '-' }}</span>
            </li>

        </ul>
    </div>
</template>
<script>
    import * as types from "../../store/mutation-types";

    export default {
        name: 'media-infobar-popup',
        props: ['item'],
        computed: {
           
        },
        methods: {
            hideInfoBar() {
                this.$emit('hideInfoPopup');
            }
        }
    }
</script>