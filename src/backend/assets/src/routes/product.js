import ProductIndex from '../components/product/ProductIndex.vue';
import ProductEdit from '../components/product/ProductEdit.vue';
import ProductDelete from '../components/product/ProductDelete.vue';

const routes = [
    {
        path: '/catalog/product/index',
        name: 'catalog.product.index',
        component: ProductIndex,
        meta: {
            auth: true,
            breadcrumbs: [
                { text: 'Товары' }
            ]
        }
    },
    {
        path: '/catalog/product/create',
        name: 'catalog.product.create',
        component: ProductEdit,
        meta: {
            auth: true,
            breadcrumbs: [
                { text: 'Товары', href: '/#/catalog/product/index' },
                { text: 'Создать' }
            ]
        }
    },
    {
        path: '/catalog/product/update',
        name: 'catalog.product.update',
        component: ProductEdit,
        meta: {
            auth: true,
            breadcrumbs: [
                { text: 'Товары', href: '/#/catalog/product/index' },
                { text: 'Изменить' }
            ]
        }
    },
    {
        path: '/catalog/product/delete',
        name: 'catalog.product.delete',
        component: ProductDelete,
        meta: {
            auth: true
        }
    }
];

export default routes;