# Laravel Vue CRUD - Docker Setup

Prosta aplikacja Laravel z Vue.js uruchamiana w kontenerze Docker z Apache i SQLite.

## Wymagania

- Docker
- Docker Compose

## Uruchomienie

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

## Funkcjonalności

- ✅ Apache web server
- ✅ PHP 8.3
- ✅ SQLite database
- ✅ Laravel framework
- ✅ Vue.js + Inertia.js
- ✅ Automatyczne migracje przy starcie
- ✅ Tailwind CSS
- ✅ Pest testing framework

## Zarządzanie

### Dostęp do kontenera:
```bash
docker-compose exec app bash
```

### Uruchomienie migracji ręcznie:
```bash
docker-compose exec app php artisan migrate
```

### Uruchomienie testów:
```bash
docker-compose exec app php artisan test
```

### Wygenerowanie danych testowych:
```bash
docker-compose exec app php artisan db:seed
```

### Restart aplikacji:
```bash
docker-compose restart app
```

### Zatrzymanie:
```bash
docker-compose down
```

## Struktura projektu

- **Frontend**: Vue.js z Inertia.js
- **Backend**: Laravel API
- **Database**: SQLite (plik w `database/database.sqlite`)
- **Styling**: Tailwind CSS + shadcn-vue
- **Testing**: Pest

## Porty

- **8080**: Aplikacja web (Apache)

## Persistent Data

Baza danych SQLite jest zachowywana w volume, więc dane nie zostaną utracone przy restarcie kontenera.
