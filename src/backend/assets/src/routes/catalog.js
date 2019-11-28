import CategoriesIndex from '../components/categories/CategoriesIndex.vue';
import CategoriesEdit from '../components/categories/CategoriesEdit.vue';
import CategoriesDelete from '../components/categories/CategoriesDelete.vue';

const routes = [
    {
        path: '/catalog/category/index',
        name: 'catalog.category.index',
        component: CategoriesIndex,
        meta: {
            auth: true,
            breadcrumbs: [
                { text: 'Каталог' }
            ]
        }
    },
    {
        path: '/catalog/category/create',
        name: 'catalog.category.create',
        component: CategoriesEdit,
        meta: {
            auth: true,
            breadcrumbs: [
                { text: 'Каталог', href: '/#/catalog/category/index' },
                { text: 'Создать' }
            ]
        }
    },
    {
        path: '/catalog/category/update',
        name: 'catalog.category.update',
        component: CategoriesEdit,
        meta: {
            auth: true,
            breadcrumbs: [
                { text: 'Каталог', href: '/#/catalog/category/index' },
                { text: 'Изменить' }
            ]
        }
    },
    {
        path: '/catalog/category/delete',
        name: 'catalog.category.delete',
        component: CategoriesDelete,
        meta: {
            auth: true
        }
    }
];

export default routes;