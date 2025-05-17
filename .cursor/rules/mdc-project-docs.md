description: Detailed project documentation including architecture, features, and workflows
globs: 
alwaysApply: false
---
# MDC ProCollege System - Project Documentation

## 1. Project Overview

The MDC ProCollege System is a comprehensive platform designed to manage and track the funding, releases, and construction progress for Model Degree Colleges (MDCs) and Professional Colleges under the RUSA (Rashtriya Uchchatar Shiksha Abhiyan) scheme. The system facilitates transparent administration of college development grants, construction progress monitoring, and financial tracking.

## 2. System Architecture

### 2.1 Technology Stack
- **Backend Framework**: Laravel (PHP)
- **Frontend**: Blade templates with Tailwind CSS
- **Database**: MySQL
- **Authentication**: Laravel's built-in authentication with custom guards
- **Deployment**: Web server with PHP 8.0+ and MySQL 5.7+

### 2.2 Component Architecture
The system follows an MVC (Model-View-Controller) architecture with:
- **Models**: Represent database entities (College, Funding, Bill, etc.)
- **Controllers**: Handle user requests and business logic
- **Views**: Present data to users through Blade templates
- **Middleware**: Manages authentication, roles, and permissions

### 2.3 Module Structure
The application is organized into the following key modules:
- Authentication and User Management
- College Management
- Funding and Release Management
- Bills and Payment Processing
- Progress Tracking and Reporting
- Administration Dashboard

## 3. Key Features and Functionality

### 3.1 User Management
- Multi-role authentication (Admin, College, RUSA)
- Role-based access control
- Secure login with password hashing
- Session management and remember-me functionality
- Audit logging of important user actions (especially admin actions)

### 3.2 College Management
- Registration and management of colleges
- Categorization by type (MDC, Professional) and phase (1, 2)
- Geographic organization by state and district
- College profile management
- Audit logging for sensitive operations

### 3.3 Funding Management
- Allocation of funds to colleges based on type and phase
- Tracking of approved amounts with central and state shares
- Funding utilization status monitoring
- Budget allocation by predefined formulas:
  - MDC Phase 1: 8 crores (Central:State = 50:50)
  - MDC Phase 2: 12 crores (Central:State = 90:10)
  - Professional Colleges: 26 crores (Central:State = 90:10)

### 3.4 Fund Release Management
- Recording of fund release transactions
- Release tracking against allocated funding
- Remaining balance calculations
- Release history and timeline visualization

### 3.5 Bill Management
- Bill submission by colleges
- Approval workflow with multi-stage verification
- Bill status tracking (pending, approved, rejected, paid)
- Supporting documentation management
- Admin remarks and feedback system

### 3.6 Payment Processing
- Payment recording and tracking
- Payment status management (pending, processed, completed, rejected)
- Transaction reference management
- Payment history and reporting

### 3.7 Construction Progress Tracking
- Work categorization for different construction phases
- Bill progress tracking for work reported with each bill
- Physical progress tracking for actual construction progress
- Completion percentage monitoring
- Progress verification and validation
- Progress timeline visualization

### 3.8 Reporting and Analytics
- Financial summary dashboards
- Progress reports by college and region
- Fund utilization analysis
- Construction milestone tracking
- Export functionality for reports (PDF, Excel)

## 4. User Roles and Permissions

### 4.1 Admin
- System administration and configuration
- User management (create, edit, deactivate)
- College registration and management
- Funding allocation and approval
- Release management and approval
- Bill verification and approval
- Payment processing
- Report generation and export
- System-wide data access and management

### 4.2 College User
- College profile management
- View allocated funding and releases
- Submit and track bills
- Report construction progress
- View payment status
- Generate college-specific reports
- Limited to data related to their college only

### 4.3 RUSA User
- View all colleges and their funding details
- Monitor construction progress across colleges
- Review bills and payment statuses
- Generate regional and cross-college reports
- Cannot modify data, primarily a monitoring role

## 5. Workflow Descriptions

### 5.1 College Funding Process
1. Admin registers a new college with type and phase
2. System automatically calculates eligible funding based on type/phase
3. Admin creates funding allocation record with approved amount
4. Admin records releases against the funding allocation
5. College users can view their funding and release history

### 5.2 Bill Submission and Payment
1. College user submits a bill with details and documentation
2. Admin reviews the bill and approves/rejects with remarks
3. If approved, admin processes payment against the bill
4. College user receives notification of bill status changes
5. College user can track payment status
6. Admin finalizes payment with transaction reference

### 5.3 Construction Progress Tracking
1. Admin sets up work categories for construction phases
2. College user reports progress with each bill submission
3. Admin or RUSA representative verifies reported progress
4. System tracks completion percentage by work category
5. Progress status is updated (not started, in progress, completed)
6. System visualizes progress through timelines and charts

## 6. Technical Specifications

### 6.1 Database Design
The system uses a relational database with 12 primary entities:
- Admin
- User
- College
- Funding
- Release
- Bill
- Payment
- WorkCategory
- BillProgress
- PhysicalProgress
- Session
- AuditLog

See the database schema documentation for detailed structure and relationships.

### 6.2 API Endpoints
The system provides RESTful API endpoints for core functionality:
- User authentication
- College data retrieval
- Funding and release management
- Bill submission and tracking
- Progress reporting
- Payment processing

### 6.3 Security Features
- CSRF protection
- Input validation and sanitization
- Secure password hashing
- Role-based access control
- Session timeout and management
- Audit logging for sensitive operations and data changes

## 7. Installation and Setup

### 7.1 System Requirements
- PHP 8.0 or higher
- MySQL 5.7 or higher
- Composer for dependency management
- Web server (Apache/Nginx)
- Node.js and NPM for frontend assets

### 7.2 Installation Steps
1. Clone the repository
2. Run `composer install` to install PHP dependencies
3. Run `npm install` and `npm run dev` for frontend assets
4. Configure .env file with database settings
5. Run migrations with `php artisan migrate`
6. Seed the database with `php artisan db:seed`
7. Generate application key with `php artisan key:generate`
8. Configure web server to point to the public directory
9. Set appropriate permissions on storage and bootstrap/cache

### 7.3 Initial Configuration
1. Log in with default admin credentials
2. Change default password
3. Configure system settings
4. Add colleges and users
5. Set up funding allocations
6. Define work categories

## 8. Future Development Plans

### 8.1 Planned Features
- Mobile application for field progress reporting
- Integration with government payment gateways
- Advanced analytics and data visualization
- Student information management system
- Department and course management
- Document management system
- Real-time notifications
- API integrations with external systems

### 8.2 Planned Entities
The system roadmap includes expansion to educational management with:
- Student management
- Department management
- Course management
- Faculty management
- Academic calendar and scheduling
- Attendance and performance tracking

## 9. Support and Maintenance

### 9.1 Troubleshooting
- Common issues and solutions
- Error logging and monitoring
- System health checks

### 9.2 Backup and Recovery
- Database backup procedures
- System configuration backup
- Disaster recovery procedures

### 9.3 Contact Information
- Technical support contacts
- Maintenance team details
- Feature request submission process

---

*Document Version: 1.0.0*  
*Last Updated: 2025-05-15*  
*Author: MDC ProCollege System Development Team* 