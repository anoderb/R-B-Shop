# R-B Shop

R-B Shop is an e-commerce web application built with CodeIgniter 4, featuring user authentication, payment integration with Midtrans, and reporting capabilities using PHPSpreadsheet and TCPDF.

## Features

- User Authentication (Myth/Auth)
- Product Management
- Shopping Cart
- Secure Payment Processing (Midtrans)
- Order Management
- PDF Report Generation (TCPDF)
- Excel Report Export (PHPSpreadsheet)
- Responsive Design

## Prerequisites

- PHP >= 7.4
- Composer
- MySQL/MariaDB
- Node.js (optional, for asset compilation)
- Midtrans Account (for payment processing)

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/anoderb/R-B-Shop.git
   cd R-B-Shop
   ```

2. Install dependencies:

   ```bash
   composer install
   ```

3. Set up environment file:

   - Copy `.env.example` to `.env`
   - Configure your database settings
   - Add Midtrans configuration:

     ```env
     # Midtrans Configuration
     midtrans.serverKey = SB-Mid-server-AoZtrXWQVeCymsD_SEwpPbRS
     midtrans.clientKey = SB-Mid-client-jf9Jkm-Rly43CyXs
     midtrans.isProduction = false
     midtrans.isSanitized = true
     midtrans.is3ds = true
     ```

4. Run database migrations:

   ```bash
   php spark migrate
   ```

5. Run database seeder (if available):

   ```bash
   php spark db:seed InitialSeeder
   ```

## Core Dependencies

- [CodeIgniter 4](https://codeigniter.com/): PHP web framework
- [Myth/Auth](https://github.com/lonnieezell/myth-auth): Authentication system
- [Midtrans PHP](https://github.com/Midtrans/midtrans-php): Payment gateway integration
- [PHPSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet): Excel file generation
- [TCPDF](https://github.com/tecnickcom/TCPDF): PDF file generation

## Key Features Explanation

### 1. Authentication (Myth/Auth)

- User registration and login
- Role-based access control
- Remember me feature

### 2. Payment Integration (Midtrans)

- Secure payment processing
- Multiple payment methods support
- Transaction status handling

### 3. Reporting

- Generate PDF reports using TCPDF
- Export data to Excel using PHPSpreadsheet
- Various report formats available
- Customizable templates

## Directory Structure

```
R-B-Shop/
├── app/
│   ├── Config/
│   ├── Controllers/
│   ├── Models/
│   └── Views/
├── public/
│   ├── assets/
│   └── uploads/
├── tests/
├── vendor/
├── composer.json
└── .env
```

## Configuration

### Database Setup

Update the following in your `.env` file:

```env
database.default.hostname = localhost
database.default.database = rb_shop
database.default.username = your_username
database.default.password = your_password
```

### Email Configuration (for password reset)

```env
email.fromEmail = your_email@domain.com
email.fromName = 'R-B Shop'
email.SMTPHost = your_smtp_host
email.SMTPUser = your_smtp_user
email.SMTPPass = your_smtp_password
```

## Usage

### Running the Application

```bash
php spark serve
```

Access the application at `http://localhost:8080`

### Admin Access

- Default admin login:
  - Email: admin@gmail.com
  - Password: Bandulan112


```bash
composer test
```


## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For support, please email support@rbshop.com or open an issue in the GitHub repository.

## Credits

- [Myth/Auth](https://github.com/lonnieezell/myth-auth)
- [Midtrans](https://midtrans.com/)
- [PHPSpreadsheet](https://phpspreadsheet.readthedocs.io/)
- [TCPDF](https://tcpdf.org/)
