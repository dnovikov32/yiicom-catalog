<template>

    <b-card
        v-if="attributeValues.value"
        class="mb-4"
        :header="title"
        header-class="text-white bg-secondary"
        no-body
    >

        <b-card-body>

            <div v-for="(group, groupIndex) in attributes">

                <div v-if="group.attributes && group.attributes.length">

                    <h6 v-if="group.title">{{ group.title }}</h6>
                    <h6 v-else>Без группы</h6>

                    <ul class="list-unstyled">
                        <li v-for="(attr, attrIndex) in group.attributes">
                            <b-form-checkbox v-if="attr.type == 1"
                                 :id="'attribute_' + attr.id"
                                 v-model="attributeValues.value[attr.id]"
                                 value="1"
                                 unchecked-value="0">
                                {{ attr.title }}
                            </b-form-checkbox>

                            <b-form-group v-if="attr.type == 2"
                                class="mb-1"
                                :label="attr.title"
                                :label-for="'attribute_' + attr.id"
                                label-cols-sm="2"
                            >
                                <b-form-input
                                      :id="'attribute_' + attr.id"
                                      class="col-2"
                                      type="number"
                                      v-model="attributeValues.value[attr.id]" />
                            </b-form-group>

                            <b-form-group v-if="attr.type == 3"
                                class="mb-1"
                                :label="attr.title"
                                :label-for="'attribute_' + attr.id"
                                label-cols-sm="2"
                            >
                                <b-form-input
                                      :id="'attribute_' + attr.id"
                                      class="col-6"
                                      type="text"
                                      v-model="attributeValues.value[attr.id]" />
                            </b-form-group>

                        </li>
                    </ul>

                </div>

            </div>

        </b-card-body>

    </b-card>

</template>

<script>

    export default {

        props: {
            title: {
                type: String,
                default: 'Атрибуты'
            },
            model: {
                type: [Object],
                default: function () {
                    return {};
                }
            }
        },

        computed: {
            attributeValues: {
                get () {
                    return this.model;
                },
                set (value) {
                    this.$emit('update:model', value);
                }
            },
            attributes: function () {
                return this.$store.getters['catalog-attribute/list'];
            }
        },

        watch: {
            model (model) {
                this.model = model;
            }
        }

    }
</script>
