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

                    <b-form-group
                        label="Заголовок"
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
                        label="Цена"
                        label-for="price"
                        label-cols-sm="2"
                    >
                        <b-form-input
                            id="price"
                            type="number"
                            v-model="model.price"
                            required
                            trim />
                    </b-form-group>

                    <b-form-group
                        label-cols-sm="2"
                    >
                        <b-form-checkbox
                            id="isShowPrice"
                            v-model="model.isShowPrice"
                            value="1"
                            unchecked-value="0"
                        >
                            Показывать цену
                        </b-form-checkbox>
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
                        v-if="model.productCategories"
                        label="Категории"
                        label-for="categories"
                        label-cols-sm="2"
                    >
                        <b-form-select
                            id="categories"
                            class="col-6"
                            multiple
                            v-model="selectedCategories"
                            :options="categories"
                            :select-size="7"
                        >
                        </b-form-select>

                        <div v-if="this.categories.length && model.productCategories.length" class="yc-product__categories">
                            <p>Основная категория:</p>
                            <ul>
                                <li v-for="(category, index) in model.productCategories" :key="index"
                                    class="text-primary"
                                    :class="category.isMain ? 'active' : ''"
                                    @click="setMainCategory(category.categoryId)"
                                >
                                    {{ getCategoryName(category.categoryId) }}
                                </li>
                            </ul>
                        </div>

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

            <url-form :model="model.url"></url-form>

            <files-form
                :models.sync="model.files"
                title="Изображения"
                :multiple="true"
            />

            <b-button type="submit" variant="primary" :disabled="isLoading">Сохранить</b-button>

            <pre v-if="isDev">categories: {{  categories }}</pre>
            <pre v-if="isDev">model: {{  model }}</pre>

        </b-form>

    </div>

</template>

<script>
    // TODO: do something with component import from another module
    import UrlForm from "./../../../../../../../yiicom-content/src/backend/assets/src/components/UrlForm.vue";
    import FilesForm from "./../../../../../../../yiicom-files/src/backend/assets/src/components/FilesForm.vue";

    export default {

        components: {
            UrlForm,
            FilesForm
        },

        data () {
            return {
                selectedCategories: [],
                mainCategoryId: 0
            };
        },

        computed: {
            isDev: function () {
                return this.$store.getters['commerce/isDev'];
            },
            isLoading: function () {
                return this.$store.getters['commerce/isLoading'];
            },
            hasError: function () {
                return this.$store.getters['commerce/hasError'];
            },
            settings: function () {
                return this.$store.getters['commerce/settings'];
            },
            statuses: function () {
                return _.isEmpty(this.settings) ? [] : this.settings.statusesList;
            },
            model: function () {
                return this.$store.getters['catalog-product/model'];
            },
            categories: function () {
                return this.$store.getters['catalog-category/list'];
            }
        },

        created () {
            this.$store.dispatch('catalog-category/list', this.$route.query.id);
            this.$store.dispatch('catalog-product/find', this.$route.query.id).then(() => {
                let self = this;

                this.selectedCategories = this.model.productCategories.map(function (item) {
                    if (item.isMain) {
                        self.mainCategoryId = item.categoryId;
                    }

                    return item.categoryId;
                });
            });
        },

        watch: {
            '$route': function () {
                this.$store.dispatch('catalog-category/list', this.$route.query.id);
                this.$store.dispatch('catalog-product/find', this.$route.query.id);
            },
            'selectedCategories': function () {
                let self = this;
                let hasMainCategory = false;

                this.model.productCategories = this.selectedCategories.map(function (value) {
                    let isMain = false;

                    if (value === self.mainCategoryId) {
                        hasMainCategory = true;
                        isMain = true;
                    }

                    return {
                        productId: 0,
                        categoryId: value,
                        isMain: isMain
                    };
                });

                if (! hasMainCategory && this.model.productCategories.length) {
                    this.model.productCategories[0].isMain = true;
                }
            }
        },

        methods: {

            getCategoryName (categoryId) {
                let category = _.find(this.categories, function (item) {
                    return item.value === categoryId;
                });

                return category.text.replace(/\./g, '');
            },

            setMainCategory (categoryId) {
                let self = this;

                _.each(this.model.productCategories, function (item) {
                    if (item.categoryId === categoryId) {
                        self.mainCategoryId = categoryId;
                        item.isMain = true;
                    } else {
                        item.isMain = false;
                    }
                });
            },

            save (event) {
                event.preventDefault();

                this.$store.dispatch('catalog-product/save', this.model).then(() => {
                    if (this.hasError) {
                        return false;
                    }

                    this.$notify({type: 'success', text: 'Товар сохранен'});

                    this.$router.push({ path: `/catalog/product/update?id=${this.model.id}` });
                });

            },

            destroy () {
                this.$store.dispatch('catalog-product/delete', this.model.id).then(() => {
                    this.$notify({type: 'success', text: 'Товар удален'});
                    this.$router.push({ path: '/catalog/product/index' });
                });
            }
        }

    }
</script>
