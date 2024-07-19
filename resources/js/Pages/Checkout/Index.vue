<template>
    <AppLayout title="Kasse">
        <template #header>
            <div class="flex justify-between items-center w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Kasse
                </h2>
            </div>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <form @submit.prevent="submitCart">
                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <div v-if="menus && menus.length > 0" class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4 p-4 bg-gray-100 rounded-lg shadow">
                                    <!-- Menü-Items als Buttons -->
                                    <button
                                        v-for="menu in menus"
                                        :key="menu.id"
                                        @click.prevent="addToCart(menu)"
                                        type="button"
                                        :class="{'bg-blue-600 hover:bg-blue-800': menu.pieces > 0, 'bg-gray-400 cursor-not-allowed': menu.pieces <= 0}"
                                        class="inline-flex items-center justify-center text-white font-bold py-3 px-4 rounded-lg text-sm md:text-lg transition-colors duration-300 ease-in-out"
                                        :disabled="menu.pieces <= 0"
                                    >
                                        <div class="flex flex-col items-center">
                                            <span class="font-semibold">{{ menu.name }}</span>
                                            <span class="text-sm md:text-base">{{ menu.price }}€</span>
                                            <span class="text-xs font-light">{{ menu.pieces }} Stück(e) verfügbar</span>
                                        </div>
                                    </button>
                                </div>
                                <div v-else>
                                    Keine Menüs mehr verfübar!
                                </div>
                                <!-- Warenkorb-Anzeige -->
                                <div class="mt-8"
                                     :class="{'p-4 bg-gray-100 rounded-lg shadow': cart.length > 0}">
                                    <div class="overflow-y-auto max-h-64"> <!-- Add these classes -->
                                        <div v-for="(item, index) in cart" :key="item.id" class="flex items-center justify-between py-2 border-b border-gray-300">
                                            <div class="flex flex-col md:flex-row md:items-center">
                                                <span class="font-bold text-gray-800 text-lg mr-2">{{ item.name }}</span>
                                                <span class="text-gray-600">{{ item.quantity }} Stück(e)</span>
                                                <span class="text-green-500 font-bold ml-2">{{ item.price * item.quantity }}€</span>
                                            </div>
                                            <button @click.prevent="removeFromCart(item)" class="inline-flex items-center bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 rounded-lg transition-colors duration-300 ease-in-out">
                                                <i class="fas fa-trash-alt mr-2"></i>Entfernen
                                            </button>
                                        </div>
                                        <!-- Display a message when cart is empty -->
                                        <div v-if="cart.length === 0" class="text-gray-500 text-center py-4">
                                            Der Warenkorb ist leer.
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div>
                                <div class="p-4 bg-gray-100 rounded-lg shadow grid grid-cols-3 gap-4">
                                    <!-- Numeric Buttons -->
                                    <button v-for="num in [1,2,3,4,5,6,7,8,9,0]" :key="`num-${num}`" @click="addDigit(num)" type="button"
                                            class="inline-flex items-center justify-center font-bold py-4 px-4 rounded-lg text-lg md:text-xl"
                                            :class="free ? 'bg-gray-400 text-gray-600 cursor-not-allowed' : 'bg-gray-200 hover:bg-gray-300 text-gray-800'"
                                            :disabled="free">
                                        <i class="fas fa-keyboard mr-2"></i>{{ num }}
                                    </button>
                                    <!-- Decimal Point Button -->
                                    <button @click="addDigit('.')" type="button"
                                            class="font-bold py-4 px-4 rounded-lg text-lg md:text-xl"
                                            :class="free ? 'bg-gray-400 text-gray-600 cursor-not-allowed' : 'bg-gray-200 hover:bg-gray-300 text-gray-800'"
                                            :disabled="free">
                                        .
                                    </button>
                                    <!-- Free Toggle Button -->
                                    <button type="button" @click="toggleFree"
                                            class="inline-flex items-center justify-center font-bold py-4 px-4 rounded-lg text-lg md:text-xl"
                                            :class="{'bg-green-500 hover:bg-green-600': free, 'bg-gray-200 hover:bg-gray-300': !free}">
                                        {{ free ? 'Kostenlos' : 'Kostenfrei' }}
                                    </button>
                                    <!-- Clear Button -->
                                    <button @click="clear()" type="button" class="col-span-3 inline-flex items-center justify-center bg-red-500 hover:bg-red-700 text-white font-bold py-4 px-4 rounded-lg transition-colors duration-300 ease-in-out">
                                        <i class="fas fa-eraser mr-2"></i>Clear
                                    </button>
                                </div>

                                <div class="mt-8 p-4 bg-gray-100 rounded-lg shadow">
                                    <div class="text-lg font-bold text-gray-800">
                                        Gesamtpreis: <span class="text-xl text-green-600">{{ totalPrice }}€</span>
                                    </div>
                                    <div class="text-lg font-bold mt-2 text-gray-800">
                                        Erhalten: <span class="text-xl text-blue-600">{{ parseFloat(receivedAmount).toFixed(2) }}€</span>
                                    </div>
                                    <div v-if="this.free" class="text-lg font-bold mt-2 text-gray-800">
                                        Wechselgeld: <span class="text-xl text-red-500">0.00€</span>
                                    </div>
                                    <div v-else class="text-lg font-bold mt-2 text-gray-800">
                                        Wechselgeld: <span class="text-xl text-red-500">{{ changeDue.toFixed(2) }}€</span>
                                    </div>
                                </div>
                                <!-- Absenden-Button -->
                                <button
                                    type="submit"
                                    class="mt-4 inline-flex justify-center py-3 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                    :disabled="cart.length === 0 || (!free && changeDue < 0)"
                                >
                                    <i class="fas fa-check mr-2"></i>Warenkorb übermitteln
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link, useForm} from '@inertiajs/vue3';

