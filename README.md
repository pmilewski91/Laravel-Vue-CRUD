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

## Lub skorzystanie z DOCKERA

### Wymagania

- Docker
- Docker Compose

### Uruchomienie

1. **Sklonuj repozytorium:**
   ```bash
   git clone <repository-url>
   cd lara-vue-crud
   ```

2. **Skopiuj plik środowiska:**
   ```bash
   cp .env.example .env
   ```

3. **Zbuduj i uruchom kontener:**
   ```bash
   docker-compose up --build
   ```

4. **Aplikacja będzie dostępna pod adresem:**
   ```
   http://localhost:8080
   ```

### Funkcjonalności

- ✅ Apache web server
- ✅ PHP 8.3
- ✅ SQLite database
- ✅ Laravel framework
- ✅ Vue.js + Inertia.js
- ✅ Automatyczne migracje przy starcie
- ✅ Tailwind CSS
- ✅ Pest testing framework

### Zarządzanie

#### Dostęp do kontenera:
```bash
docker-compose exec app bash
```

#### Uruchomienie migracji ręcznie:
```bash
docker-compose exec app php artisan migrate
```

#### Uruchomienie testów:
```bash
docker-compose exec app php artisan test
```

#### Wygenerowanie danych testowych:
```bash
docker-compose exec app php artisan db:seed
```

#### Restart aplikacji:
```bash
docker-compose restart app
```

#### Zatrzymanie:
```bash
docker-compose down
```

### Struktura projektu

- **Frontend**: Vue.js z Inertia.js
- **Backend**: Laravel API
- **Database**: SQLite (plik w `database/database.sqlite`)
- **Styling**: Tailwind CSS + shadcn-vue
- **Testing**: Pest

### Porty

- **8080**: Aplikacja web (Apache)

### Persistent Data

Baza danych SQLite jest zachowywana w volume, więc dane nie zostaną utracone przy restarcie kontenera.



