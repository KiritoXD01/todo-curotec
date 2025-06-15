# Todo Curotec

A modern task management application built with Laravel 12 and Vue 3, featuring a beautiful UI and robust functionality.

## 🚀 Tech Stack

### Backend
- PHP 8.4
- Laravel 12
- Inertia.js
- PostgreSQL 16
- Pest PHP for testing

### Frontend
- Vue 3 with TypeScript
- Inertia.js
- TailwindCSS 4
- Shadcn Vue
- Pinia for state management
- VeeValidate with Zod for form validation
- Vue Sonner for toast notifications
- SweetAlert2 for beautiful alerts

## 📋 Prerequisites

- PHP 8.4 or higher
- Node.js (Latest LTS version recommended)
- Composer
- PostgreSQL 16

## 🛠️ Installation

1. Clone the repository:
```bash
git clone [repository-url]
cd todo-curotec
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node.js dependencies:
```bash
npm install
```

4. Set up your environment:
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure your database:
```bash
# Update .env with your PostgreSQL credentials
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=todo_curotec
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run migrations:
```bash
php artisan migrate --seed
```

7. Start the development server:
```bash
composer run dev
```

This will start:
- Laravel development server
- Vite development server
- Queue worker

## 🏗️ Development

### Available Scripts

- `composer run dev` - Start all development servers
- `composer run dev:ssr` - Start development servers with SSR
- `npm run build` - Build for production
- `npm run build:ssr` - Build for production with SSR
- `npm run format` - Format code using Prettier
- `npm run lint` - Lint code using ESLint
- `composer test` - Run tests

### Code Style

The project uses:
- Laravel Pint for PHP code style
- Prettier for JavaScript/TypeScript code style
- ESLint for JavaScript/TypeScript linting

### Laravel Pint

Laravel Pint is an opinionated PHP code style fixer for minimalists. It's built on top of PHP-CS-Fixer and provides a simple way to ensure your code follows Laravel's coding standards.

To format your PHP code:
```bash
./vendor/bin/pint
```

To check code style without making changes:
```bash
./vendor/bin/pint --test
```

The configuration is stored in `pint.json` in the project root.

## 🧪 Testing

The project uses Pest PHP for testing. Run tests with:

```bash
php artisan test
```

## 📦 Production Deployment

1. Build the frontend assets:
```bash
npm run build
```

2. Optimize Laravel:
```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
```

3. Set up your production environment variables in `.env`

## 🔧 Configuration

Key configuration files:
- `.env` - Environment variables
- `config/app.php` - Application configuration
- `vite.config.ts` - Vite configuration
- `tailwind.config.js` - TailwindCSS configuration

### Herd Configuration

The project uses [Laravel Herd](https://herd.laravel.com/) for local development. The `herd.yml` file configures the development environment:

```yaml
name: todo-curotec
php: '8.4'
secured: true
services:
    postgresql:
        version: '16'
        port: '${DB_PORT}'
```

This configuration:
- Sets the project name
- Specifies PHP 8.4 as the runtime
- Enables HTTPS for secure development
- Configures PostgreSQL 16 as the database service
- Uses the database port from environment variables

To use Herd:
1. Install [Laravel Herd](https://herd.laravel.com/)
2. Place the `herd.yml` file in your project root
3. Run `herd start` to start the development environment

### Alternative: Using DBngin with Free Herd License

If you're using the free version of Herd (which doesn't include database services), you can use [DBngin](https://dbngin.com/) to manage PostgreSQL:

1. Install [DBngin](https://dbngin.com/)
2. Add a new PostgreSQL 16 instance:
   - Click "Add Instance"
   - Select PostgreSQL 16
   - Set port to 5432 (or your preferred port)
   - Click "Create"

3. Update your `.env` file to use the DBngin PostgreSQL instance:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=todo_curotec
DB_USERNAME=postgres
DB_PASSWORD=
```

4. Create the database:
```bash
psql -U postgres -h 127.0.0.1 -p 5432
CREATE DATABASE todo_curotec;
\q
```

5. Run migrations:
```bash
php artisan migrate --seed
```

DBngin provides a user-friendly interface to manage your PostgreSQL instance and includes features like:
- Database version management
- Easy start/stop controls
- Port management
- Data directory configuration
- Log viewing

## 📚 Documentation

- [Laravel Documentation](https://laravel.com/docs)
- [Vue 3 Documentation](https://vuejs.org/)
- [Inertia.js Documentation](https://inertiajs.com/)
- [TailwindCSS Documentation](https://tailwindcss.com/docs)