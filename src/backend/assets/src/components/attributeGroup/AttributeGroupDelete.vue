<template>

</template>

<script>

    export default {
        // TODO: must be removed
        created () {
            this.$store.dispatch('catalog-attribute-group/delete', this.$route.query.id).then(() => {
                this.$notify({type: 'success', text: 'Группа атрибутов удалена'});
                this.$router.push({ path: '/catalog/attribute-group/index' });
            });
        }
    }

</script>
