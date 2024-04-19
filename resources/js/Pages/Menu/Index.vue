<template>
    <AppLayout title="Menu">
        <template #header>
            <div class="flex justify-between items-center w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Übersicht
                </h2>
                <Link
                    :href="route('menu.create')"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-500 bg-red-100 rounded-lg hover:bg-red-200 focus:ring-4 focus:outline-none focus:ring-red-500"
                >
                    <i class="fas fa-plus-circle mr-2"></i>
                    Erstellen
                </Link>
            </div>
        </template>
        <div class="">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="grid gap-6">
                            <div v-if="menus.length !== 0">
                                <table class="min-w-full border-collapse border border-gray-200">
                                    <thead>
                                    <tr>
                                        <th class="border border-gray-300 bg-gray-100 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name <i class="fas fa-sort-alpha-down"></i>
                                        </th>
                                        <th class="border border-gray-300 bg-gray-100 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Preis <i class="fas fa-sort-amount-down"></i>
                                        </th>
                                        <th class="border border-gray-300 bg-gray-100 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Anzahl <i class="fas fa-sort-numeric-up"></i>
                                        </th>
                                        <th class="border border-gray-300 bg-gray-100 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="menu in menus" :key="menu.id" class="cursor-pointer">
                                        <td @click="navigateToEdit(menu.id)" class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                                            {{ menu.name }}
                                        </td>
                                        <td @click="navigateToEdit(menu.id)" class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                                            {{ menu.price }}
                                        </td>
                                        <td @click="navigateToEdit(menu.id)" class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                                            {{ menu.pieces }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">
                                            <button @click="destroy(menu.id)" class="inline-flex items-center justify-center p-2 border border-gray-300 bg-white rounded hover:bg-gray-100 hover:border-red-500 text-red-500 hover:text-red-700 transition duration-150 ease-in-out">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-else class="text-gray-700 text-sm">
                                <i class="fas fa-exclamation-circle mr-2"></i>Menü nicht verfügbar
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

export default {
    components: {
        AppLayout,
        Link,
    },
    props: {
        menus: Array,
    },
    methods: {
        navigateToEdit(menuId) {
            Inertia.visit(route('menu.edit', menuId));
        },
        destroy(menuId) {
            Inertia.delete(route('menu.destroy', menuId), {
                onError: (errors) => {
                    console.error('Error deleting the menu:', errors);
                }
            });
        }
    },
};
</script>
