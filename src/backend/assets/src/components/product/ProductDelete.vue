<template>

</template>

<script>

    export default {
        // TODO: must be removed
        created () {
            this.$store.dispatch('catalog-product/delete', this.$route.query.id).then(() => {
                this.$notify({type: 'success', text: 'Товар удален'});
                this.$router.push({ path: '/catalog/product/index' });
            });
        }
    }

</script>
