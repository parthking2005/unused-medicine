# MedCharity - Medicine Donation Management System

MedCharity is a comprehensive platform that connects medicine donors with NGOs to facilitate the efficient distribution of medicines to those in need.

## System Flows

### 1. Medicine Management Flow
- **Medicine Registration**
  - Medicines are categorized into predefined categories
  - Each medicine has details like name, brand, and category
- **Stock Management**
  - NGOs maintain medicine stock inventory
  - Each stock entry tracks quantity and NGO association
- **Expiration Management**
  - System tracks medicine expiration dates
  - Alerts for medicines nearing expiration
  - Automatic removal of expired medicines from stock
  - Reports on disposed medicines

### 2. Donation Process Flow
- **Donation Initiation**
  - Donator selects NGO and schedules pickup
  - System checks NGO's daily donation limit
- **Pickup Process**
  - NGO assigns available pickupman
  - Pickupman collects medicines from donator
  - Status updates at each step
- **Verification Process**
  - Verifier checks medicine quality and expiry
  - Approved medicines added to NGO stock
  - Feedback recorded for donation
- **Stock Update**
  - Medicine inventory updated after verification
  - Stock levels monitored for reordering

### 3. User Management Flow
- **Role-based Access**
  - Admin: System-wide management
  - NGO Manager: Branch management
  - Pickupman: Collection management
  - Verifier: Medicine verification
  - Donator: Donation management
- **Profile Management**
  - User profile updates
  - Contact information management
  - Profile image handling
- **Authentication**
  - Secure login system
  - Password reset functionality
  - Remember me feature

### 4. NGO Branch Management Flow
- **Branch Operations**
  - Branch profile management
  - Staff assignment (managers, pickupmen, verifiers)
  - Daily donation limit (DPD) management
- **Performance Tracking**
  - Branch-wise donation statistics
  - Staff performance metrics
  - Resource utilization reports
- **Resource Allocation**
  - Medicine stock distribution
  - Staff workload management
  - Inter-branch medicine transfers

### 5. Feedback System Flow
- **Feedback Collection**
  - Categorized feedback system
  - Detailed feedback descriptions
  - Feedback linked to specific donations
- **Quality Control**
  - Bad feedback tracking
  - Donator reputation management
  - Automatic blocking of problematic donators
- **Improvement Tracking**
  - Feedback analysis reports
  - Service quality metrics
  - Improvement recommendations

### 6. Emergency Request Flow
- **Urgent Needs**
  - Priority medicine requests
  - Emergency pickup scheduling
  - Real-time status tracking
- **Quick Response**
  - Immediate pickupman assignment
  - Priority verification process
  - Expedited stock updates
- **Emergency Coordination**
  - Inter-branch coordination
  - Emergency contact system
  - Rapid response tracking

### 7. Reporting and Analytics Flow
- **Operational Reports**
  - Daily donation summaries
  - Stock level reports
  - Staff activity logs
- **Performance Analytics**
  - NGO performance metrics
  - Donation trend analysis
  - Medicine demand patterns
- **Strategic Insights**
  - Resource optimization suggestions
  - Service improvement recommendations
  - Growth opportunity identification

### 8. Communication Flow
- **Internal Communication**
  - Staff messaging system
  - Task notifications
  - Status updates
- **External Communication**
  - Donator notifications
  - Public messages
  - Contact form handling
- **Alert System**
  - Stock alerts
  - Expiry notifications
  - Emergency broadcasts

## Getting Started

### Prerequisites
- PHP >= 7.4
- Laravel >= 8.0
- MySQL >= 5.7
- Composer
- Node.js and NPM

### Installation
1. Clone the repository
```bash
git clone https://github.com/yourusername/medcharity.git
```

2. Install PHP dependencies
```bash
composer install
```

3. Install JavaScript dependencies
```bash
npm install
```

4. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

5. Set up database
```bash
php artisan migrate
php artisan db:seed
```

6. Start development server
```bash
php artisan serve
```

## Contributing
Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct and the process for submitting pull requests.

## License
This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details