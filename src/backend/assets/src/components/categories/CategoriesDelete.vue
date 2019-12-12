<template>

</template>

<script>

    export default {
        // TODO: must be removed
        created () {
            this.$store.dispatch('catalog-category/delete', this.$route.query.id).then(() => {
                this.$notify({type: 'success', text: 'Категория удалена'});
                this.$router.push({ path: '/catalog/category/index' });
            });
        }
    }

</script>
