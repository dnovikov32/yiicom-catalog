<template>

    <div>

        <yc-admin-buttons></yc-admin-buttons>

        <div v-html="grid"></div>

    </div>

</template>

<script>
    export default {

        computed: {
            grid () {
                return this.$store.getters['catalog-category/grid'];
            }
        },

        watch: {
            '$route': function () {
                this.$store.dispatch('catalog-category/all', this.$route.query);
            }
        },

        created () {
            this.$store.dispatch('catalog-category/all');
        }

    }
</script>
