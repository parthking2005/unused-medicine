# MedCharity - System Flows and Role Access Guide

## Roles Overview

### 1. Admin
**Access Level**: System-wide access
**Registration**: Direct registration
**Login URL**: `/admin/login`

#### How to Register Admin:
```
URL: /admin/register
Required Fields:
- Name
- Email (unique)
- Password (min 6 characters)
- Password Confirmation
```

#### Admin Capabilities:
- Register NGO managers
- Manage NGOs
- View system-wide statistics
- Manage medicine categories
- View contact messages
- Block/unblock donators

### 2. NGO Manager
**Access Level**: NGO-specific access
**Registration**: By Admin only
**Login URL**: `/ngo/manager/login`

#### How to Register Manager:
```
URL: /admin/registermanager (Admin access only)
Required Fields:
- Name
- Email (unique)
- NGO Branch (select)
- Profile Image
```

#### Registration Process:
1. Admin registers manager
2. Manager receives email with token
3. Manager creates password using token at `/ngo/manager/createpassword`
4. Manager can then login

#### Manager Capabilities:
- Register pickupmen
- Register verifiers
- Manage medicine stock
- View NGO statistics
- Manage donations
- Assign pickupmen to donations

### 3. Pickupman
**Access Level**: NGO-specific access
**Registration**: By NGO Manager only
**Login URL**: `/ngo/pickupman/login`

#### How to Register Pickupman:
```
URL: /ngo/manager/registerpickupman (Manager access only)
Required Fields:
- Name
- Email (unique)
- Contact Number
- Profile Image
```

#### Registration Process:
1. Manager registers pickupman
2. Pickupman receives email with token
3. Pickupman creates password using token at `/ngo/pickupman/createpassword`
4. Pickupman can then login

#### Pickupman Capabilities:
- View assigned donations
- Update donation status
- Manage pickup schedule
- Update availability status

### 4. Verifier
**Access Level**: NGO-specific access
**Registration**: By NGO Manager only
**Login URL**: `/ngo/verifier/login`

#### How to Register Verifier:
```
URL: /ngo/manager/registerverifier (Manager access only)
Required Fields:
- Name
- Email (unique)
- Profile Image
```

#### Registration Process:
1. Manager registers verifier
2. Verifier receives email with token
3. Verifier creates password using token at `/ngo/verifier/createpassword`
4. Verifier can then login

#### Verifier Capabilities:
- Verify donations
- Add medicines to stock
- Provide feedback
- Manage medicine categories
- Check medicine quality

### 5. Donator
**Access Level**: Public access with registration
**Registration**: Self-registration
**Login URL**: `/login`

#### How to Register Donator:
```
URL: /register
Required Fields:
- Name
- Email (unique)
- Password
- Contact Number
- Address
- City
- State
- Pincode
- Profile Image
```

#### Donator Capabilities:
- Make donations
- View donation history
- Update profile
- View feedback

## Access Control Rules

### 1. NGO Access
- Each NGO has one manager
- Manager can only access their NGO data
- Pickupmen and verifiers are NGO-specific
- NGOs have daily donation limits (DPD)

### 2. Medicine Management
- Only verifiers can add medicines to stock
- Managers can view and manage stock
- Expired medicines require disposal records
- Medicine categories are system-wide

### 3. Donation Process
1. **Donation Initiation**
   - Donator selects NGO
   - System checks NGO's daily limit
   - Donation date is scheduled

2. **Pickup Process**
   - Manager assigns pickupman
   - Pickupman updates collection status
   - Real-time status updates

3. **Verification Process**
   - Verifier checks medicines
   - Updates stock if approved
   - Records feedback
   - Manages expiry dates

### 4. Security Rules
1. **Authentication**
   - All roles require email verification
   - Password minimum length: 6 characters
   - Profile images required for all except admin
   - Token-based password creation for staff

2. **Authorization**
   - Role-based access control
   - NGO-specific data isolation
   - Middleware protection on all routes
   - Session management

3. **Data Protection**
   - Unique email enforcement
   - Profile image validation
   - Input sanitization
   - CSRF protection

## Common Workflows

### 1. Medicine Donation
```
Donator -> Select NGO -> Schedule Pickup -> Pickupman Collects -> 
Verifier Checks -> Stock Update -> Feedback
```

### 2. Staff Registration
```
Admin/Manager Creates Account -> Email with Token -> 
Staff Creates Password -> Staff Logs In
```

### 3. Medicine Expiry Management
```
Verifier Checks Stock -> Identifies Expiring Items -> 
Manager Approves -> Disposal Record -> Stock Update
```

### 4. Feedback System
```
Verifier Creates Feedback -> System Updates Donator Stats -> 
Admin Reviews -> Action if Needed
```

## Error Handling

### 1. Registration Errors
- Duplicate email addresses
- Invalid image formats
- Missing required fields
- Password confirmation mismatch

### 2. Authentication Errors
- Invalid credentials
- Expired tokens
- Session timeouts
- Unauthorized access attempts

### 3. Process Errors
- NGO daily limit exceeded
- Invalid medicine data
- Stock discrepancies
- Failed email notifications

## Best Practices

1. **Profile Management**
   - Keep contact information updated
   - Use professional profile images
   - Change passwords regularly
   - Enable notifications

2. **Donation Management**
   - Schedule pickups in advance
   - Provide accurate medicine details
   - Follow packaging guidelines
   - Keep donation records

3. **System Usage**
   - Regular stock audits
   - Timely feedback submission
   - Prompt status updates
   - Clear communication

## Support and Help

For technical support or queries:
- Email: support@medcharity.com
- Contact: System Administrator
- Help Desk: Available in admin panel
- Documentation: Available in system

---

Note: This documentation is maintained by the MedCharity team. For updates or clarifications, please contact the system administrator.
