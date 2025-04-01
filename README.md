# MDC ProCollege System

A comprehensive platform for managing funding, releases, and construction progress for Model Degree Colleges (MDCs) and Professional Colleges under the RUSA scheme.

<p align="center">
<img src="public/images/logo.png" width="400" alt="MDC ProCollege System Logo">
</p>

## About The Project

The MDC ProCollege System is designed to facilitate transparent administration of college development grants, construction progress monitoring, and financial tracking for educational institutions. The system helps manage the entire lifecycle of funding allocation, releases, bill submissions, and construction progress tracking.

### Key Features

- Multi-role authentication (Admin, College, RUSA)
- College registration and management
- Funding allocation and tracking
- Fund release management
- Bill submission and approval workflow
- Payment processing and tracking
- Construction progress monitoring
- Comprehensive reporting and analytics

## Getting Started

Follow these instructions to set up the project on your local machine for development and testing.

### Prerequisites

- PHP 8.0 or higher
- MySQL 5.7 or higher
- Composer
- Node.js and NPM
- Web server (Apache/Nginx)

### Installation

1. Clone the repository
   ```
   git clone https://github.com/your-organization/mdc-procollege-system.git
   cd mdc-procollege-system
   ```

2. Install PHP dependencies
   ```
   composer install
   ```

3. Install and compile frontend assets
   ```
   npm install
   npm run dev
   ```

4. Create and configure your environment file
   ```
   cp .env.example .env
   ```
   Then edit the `.env` file to set your database connection details.

5. Generate application key
   ```
   php artisan key:generate
   ```

6. Run database migrations and seed data
   ```
   php artisan migrate
   php artisan db:seed
   ```

7. Configure permissions for storage and cache directories
   ```
   chmod -R 775 storage bootstrap/cache
   ```

8. Start the development server
   ```
   php artisan serve
   ```

9. Access the application at http://localhost:8000

### Default Credentials

After seeding the database, you can log in with the following default credentials:

- **Admin Account**
  - Email: admin@example.com
  - Password: password

- **College Account (for testing)**
  - Email: college@example.com
  - Password: password

- **RUSA Account (for testing)**
  - Email: rusa@example.com
  - Password: password

**Important:** Change these default passwords immediately after first login.

## Usage Guidelines

- **Admin Users:** Manage system configuration, users, colleges, funding, and approvals
- **College Users:** Submit bills, track progress, view funding and payment status
- **RUSA Users:** Monitor progress across colleges, view reports and funding status

## Deployment

For production deployment:

1. Set appropriate values in your production `.env` file
2. Compile assets for production
   ```
   npm run build
   ```
3. Configure your web server to point to the `public` directory
4. Set up a database backup strategy
5. Configure proper security settings for production environment

## Documentation

For detailed documentation about the system architecture, database schema, and workflows, refer to the project documentation in the `.cursor/rules/mdc-project-docs.md` file.

## Contributing

1. Create a feature branch (`git checkout -b feature/amazing-feature`)
2. Commit your changes (`git commit -m 'Add some amazing feature'`)
3. Push to the branch (`git push origin feature/amazing-feature`)
4. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgments

- [RUSA (Rashtriya Uchchatar Shiksha Abhiyan)](https://www.education.gov.in/en/rusa) for providing the framework for this system
- [Laravel](https://laravel.com) - The web framework used
- [Tailwind CSS](https://tailwindcss.com) - For UI components

## Contact

Project Maintainer - [your-email@example.com](mailto:your-email@example.com)

Project Link: [https://github.com/your-organization/mdc-procollege-system](https://github.com/your-organization/mdc-procollege-system)
