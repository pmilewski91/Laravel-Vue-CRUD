<!-- Footer component -->
<template>
    <footer class="bg-white shadow-sm mt-auto">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- About section -->
                <div>
                    <h3 class="text-blue-600 font-semibold mb-4">O nas</h3>
                    <p class="text-gray-600 text-sm">
                        Jesteśmy sklepem oferującym najwyższej jakości produkty w konkurencyjnych cenach.
                    </p>
                </div>

                <!-- Quick links -->
                <div>
                    <h3 class="text-blue-600 font-semibold mb-4">Szybkie linki</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="text-gray-600 hover:text-blue-500 text-sm">Regulamin</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-blue-500 text-sm">Polityka prywatności</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 hover:text-blue-500 text-sm">Kontakt</a>
                        </li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-blue-600 font-semibold mb-4">Kontakt</h3>
                    <ul class="space-y-2">
                        <li class="text-gray-600 text-sm">Email: kontakt@myshop.pl</li>
                        <li class="text-gray-600 text-sm">Tel: +48 123 456 789</li>
                        <li class="text-gray-600 text-sm">Adres: ul. Przykładowa 1, 00-001 Warszawa</li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 border-t border-gray-100 pt-8 text-center">
                <p class="text-gray-500 text-sm">
                    &copy; {{ new Date().getFullYear() }} MyShop. Wszystkie prawa zastrzeżone.
                </p>
            </div>
        </div>
    </footer>
</template>