export default {
    components: {
        AppLayout,
        Link,
    },
    props: {
        menus: Array,
    },
    data() {
        return {
            cart: [],
            form: useForm({
                items: [],
                free: false,
            }),
            receivedAmount: 0,
            changeDue: 0,
            free: false
        };
    },
    methods: {
        addToCart(item) {
            const menuIndex = this.menus.findIndex(menu => menu.id === item.id);
            if (menuIndex !== -1 && this.menus[menuIndex].pieces > 0) {
                this.menus[menuIndex].pieces -= 1; // Decrement pieces count

                const existingItem = this.cart.find(cartItem => cartItem.id === item.id);
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    this.cart.push({...item, quantity: 1});
                }
            }
            this.calculateChange();
        },
        removeFromCart(itemToRemove) {
            const menuIndex = this.menus.findIndex(menu => menu.id === itemToRemove.id);
            if (menuIndex !== -1) {
                this.menus[menuIndex].pieces += 1; // Increment pieces count
            }

            const existingItemIndex = this.cart.findIndex(item => item.id === itemToRemove.id);
            if (existingItemIndex !== -1) {
                if (this.cart[existingItemIndex].quantity > 1) {
                    this.cart[existingItemIndex].quantity -= 1;
                } else {
                    this.cart.splice(existingItemIndex, 1);
                }
            }
            this.calculateChange();
        },
        async submitCart() {
            if (this.free) {
                this.receivedAmount = this.totalPrice; // Set received amount to total price to balance out
                this.changeDue = 0; // No change due since it's free
                this.form.free = true
            }

            // Proceed with form submission
            await this.form.post(route('checkout.store'), {
                onSuccess: (response) => {
                    this.$emit('menusUpdated', response.updatedMenus);
                    this.cart = [];
                    this.receivedAmount = 0;
                    this.changeDue = 0;
                    this.free = false; // Optionally reset the free toggle
                },
                onError: (error) => {
                    console.error('Checkout failed:', error);
                }
            });
        },
        addDigit(digit) {
            // Ignore inputs if the transaction is marked as free
            if (this.free) return;

            const receivedStr = this.receivedAmount.toString();
            if (digit === '.') {
                // Append '.' only if it's not already present
                if (!receivedStr.includes('.')) {
                    this.receivedAmount += '.';
                }
            } else {
                // Handle numeric input
                if (receivedStr === '0' && !receivedStr.includes('.')) {
                    this.receivedAmount = digit; // Replace leading zero
                } else {
                    this.receivedAmount = parseFloat(receivedStr + digit);
                }
            }
            this.calculateChange();
        },
        calculateChange() {
            const total = this.totalPrice;
            this.changeDue = parseFloat(this.receivedAmount) - total;

            if (isNaN(this.changeDue)) {
                this.changeDue = 0;
            }
        },
        clear() {
            if(this.free !== true) {
                this.receivedAmount = 0;
                this.calculateChange();
            } else {
                //
            }
        },
        toggleFree() {
            this.free = !this.free;
            // Reset receivedAmount to 0 if the transaction is free
            if (this.free) {
                this.receivedAmount = 0;
            }
        }
    },
    computed: {
        totalPrice() {
            const total = this.cart.reduce((total, item) => {
                return total + (item.price * item.quantity);
            }, 0);

            // Round the total to two decimal places before returning
            return parseFloat(total.toFixed(2));
        },
    },
    watch: {
        cart: {
            deep: true,
            handler(newCart) {
                this.form.items = newCart.map(item => ({
                    id: item.id,
                    quantity: item.quantity,
                    price: item.price,
                }));
            }
        }
    },
};
</script>
