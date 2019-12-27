<template>

    <div>

        <b-form v-if="model" @submit="save">

            <yc-admin-buttons :model="model" @save="save" @destroy="destroy"></yc-admin-buttons>

            <b-card
                class="mb-4"
                header="Общая информация"
                header-class="text-white bg-secondary"
                no-body
            >

                <b-card-body>

                    <b-form-group
                        label="Название"
                        label-for="title"
                        label-cols-sm="2"
                    >
                        <b-form-input
                            id="title"
                            type="text"
                            v-model="model.title"
                            required
                            trim />
                    </b-form-group>

                    <b-form-group
                        label="Системное имя"
                        label-for="name"
                        label-cols-sm="2"
                    >
                        <b-form-input
                            id="name"
                            type="text"
                            v-model="model.name"
                            required
                            trim />
                    </b-form-group>

                    <b-form-group
                        label="Позиция"
                        label-for="position"
                        label-cols-sm="2"
                    >
                        <b-form-input
                            id="position"
                            type="number"
                            v-model="model.position"
                            required
                            trim />
                    </b-form-group>

                </b-card-body>

            </b-card>

            <b-button type="submit" variant="primary" :disabled="isLoading">Сохранить</b-button>

            <yc-debug :model="model"></yc-debug>

        </b-form>

    </div>

</template>

<script>

    export default {

        data () {
            return {
            };
        },

        computed: {
            isLoading: function () {
                return this.$store.getters['commerce/isLoading'];
            },
            hasError: function () {
                return this.$store.getters['commerce/hasError'];
            },
            settings: function () {
                return this.$store.getters['commerce/settings'];
            },
            model: function () {
                return this.$store.getters['catalog-attribute-group/model'];
            }
        },

        created () {
            this.$store.dispatch('catalog-attribute-group/find', this.$route.query.id);
        },

        watch: {
            '$route': function () {
                this.$store.dispatch('catalog-attribute-group/find', this.$route.query.id);
            }
        },

        methods: {

            save (event) {
                event.preventDefault();

                this.$store.dispatch('catalog-attribute-group/save', this.model).then(() => {
                    if (this.hasError) {
                        return false;
                    }

                    this.$notify({type: 'success', text: 'Группа атрибутов сохранена'});

                    this.$router.push({ path: `/catalog/attribute-group/update?id=${this.model.id}` });
                });

            },

            destroy () {
                this.$store.dispatch('catalog-attribute-group/delete', this.model.id).then(() => {
                    this.$notify({type: 'success', text: 'Группа атрибутов удалена'});
                    this.$router.push({ path: '/catalog/attribute-group/index' });
                });
            }
        }

    }
</script>
