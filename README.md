# Hospitality College System

A comprehensive Laravel-based management system for hospitality colleges, featuring student management, course enrollment, library services, staff administration, and financial tracking.

## Features

- **Student Management**: Complete student lifecycle management
- **Course Enrollment**: Online learning dashboard with enrollment tracking
- **Library System**: Book catalog and management
- **Staff Administration**: Staff records and role management
- **Financial Management**: QuickBooks integration for accounting
- **Reporting System**: Comprehensive reports and analytics
- **Role-Based Access**: Advanced permission system using Spatie Laravel Permission

## Tech Stack

- **Backend**: Laravel 12.x
- **Frontend**: Blade templates with TailwindCSS
- **UI Components**: Filament for admin panels
- **Real-time**: Livewire for dynamic interactions
- **Authentication**: Laravel Sanctum
- **Queue Management**: Laravel Horizon
- **Database**: MySQL/SQLite

## Installation

1. Clone the repository
```bash
git clone https://github.com/CKMatsika/hospitality-college-system.git
cd hospitality-college-system
```

2. Install dependencies
```bash
composer install
npm install
```

3. Environment setup
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure your database in `.env` file

5. Run migrations
```bash
php artisan migrate
```

6. Build assets
```bash
npm run build
```

7. Start the development server
```bash
php artisan serve
```

## Quick Start Scripts

- `composer run setup` - Complete installation and setup
- `composer run dev` - Start development server with queues and asset building
- `composer run test` - Run test suite

## Project Structure

```
├── app/                 # Application core
├── database/           # Database migrations and seeders
├── resources/views/    # Blade templates
├── routes/             # Application routes
├── storage/            # File storage
└── public/             # Public assets
```

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support and questions, please open an issue on GitHub.
