<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <AppLayout title="Home">
        <template #header>
            <div class="flex justify-between items-center w-full">
                <h2 class="font-semibold text-xl leading-tight">
                    Übersicht - Kasse
                </h2>
                <div class="flex items-center space-x-4">
                    <Link :href="route('excel')" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-150 ease-in-out">
                        <i class="fas fa-file-excel mr-2"></i> Excel
                    </Link>
                    <Link :href="route('pdf')" class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition duration-150 ease-in-out">
                        <i class="fas fa-file-pdf mr-2"></i> PDF
                    </Link>
                </div>
            </div>
        </template>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-md">
                    <div class="px-4 py-5 sm:p-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Datum
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Täglicher Gewinn
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Beteiligte Benutzer
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(profit, index) in profitsByDate" :key="index">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ profit.date }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ profit.daily_profit }}€
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ profit.users_involved.join(', ') }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div v-if="profitsByDate.length === 0" class="text-gray-500 text-center py-4">
                            Keine Daten verfügbar.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
export default {
    props: {
        profitsByDate: Object
    }
}
</script>
