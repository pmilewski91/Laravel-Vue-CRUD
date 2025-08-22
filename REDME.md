# Laravel Vue Shop 🛍️

Prosty sklep internetowy zbudowany w Laravel 12 z wykorzystaniem Starter Kit Vue. Aplikacja umożliwia zarządzanie produktami z pełną funkcjonalnością CRUD oraz ich wyświetlanie w przyjaznym interfejsie.

## ✨ Funkcjonalności

- 📋 **Wyświetlanie produktów** - Lista wszystkich dostępnych produktów
- ➕ **Dodawanie produktów** - Tworzenie nowych produktów
- ✏️ **Edycja produktów** - Modyfikacja istniejących produktów
- 🗑️ **Usuwanie produktów** - Bezpieczne usuwanie produktów
- 📱 **Responsywny design** - Działa na wszystkich urządzeniach
- 🔐 **Autoryzacja** - Bezpieczne zarządzanie dostępem

## 🛠️ Technologie

- **Backend:** Laravel 12
- **Frontend:** Vue.js 3 (Laravel Starter Kit)
- **Baza danych:** MySQL/PostgreSQL/SQLite
- **Stylowanie:** Tailwind CSS
- **Autoryzacja:** Laravel Sanctum/Breeze
- **Routing:** Inertia.js

## 📋 Wymagania systemowe

- PHP >= 8.2
- Composer
- Node.js >= 18.0
- NPM lub Yarn
- MySQL >= 8.0 lub PostgreSQL >= 13 lub SQLite

## 🚀 Instalacja

### 1. Sklonuj repozytorium
```bash
git clone https://github.com/pmilewski91/Laravel-Vue-CRUD.git
cd Laravel-Vue-CRUD
```

### 2. Zainstaluj zależności PHP
```bash
composer install
```

### 3. Zainstaluj zależności Node.js
```bash
npm install
# lub
yarn install
```

### 4. Konfiguracja środowiska
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Skonfiguruj bazę danych
Edytuj plik `.env` i ustaw parametry bazy danych:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_shop
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 6. Uruchom migracje
```bash
php artisan migrate
```


### 7. Uruchom serwer developerski
```bash
composer run dev
```

Aplikacja będzie dostępna pod adresem: `http://localhost:8000`


