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

                    <yc-title-fields :model="model"></yc-title-fields>

                    <b-form-group
                        label="Родительская категория"
                        label-for="parentId"
                        label-cols-sm="2"
                    >
                        <b-form-select
                            id="parentId"
                            class="col-3"
                            v-model="model.parentId"
                            :options="categories"
                        >
                        </b-form-select>
                    </b-form-group>

                    <b-form-group
                        label="Статус"
                        label-for="status"
                        label-cols-sm="2"
                    >
                        <b-form-select
                            id="status"
                            class="col-3"
                            v-model="model.status"
                            :options="statuses">
                        </b-form-select>
                    </b-form-group>

                    <b-form-group
                        label="Короткое содержимое"
                        label-for="teaser"
                    >
                        <vue-ckeditor v-model="model.teaser" :config="{height: 150}" />
                    </b-form-group>

                    <b-form-group
                        label="Полное содержимое"
                        label-for="body"
                    >
                        <vue-ckeditor v-model="model.body" />
                    </b-form-group>

                </b-card-body>

            </b-card>

            <url-form :model="model"></url-form>

            <files-form
                :models.sync="model.files"
                title="Изображение превью"
                :multiple="false"
            />

            <b-button type="submit" variant="primary" :disabled="isLoading">Сохранить</b-button>

            <yc-debug :model="model"></yc-debug>

        </b-form>

    </div>

</template>

<script>
    // TODO: do something with component import from another module
    import TitleField from "./../../../../../../../yiicom/src/backend/assets/src/components/form/TitleField.vue";
    import UrlForm from "./../../../../../../../yiicom-content/src/backend/assets/src/components/UrlForm.vue";
    import FilesForm from "./../../../../../../../yiicom-files/src/backend/assets/src/components/FilesForm.vue";

    export default {

        components: {
            'yc-title-fields': TitleField,
            UrlForm,
            FilesForm
        },

        computed: {
            isLoading: function () {
                return this.$store.getters['commerce/isLoading'];
            },
            hasError: function () {
                return this.$store.getters['commerce/hasError'];
            },
            model: function () {
                return this.$store.getters['catalog-category/model'];
            },
            settings: function () {
                return this.$store.getters['commerce/settings'];
            },
            statuses: function () {
                return _.isEmpty(this.settings) ? [] : this.settings.statusesList;
            },
            categories: function () {
                return this.$store.getters['catalog-category/list'];
            }
        },

        created () {
            this.$store.dispatch('catalog-category/list', { id: this.$route.query.id, root: true });
            this.$store.dispatch('catalog-category/find', this.$route.query.id);
        },

        watch: {
            '$route': function () {
                this.$store.dispatch('catalog-category/list', { id: this.$route.query.id, root: true });
                this.$store.dispatch('catalog-category/find', this.$route.query.id);
            }
        },

        methods: {

            save (event) {
                event.preventDefault();

                this.$store.dispatch('catalog-category/save', this.model).then(() => {
                    if (this.hasError) {
                        return false;
                    }

                    this.$notify({type: 'success', text: 'Категория сохранена'});

                    this.$router.push({ path: `/catalog/category/update?id=${this.model.id}` });
                    this.$store.dispatch('catalog-category/list', { id: this.$route.query.id, root: true });
                });

            },

            destroy () {
                this.$store.dispatch('catalog-category/delete', this.model.id).then(() => {
                    this.$notify({type: 'success', text: 'Категория удалена'});
                    this.$router.push({ path: '/catalog/category/index' });
                });
            }
        }

    }
</script>
