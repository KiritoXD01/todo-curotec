# Todo Curotec

A modern task management application built with Laravel 12 and Vue 3, featuring a beautiful UI and robust functionality.

## 🚀 Tech Stack

### Backend
- PHP 8.4
- Laravel 12
- Inertia.js
- SQLite (Development)
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
- SQLite (for development)

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

5. Create the database:
```bash
touch database/database.sqlite
```

6. Run migrations:
```bash
php artisan migrate
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

- `composer dev` - Start all development servers
- `composer dev:ssr` - Start development servers with SSR
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

## 🧪 Testing

The project uses Pest PHP for testing. Run tests with:

```bash
composer test
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

## 📚 Documentation

- [Laravel Documentation](https://laravel.com/docs)
- [Vue 3 Documentation](https://vuejs.org/)
- [Inertia.js Documentation](https://inertiajs.com/)
- [TailwindCSS Documentation](https://tailwindcss.com/docs)