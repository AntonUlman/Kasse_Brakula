<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
</script>

<template>
    <AppLayout title="Menü">
        <template #header>
            <h2 class="font-semibold text-xl leading-tight mr-2">
                Menü erstellen
            </h2>
        </template>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form @submit.prevent="submitForm">
                        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                            <div class="md:grid grid-cols-2 gap-6">
                                <div class="">
                                    <InputLabel for="name" value="Name" />
                                    <TextInput
                                        id="name"
                                        v-model="form.name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                        autocomplete="name"
                                    />
                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>
                                <div>
                                    <InputLabel for="price" value="Preis" />
                                    <TextInput
                                        id="price"
                                        v-model="form.price"
                                        type="number"
                                        step="0.01"
                                        class="mt-1 block w-full"
                                        required
                                        autocomplete="price"
                                    />
                                    <InputError class="mt-2" :message="form.errors.price" />
                                </div>
                                <div class="">
                                    <InputLabel for="pieces" value="Stückzahl" />
                                    <TextInput
                                        id="pieces"
                                        v-model="form.pieces"
                                        type="number"
                                        class="mt-1 block w-full"
                                        required
                                        autocomplete="pieces"
                                    />
                                    <InputError class="mt-2" :message="form.errors.pieces" />
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-center px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                            <div class="mr-3">
                                <div class="text-sm text-gray-600" style="display: none;">gespeichert.</div>
                            </div>
                            <Link :href="route('menu.index')" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-gray-600 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 mr-4">Abbrechen</Link>
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-200">Speichern</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import {Link, useForm} from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
export default {
    components: {
        AppLayout,
        Link,
    },
    data() {
        return {
            form: useForm({
                name: '',
                price: 0,
                pieces: 0,
            }),
        };
    },
    props: {
        menu: {
            type: Object,
            default: () => ({
                name: '',
                price: 0,
                pieces: 0
            })
        }
    },
    watch: {
        menu: {
            handler(newVal) {
                if (newVal) {
                    this.form.name = newVal.name;
                    this.form.price = newVal.price;
                    this.form.pieces = newVal.pieces;
                }
            },
            deep: true,
            immediate: true
        }
    },
    methods: {
        async submitForm() {
            await this.form.put(route('menu.update', this.menu.id));
        },
    },
};
</script>

