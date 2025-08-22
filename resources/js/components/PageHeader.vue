<script setup lang="ts">
interface Props {
    title: string;
    subtitle?: string;
}

defineProps<Props>();
</script>

<template>
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 to-blue-300">
        <!-- Animowany element dekoracyjny w tle -->
        <div class="absolute inset-0 z-1">
            <div class="absolute inset-0 opacity-[0.03]"
                style="background-image: radial-gradient(circle at 2px 2px, blue 1px, transparent 0);
                background-size: 32px 32px;">
            </div>
            <!-- Gradient overlay -->
            <div class="absolute -left-1/8 top-1/4 h-96 w-96 animate-blob rounded-full bg-blue-100 opacity-20 mix-blend-multiply">
            </div>
            <div class="absolute -right-1/6 top-1/4 h-96 w-96 animate-blob animation-delay-2000 rounded-full bg-blue-50 opacity-20 mix-blend-multiply">
            </div>
            <div class="absolute bottom-1/4 left-1/3 h-96 w-96 animate-blob animation-delay-4000 rounded-full bg-white opacity-20 mix-blend-multiply">
            </div>
        </div>

        <!-- Zawartość -->
        <div class="relative mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8 z-2">
            <div class="text-center">
                <h1 class="bg-gradient-to-r from-blue-950 to-blue-700 bg-clip-text text-5xl font-bold tracking-tight text-transparent sm:text-6xl lg:text-7xl">
                    {{ title }}
                </h1>
                <p v-if="subtitle" class="mx-auto mt-6 max-w-2xl text-lg text-blue-800/80 bg-white p-4 rounded-full inline-block">
                    {{ subtitle }}
                </p>
            </div>
        </div>
    </div>
</template>

<style>
@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
