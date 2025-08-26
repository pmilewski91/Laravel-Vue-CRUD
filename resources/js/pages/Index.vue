<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { ShoppingCart, SquareChartGantt, Edit, Image } from 'lucide-vue-next';
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
import PageHeader from '@/components/PageHeader.vue';

interface Product {
    id: number;
    name: string;
    price: number;
    description: string;
}

interface Props {
    products: Product[];
}

const props = defineProps<Props>();
</script>

<template>

    <Head title="MyShop" />
    <div class="min-h-screen bg-gray-100 flex flex-col">
        <Navbar />

        <PageHeader class="mt-16" title="Witaj w naszym sklepie!" subtitle="Odkryj nasze najnowsze produkty" />

        <main class="flex-grow mt-8 mb-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Grid produktów -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <Card v-for="product in props.products" :key="product.id"
                        class="group overflow-hidden transition-all shadow-xl/30 hover:shadow-lg bg-white border-none">
                        <CardHeader>
                            <div class="space-y-1">
                                <CardTitle class="text-xl font-bold text-blue-800">
                                    {{ product.name }}
                                </CardTitle>

                            </div>
                        </CardHeader>

                        <CardContent>
                            <div class="aspect-square bg-blue-500 rounded-lg flex items-center justify-center mb-4">
                                <Image class="w-32 h-32 text-blue-300" />
                            </div>
                            <CardDescription class="text-2xl font-semibold text-blue-600">
                                {{ new Intl.NumberFormat('pl-PL', {
                                    style: 'currency',
                                    currency: 'PLN'
                                }).format(product.price) }}
                            </CardDescription>
                            <p class="text-sm text-gray-600 line-clamp-2">
                                {{ product.description }}
                            </p>
                        </CardContent>

                        <CardFooter class="flex justify-between gap-2">
                            <div>
                                <Link :href="route('products.show', { product: product.id })"><Button variant="default"
                                    size="sm" class="w-full bg-blue-600 hover:bg-blue-700 text-white cursor-pointer mb-4">
                                    <SquareChartGantt class="mr-2 h-4 w-4" />
                                    Zobacz szczegóły
                                </Button></Link>
                                <Button variant="default" size="sm"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white cursor-pointer">
                                    <ShoppingCart class="mr-2 h-4 w-4" />
                                    Do koszyka
                                </Button>
                            </div>

                        </CardFooter>
                    </Card>
                </div>

                <!-- Pusty stan -->
                <div v-if="!props.products.length" class="mt-32 flex flex-col items-center justify-center text-center">
                    <div class="text-gray-600">
                        <ShoppingCart class="mx-auto h-12 w-12 mb-4 text-blue-400" />
                        <h3 class="text-lg font-semibold text-blue-800">Brak produktów</h3>
                        <p class="mb-4">Nie znaleziono żadnych produktów w sklepie.</p>
                        <Button asChild class="bg-blue-600 hover:bg-blue-700">
                            <Link href="/products/create">Dodaj pierwszy produkt</Link>
                        </Button>
                    </div>
                </div>
            </div>
        </main>

        <Footer />
    </div>
</template>