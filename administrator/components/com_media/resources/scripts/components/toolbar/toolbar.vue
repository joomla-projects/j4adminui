<template>
    <div class="media-toolbar"role="toolbar" :aria-label="translate('COM_MEDIA_TOOLBAR_LABEL')">
        <div class="media-loader" v-if="isLoading"></div>
        <div class="media-view-icons" v-if="isGridView">
            <a href="#" class="media-toolbar-icon media-toolbar-select-all"
               @click.stop.prevent="toggleSelectAll()"
               :aria-label="translate('COM_MEDIA_SELECT_ALL')">
                <span :class="toggleSelectAllBtnIcon" aria-hidden="true"></span>
            </a>
        </div>
        <media-breadcrumb></media-breadcrumb>
        <div class="media-view-search-input" role="search">
            <span class="fa fa-search"></span>
            <label for="media_search" class="sr-only">{{ translate('COM_MEDIA_SEARCH') }}</label>
            <input id="media_search" class="form-control" type="text" @input="changeSearch" :placeholder="translate('COM_MEDIA_SEARCH')"/>
        </div>
        <div class="media-view-icons d-none d-sm-flex">
            <div class="media-toolbar-view-type" :class="activGridClass">
                <button type="button" href="#" class="media-toolbar-icon media-toolbar-grid-view" 
                @click.stop.prevent="changeListView('grid')"
                :aria-label="translate('COM_MEDIA_TOGGLE_GRID_VIEW')">
                    <span class="fa fa-th" aria-hidden="true"></span>
                </button>
                <button type="button" href="#" class="media-toolbar-icon media-toolbar-list-view"
                @click.stop.prevent="changeListView('table')"
                :aria-label="translate('COM_MEDIA_TOGGLE_LIST_VIEW')">
                    <span class="fa fa-list" aria-hidden="true"></span>
                </button>
            </div>
            <div class="media-toolbar-zoom-btn">
                <button type="button" class="media-toolbar-icon media-toolbar-decrease-grid-size"
                v-if="isGridView"
                :class="{disabled: isGridSize('xs')}"
                @click.stop.prevent="decreaseGridSize()" 
                :aria-label="translate('COM_MEDIA_DECREASE_GRID')">
                    <span class="fa fa-search-minus" aria-hidden="true"></span>
                </button>
                <button type="button" class="media-toolbar-icon media-toolbar-increase-grid-size"
                v-if="isGridView"
                :class="{disabled: isGridSize('xl')}"
                @click.stop.prevent="increaseGridSize()" 
                :aria-label="translate('COM_MEDIA_INCREASE_GRID')">
                    <span class="fa fa-search-plus" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import * as types from "../../store/mutation-types";

    export default {
        name: 'media-toolbar',
        computed: {
            activGridClass() {
                return (this.isGridView) ? 'grid-active' : 'list-active';
            },
            toggleSelectAllBtnIcon() {
                return (this.allItemsSelected) ? 'media-checkbox active' : 'media-checkbox'
            },
            isLoading() {
                return this.$store.state.isLoading;
            },
            atLeastOneItemSelected() {
                return this.$store.state.selectedItems.length > 0;
            },
            isGridView() {
                return (this.$store.state.listView === 'grid');
            },
            allItemsSelected() {
                return (this.$store.getters.getSelectedDirectoryContents.length === this.$store.state.selectedItems.length);
            }
        },
        methods: {
            toggleInfoBar() {
                if (this.$store.state.showInfoBar) {
                    this.$store.commit(types.HIDE_INFOBAR);
                } else {
                    this.$store.commit(types.SHOW_INFOBAR);
                }
            },
            decreaseGridSize() {
                if (!this.isGridSize('xs')) {
                    this.$store.commit(types.DECREASE_GRID_SIZE);
                }
            },
            increaseGridSize() {
                if (!this.isGridSize('xl')) {
                    this.$store.commit(types.INCREASE_GRID_SIZE);
                }
            },
            changeListView(viewType) {
                if (this.$store.state.listView === viewType)
                    return false;
                this.$store.commit(types.CHANGE_LIST_VIEW, viewType);
            },
            toggleSelectAll() {
                if (this.allItemsSelected) {
                    this.$store.commit(types.UNSELECT_ALL_BROWSER_ITEMS);
                } else {
                    this.$store.commit(types.SELECT_BROWSER_ITEMS, this.$store.getters.getSelectedDirectoryContents);
                }
            },
            isGridSize(size) {
                return (this.$store.state.gridSize === size);
            },
            changeSearch(query){
                this.$store.commit(types.SET_SEARCH_QUERY, query.target.value);
            }
        }
    }
</script>
