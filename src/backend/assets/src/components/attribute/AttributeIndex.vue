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
                return this.$store.getters['catalog-attribute/grid'];
            }
        },

        watch: {
            '$route': function () {
                this.$store.dispatch('catalog-attribute/all', this.$route.query);
            }
        },

        created () {
            this.$store.dispatch('catalog-attribute/all');
        }

    }
</script>
