# Database Schema Documentation

## Tables and Columns

### Admins Table
- **id**: Primary key
- **name**: String (nullable)
- **email**: String (unique)
- **password**: String
- **rememberToken**: Token for remembering sessions
- **timestamps**: Created at and updated at timestamps

### NGOs Table
- **id**: Primary key
- **name**: String
- **address**: LongText
- **city**: String
- **state**: String
- **pincode**: Integer
- **dpd**: Integer (unsigned, default 2) - Donations per day limit
- **timestamps**: Created at and updated at timestamps

### Managers Table
- **id**: Primary key
- **ngo_id**: Foreign key referencing NGOs
- **name**: String
- **email**: String (unique)
- **password**: String
- **contact**: String
- **gender**: String
- **profileimage**: String
- **rememberToken**: Token for remembering sessions
- **timestamps**: Created at and updated at timestamps

### Medicine Categories Table
- **id**: Primary key
- **name**: String
- **timestamps**: Created at and updated at timestamps

### Medicines Table
- **id**: Primary key
- **category_id**: Foreign key referencing medicine_categories
- **name**: String
- **brand**: String
- **timestamps**: Created at and updated at timestamps

### Medicine Stocks Table
- **id**: Primary key
- **ngo_id**: Foreign key referencing NGOs
- **medicine_id**: Foreign key referencing Medicines
- **qty**: Integer
- **timestamps**: Created at and updated at timestamps

### Donators Table
- **id**: Primary key
- **name**: String
- **email**: String (unique)
- **password**: String
- **contact**: String (10 characters, unique)
- **gender**: String (10 characters)
- **address**: String
- **city**: String
- **state**: String
- **pincode**: String (6 characters)
- **profileimage**: String
- **token**: String (20 characters, nullable)
- **bfcount**: Integer (default 0) - Bad feedback count
- **blocked**: Boolean (default false)
- **rememberToken**: Token for remembering sessions
- **timestamps**: Created at and updated at timestamps

### Donations Table
- **id**: Primary key
- **donator_id**: Foreign key referencing Donators
- **ngo_id**: Foreign key referencing NGOs
- **pickupman_id**: Foreign key referencing Pickupmen
- **verifier_id**: Foreign key referencing Verifiers
- **date**: Date
- **status**: String
- **timestamps**: Created at and updated at timestamps

### Pickupmen Table
- **id**: Primary key
- **ngo_id**: Foreign key referencing NGOs
- **name**: String
- **email**: String (unique)
- **password**: String
- **contact**: String
- **gender**: String
- **profileimage**: String
- **available**: Boolean
- **rememberToken**: Token for remembering sessions
- **timestamps**: Created at and updated at timestamps

### Verifiers Table
- **id**: Primary key
- **ngo_id**: Foreign key referencing NGOs
- **name**: String
- **email**: String (unique)
- **password**: String
- **contact**: String
- **gender**: String
- **profileimage**: String
- **rememberToken**: Token for remembering sessions
- **timestamps**: Created at and updated at timestamps

### Feedback Categories Table
- **id**: Primary key
- **name**: String
- **timestamps**: Created at and updated at timestamps

### Feedback Table
- **id**: Primary key
- **donation_id**: Foreign key referencing Donations
- **category_id**: Foreign key referencing Feedback Categories
- **description**: Text
- **timestamps**: Created at and updated at timestamps

### Messages Table
- **id**: Primary key
- **message**: String
- **name**: String
- **email**: String (unique)
- **subject**: String
- **visibility**: Boolean (default true)
- **timestamps**: Created at and updated at timestamps

## Key Relationships

1. **NGO Relationships**:
   - Has one Manager
   - Has many Pickupmen
   - Has many Verifiers
   - Has many Medicine Stocks
   - Has many Donations

2. **Medicine Relationships**:
   - Belongs to Medicine Category
   - Has many Medicine Stocks
   - Medicine Stocks belong to NGOs

3. **Donation Relationships**:
   - Belongs to Donator
   - Belongs to NGO
   - Belongs to Pickupman
   - Belongs to Verifier
   - Has one Feedback
   - Feedback belongs to Feedback Category

## Application Flow

1. **Medicine Management Flow**:
   - Medicines are categorized into Medicine Categories
   - NGOs maintain Medicine Stocks for each medicine
   - Each medicine stock tracks quantity for a specific NGO

2. **Donation Process Flow**:
   - Donator initiates a donation
   - NGO assigns a Pickupman for collection
   - Pickupman collects the medicines
   - Verifier verifies the donation
   - Feedback is recorded for the donation
   - Medicine stock is updated after verification

3. **User Management Flow**:
   - Admin manages overall system
   - Each NGO has one Manager
   - NGOs have multiple Pickupmen and Verifiers
   - Donators can be blocked based on bad feedback count (bfcount)

4. **Feedback System**:
   - Feedback is categorized using Feedback Categories
   - Each donation can receive feedback
   - Bad feedback affects donator's status (bfcount and blocked status)

5. **Communication Flow**:
   - Messages system for general communication
   - Each user type (Admin, Manager, Donator, etc.) has their own authentication
   - NGOs have a daily donation limit (dpd - donations per day)