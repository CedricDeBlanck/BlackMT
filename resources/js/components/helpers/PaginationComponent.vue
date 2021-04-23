<template>
    <ul class="pagination" v-if="pagination.last_page > 1">
        <li v-if="pagination.current_page != pagination.first_page && pagination.current_page > 1" class="page-item">
            <a href="javascript:void(0)"
               class="page-link"
               aria-label="Previous"
               v-on:click.prevent="changePage(pagination.first_page)">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <li v-if="pagination.current_page > 1" class="page-item">
            <a href="javascript:void(0)"
               class="page-link"
               aria-label="Previous"
               v-on:click.prevent="changePage(pagination.current_page - 1)">
                <span aria-hidden="true">&lsaquo;</span>
            </a>
        </li>
        <li v-if="pagination.last_page > 5 && pagination.current_page > 5 " class="page-item disabled">
            <a href="javascript:;" class="page-link">...</a>
        <li>
        <li v-for="page in pagesNumber" v-if="  pagination.current_page - 5 < page && pagination.current_page + 5 > page " :class="{'active': page == pagination.current_page}" class="page-item">
            <a href="javascript:void(0)"
               class="page-link"
               v-on:click.prevent="changePage(page)">
                {{ page }}
            </a>
        </li>
        <li v-if="pagination.last_page > 5 && pagination.current_page <= (pagination.last_page-5) " class="page-item disabled">
            <a href="javascript:;" class="page-link">...</a>
        <li>
        <li v-if="pagination.current_page < pagination.last_page" class="page-item">
            <a href="javascript:void(0)"
               class="page-link"
               aria-label="Next"
               v-on:click.prevent="changePage(pagination.current_page + 1)">
                <span aria-hidden="true">&rsaquo;</span>
            </a>
        </li>
        <li v-if="pagination.current_page != pagination.last_page" class="page-item">
            <a href="javascript:void(0)"
               class="page-link"
               aria-label="Previous"
               v-on:click.prevent="changePage(pagination.last_page)">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</template>
<script>
    export default{
        props: {
            pagination: {
                type: Object,
                required: true
            },
            offset: {
                type: Number,
                default: 4
            }
        },
        computed: {
            pagesNumber() {
                if (!this.pagination.to) {
                    return [];
                }
                let from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                let to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                let pagesArray = [];
                for (let page = from; page <= to; page++) {
                    pagesArray.push(page);
                }
                return pagesArray;
            }
        },
        methods : {
            changePage(page) {
                this.pagination.current_page = page;
                this.$emit('paginate');
            }
        }
    }
</script>