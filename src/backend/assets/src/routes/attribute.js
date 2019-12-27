import Index from '../components/attribute/AttributeIndex.vue';
import Edit from '../components/attribute/AttributeEdit.vue';
import Delete from '../components/attribute/AttributeDelete.vue';

const routes = [
    {
        path: '/catalog/attribute/index',
        name: 'catalog.attribute.index',
        component: Index,
        meta: {
            auth: true,
            breadcrumbs: [
                { text: 'Атрибуты' }
            ]
        }
    },
    {
        path: '/catalog/attribute/create',
        name: 'catalog.attribute.create',
        component: Edit,
        meta: {
            auth: true,
            breadcrumbs: [
                { text: 'Атрибуты', href: '/#/catalog/attribute/index' },
                { text: 'Создать' }
            ]
        }
    },
    {
        path: '/catalog/attribute/update',
        name: 'catalog.attribute.update',
        component: Edit,
        meta: {
            auth: true,
            breadcrumbs: [
                { text: 'Атрибуты', href: '/#/catalog/attribute/index' },
                { text: 'Изменить' }
            ]
        }
    },
    {
        path: '/catalog/attribute/delete',
        name: 'catalog.attribute.delete',
        component: Delete,
        meta: {
            auth: true
        }
    }
];

export default routes;