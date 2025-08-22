<!-- Navbar component -->
<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <nav class="bg-white shadow-xl/30 fixed w-full z-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <Link href="/" class="text-blue-600 text-xl font-bold">
                        MyShop
                    </Link>
                </div>

                <!-- Navigation -->
                <div class="flex items-center space-x-4">
                    <Link
                        :href="route('home')"
                        class="text-blue-600 hover:text-blue-500 px-3 py-2 text-sm font-medium"
                    >
                        Home
                    </Link>
                    <Link
                        :href="route('dashboard')"
                        class="text-blue-600 hover:text-blue-500 px-3 py-2 text-sm font-medium"
                    >
                        Dashboard
                    </Link>
                </div>
            </div>
        </div>
    </nav>
</template>
