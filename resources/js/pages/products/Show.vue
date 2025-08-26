<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import { ShoppingCart, Edit, Image } from 'lucide-vue-next';
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';

interface Product {
    id: number;
    name: string;
    price: number;
    description: string;
}

interface Props {
    product: Product;
}

const props = defineProps<Props>();
</script>

<template>

    <Head title="MyShop" />
    <div class="min-h-screen bg-gray-100 flex flex-col">
        <Navbar />

        <main class="flex-grow py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Breadcrumb -->
                <nav class="mb-8">
                    <ol class="flex items-center space-x-2 text-sm text-gray-500">
                        <li>
                            <Link href="/" class="hover:text-blue-600">Strona główna</Link>
                        </li>
                        <li class="flex items-center">
                            <span class="mx-2">/</span>
                            <span class="text-gray-900">{{ product.name }}</span>
                        </li>
                    </ol>
                </nav>

                <!-- Product Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Zdjęcie produktu - lewa strona -->
                    <div class="space-y-4">
                        <div class="aspect-square bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl flex items-center justify-center shadow-lg">
                            <Image class="w-48 h-48 text-blue-400" stroke-width="1" />
                        </div>
                        
                        <!-- Miniaturki (opcjonalnie) -->
                        <div class="flex space-x-2">
                            <div class="w-16 h-16 bg-blue-50 rounded-lg flex items-center justify-center border-2 border-blue-200">
                                <Image class="w-8 h-8 text-blue-400" stroke-width="1" />
                            </div>
                            <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center border-2 border-transparent">
                                <Image class="w-8 h-8 text-gray-400" stroke-width="1" />
                            </div>
                            <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center border-2 border-transparent">
                                <Image class="w-8 h-8 text-gray-400" stroke-width="1" />
                            </div>
                        </div>
                    </div>

                    <!-- Dane produktu - prawa strona -->
                    <div class="space-y-6">
                        <!-- Nagłówek produktu -->
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                                {{ product.name }}
                            </h1>
                            <div class="flex items-center space-x-2">
                                <span class="text-2xl font-bold text-blue-600">
                                    {{ new Intl.NumberFormat('pl-PL', {
                                        style: 'currency',
                                        currency: 'PLN'
                                    }).format(product.price) }}
                                </span>
                            </div>
                        </div>

                        <!-- Opis produktu -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Opis produktu</h3>
                            <p class="text-gray-600 leading-relaxed">
                                {{ product.description }}
                            </p>
                        </div>

                        <!-- Opcje produktu -->
                        <div class="border-t border-gray-200 pt-6">
                            <div class="space-y-4">
                                <!-- Ilość -->
                                <div>
                                    <label class="text-sm font-medium text-gray-900 block mb-2">
                                        Ilość
                                    </label>
                                    <select class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Przyciski akcji -->
                        <div class="border-t border-gray-200 pt-6 space-y-4">
                            <Button 
                                size="lg" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 text-lg font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all cursor-pointer"
                            >
                                <ShoppingCart class="mr-3 h-6 w-6" />
                                Dodaj do koszyka
                            </Button>
                            
                            <div class="flex space-x-4">
                                
                            </div>
                        </div>

                        <!-- Informacje dodatkowe -->
                        <div class="border-t border-gray-200 pt-6">
                            <div class="space-y-3 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <span class="font-medium">Dostępność:</span>
                                    <span class="ml-2 text-green-600 font-medium">Dostępny</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="font-medium">Dostawa:</span>
                                    <span class="ml-2">Darmowa dostawa od 100 PLN</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="font-medium">Zwroty:</span>
                                    <span class="ml-2">30 dni na zwrot</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sekcja dodatkowych informacji -->
                <div class="mt-16 border-t border-gray-200 pt-16">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <ShoppingCart class="w-8 h-8 text-blue-600" />
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Szybka dostawa</h3>
                            <p class="text-gray-600">Dostawa w 24h dla zamówień złożonych do 15:00</p>
                        </div>
                        
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="text-2xl">✓</span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Gwarancja jakości</h3>
                            <p class="text-gray-600">100% oryginalne produkty z gwarancją producenta</p>
                        </div>
                        
                        <div class="text-center">
                            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="text-2xl">↺</span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Łatwe zwroty</h3>
                            <p class="text-gray-600">30 dni na zwrot bez podania przyczyny</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <Footer />
    </div>
</template>