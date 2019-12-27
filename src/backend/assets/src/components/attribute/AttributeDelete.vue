<template>

</template>

<script>

    export default {
        // TODO: must be removed
        created () {
            this.$store.dispatch('catalog-attribute/delete', this.$route.query.id).then(() => {
                this.$notify({type: 'success', text: 'Атрибут удален'});
                this.$router.push({ path: '/catalog/attribute/index' });
            });
        }
    }

</script>
