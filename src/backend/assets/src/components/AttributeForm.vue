<template>

    <b-card
        v-if="model"
        class="mb-4"
        :header="title"
        header-class="text-white bg-secondary"
        no-body
    >

        <b-card-body>

            <div>Attributes</div>

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
                type: Object,
                default: function () {
                    return {};
                }
            }
        },

        data () {
            return {
            }
        },

        // computed: {
        //     attributes: {
        //         get () {
        //             return this.model.attributes;
        //         },
        //         set (value) {
        //             this.$emit('update:model.attributes', value);
        //         }
        //     },
        //     settings () {
        //         return this.$store.getters['commerce/settings'];
        //     }
        // },

        watch: {
            model (model) {
                this.model = model;
            }
        },

        methods: {




        }

    }
</script>
