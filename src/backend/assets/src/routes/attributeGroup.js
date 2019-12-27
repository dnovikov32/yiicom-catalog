import Index from '../components/attributeGroup/AttributeGroupIndex.vue';
import Edit from '../components/attributeGroup/AttributeGroupEdit.vue';
import Delete from '../components/attributeGroup/AttributeGroupDelete.vue';

const routes = [
    {
        path: '/catalog/attribute-group/index',
        name: 'catalog.attributeGroup.index',
        component: Index,
        meta: {
            auth: true,
            breadcrumbs: [
                { text: 'Группы атрибутов' }
            ]
        }
    },
    {
        path: '/catalog/attribute-group/create',
        name: 'catalog.attributeGroup.create',
        component: Edit,
        meta: {
            auth: true,
            breadcrumbs: [
                { text: 'Группы атрибутов', href: '/#/catalog/attribute-group/index' },
                { text: 'Создать' }
            ]
        }
    },
    {
        path: '/catalog/attribute-group/update',
        name: 'catalog.attributeGroup.update',
        component: Edit,
        meta: {
            auth: true,
            breadcrumbs: [
                { text: 'Группы атрибутов', href: '/#/catalog/attribute-group/index' },
                { text: 'Изменить' }
            ]
        }
    },
    {
        path: '/catalog/attribute-group/delete',
        name: 'catalog.attributeGroup.delete',
        component: Delete,
        meta: {
            auth: true
        }
    }
];

export default routes;