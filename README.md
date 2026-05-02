# Transaction Tracker & E-Commerce Platform

A comprehensive Django-based system for tracking daily business transactions and managing an online e-commerce store. This platform handles sales, purchases, income, expenses, banking transactions, and provides a full-featured e-commerce solution with multiple payment methods.

## 🚀 Quick Start

```bash
# Clone the repository
git clone https://github.com/A5806568884/Transaction_Tracker.git
cd Transaction_Tracker

# Install dependencies
pip install -r requirements.txt

# Run migrations
python manage.py migrate

# Create a superuser
python manage.py createsuperuser

# Start the development server
python manage.py runserver
```

Visit `http://127.0.0.1:8000/admin/` to access the admin panel.

## ✨ Features

### Transaction Tracking
- **Daily Sales Tracking**: Record all sales transactions with customer details, product information, and amounts
- **Purchase Management**: Track supplier purchases and inventory procurement
- **Income Recording**: Monitor all income sources and revenue streams
- **Expense Tracking**: Keep detailed records of business expenses
- **Banking Transactions**: Comprehensive banking transaction logs with reference numbers and balance tracking

### E-Commerce Platform
- **Product Management**: Organize products in categories (Mobiles, Computers, Accessories, etc.)
- **Shopping Cart**: Full-featured cart with add, remove, and update functionality
- **Order Processing**: Complete order management system with status tracking
- **Customer Profiles**: Detailed customer information and order history

### Payment Processing
- **Multiple Payment Methods**:
  - Credit Card payments
  - Bank Account transfers
  - Branchless Banking (Mobile wallets like Easypaisa, JazzCash)
  - Cash on Delivery
- **Payment Processing**: Track payment status and transactions
- **Refund Management**: Handle refunds with detailed tracking

## 💻 Technology Stack

- **Backend**: Django 4.2
- **API**: Django REST Framework
- **Database**: SQLite (default, configurable for PostgreSQL/MySQL)
- **Image Processing**: Pillow

## 📦 Installation

### Prerequisites
- Python 3.8 or higher
- pip (Python package manager)

### Setup

1. Clone the repository:
```bash
git clone https://github.com/A5806568884/Transaction_Tracker.git
cd Transaction_Tracker
```

2. Install dependencies:
```bash
pip install -r requirements.txt
```

3. Run migrations:
```bash
python manage.py migrate
```

4. Create a superuser for admin access:
```bash
python manage.py createsuperuser
```

5. Run the development server:
```bash
python manage.py runserver
```

The application will be available at `http://127.0.0.1:8000/`

## 📚 Documentation

- **[API Examples](API_EXAMPLES.md)** - Complete API usage guide with examples
- **[Project Structure](PROJECT_STRUCTURE.md)** - Detailed project architecture
- **[Deployment Guide](DEPLOYMENT.md)** - Production deployment instructions
- **[Contributing](CONTRIBUTING.md)** - How to contribute to the project

## 🔌 API Endpoints

### Transaction Tracking APIs

#### Transaction Categories
- `GET /api/transactions/categories/` - List all categories
- `POST /api/transactions/categories/` - Create a new category
- `GET /api/transactions/categories/{id}/` - Get category details
- `PUT /api/transactions/categories/{id}/` - Update a category
- `DELETE /api/transactions/categories/{id}/` - Delete a category

#### Sales
- `GET /api/transactions/sales/` - List all sales
- `POST /api/transactions/sales/` - Record a new sale
- `GET /api/transactions/sales/{id}/` - Get sale details
- `PUT /api/transactions/sales/{id}/` - Update a sale
- `DELETE /api/transactions/sales/{id}/` - Delete a sale

#### Purchases
- `GET /api/transactions/purchases/` - List all purchases
- `POST /api/transactions/purchases/` - Record a new purchase
- `GET /api/transactions/purchases/{id}/` - Get purchase details
- `PUT /api/transactions/purchases/{id}/` - Update a purchase
- `DELETE /api/transactions/purchases/{id}/` - Delete a purchase

#### Income
- `GET /api/transactions/income/` - List all income records
- `POST /api/transactions/income/` - Record new income
- `GET /api/transactions/income/{id}/` - Get income details
- `PUT /api/transactions/income/{id}/` - Update income record
- `DELETE /api/transactions/income/{id}/` - Delete income record

#### Expenses
- `GET /api/transactions/expenses/` - List all expenses
- `POST /api/transactions/expenses/` - Record a new expense
- `GET /api/transactions/expenses/{id}/` - Get expense details
- `PUT /api/transactions/expenses/{id}/` - Update an expense
- `DELETE /api/transactions/expenses/{id}/` - Delete an expense

#### Banking Transactions
- `GET /api/transactions/banking-transactions/` - List all banking transactions
- `POST /api/transactions/banking-transactions/` - Record a new banking transaction
- `GET /api/transactions/banking-transactions/{id}/` - Get transaction details
- `PUT /api/transactions/banking-transactions/{id}/` - Update a transaction
- `DELETE /api/transactions/banking-transactions/{id}/` - Delete a transaction

### E-Commerce APIs

#### Product Categories
- `GET /api/ecommerce/product-categories/` - List all product categories
- `POST /api/ecommerce/product-categories/` - Create a new product category
- `GET /api/ecommerce/product-categories/{id}/` - Get category details
- `PUT /api/ecommerce/product-categories/{id}/` - Update a category
- `DELETE /api/ecommerce/product-categories/{id}/` - Delete a category

#### Products
- `GET /api/ecommerce/products/` - List all products
- `POST /api/ecommerce/products/` - Create a new product
- `GET /api/ecommerce/products/{id}/` - Get product details
- `PUT /api/ecommerce/products/{id}/` - Update a product
- `DELETE /api/ecommerce/products/{id}/` - Delete a product

#### Customers
- `GET /api/ecommerce/customers/` - List all customers
- `GET /api/ecommerce/customers/me/` - Get current user's customer profile
- `POST /api/ecommerce/customers/` - Create a new customer
- `GET /api/ecommerce/customers/{id}/` - Get customer details
- `PUT /api/ecommerce/customers/{id}/` - Update customer information
- `DELETE /api/ecommerce/customers/{id}/` - Delete a customer

#### Orders
- `GET /api/ecommerce/orders/` - List all orders (filtered by user)
- `POST /api/ecommerce/orders/` - Create a new order
- `GET /api/ecommerce/orders/{id}/` - Get order details
- `PUT /api/ecommerce/orders/{id}/` - Update order status
- `DELETE /api/ecommerce/orders/{id}/` - Cancel an order

#### Shopping Cart
- `GET /api/ecommerce/carts/` - Get user's cart
- `POST /api/ecommerce/carts/{id}/add_item/` - Add item to cart
- `POST /api/ecommerce/carts/{id}/remove_item/` - Remove item from cart
- `POST /api/ecommerce/carts/{id}/clear/` - Clear all items from cart

### Payment APIs

#### Payment Methods
- `GET /api/payments/payment-methods/` - List all payment methods (filtered by user)
- `POST /api/payments/payment-methods/` - Add a new payment method
- `GET /api/payments/payment-methods/{id}/` - Get payment method details
- `PUT /api/payments/payment-methods/{id}/` - Update payment method
- `DELETE /api/payments/payment-methods/{id}/` - Delete payment method
- `POST /api/payments/payment-methods/{id}/set_default/` - Set as default payment method

#### Payments
- `GET /api/payments/payments/` - List all payments (filtered by user)
- `POST /api/payments/payments/` - Create a new payment
- `GET /api/payments/payments/{id}/` - Get payment details
- `POST /api/payments/payments/{id}/process/` - Process a payment
- `PUT /api/payments/payments/{id}/` - Update payment status
- `DELETE /api/payments/payments/{id}/` - Delete payment record

#### Refunds
- `GET /api/payments/refunds/` - List all refunds (filtered by user)
- `POST /api/payments/refunds/` - Create a new refund
- `GET /api/payments/refunds/{id}/` - Get refund details
- `PUT /api/payments/refunds/{id}/` - Update refund status
- `DELETE /api/payments/refunds/{id}/` - Delete refund record

## 🖥️ Admin Interface

Access the Django admin panel at `http://127.0.0.1:8000/admin/` to manage:
- All transaction records
- Product catalog
- Customer accounts
- Orders and payments
- Payment methods
- User accounts and permissions

## 🗄️ Database Models

### Transaction Models
- **TransactionCategory**: Categories for organizing transactions
- **Sale**: Daily sales records
- **Purchase**: Purchase transactions from suppliers
- **Income**: Income records from various sources
- **Expense**: Business expense tracking
- **BankingTransaction**: Comprehensive banking transaction logs

### E-Commerce Models
- **ProductCategory**: Product categories (Mobiles, Computers, etc.)
- **Product**: Product catalog with images, pricing, and inventory
- **Customer**: Customer profiles with contact and shipping information
- **Order**: Order management with status tracking
- **OrderItem**: Individual items in an order
- **Cart**: Shopping cart management
- **CartItem**: Items in shopping cart

### Payment Models
- **PaymentMethod**: User payment methods (Credit Card, Bank, etc.)
- **CreditCardPayment**: Credit card details (last 4 digits only)
- **BankAccountPayment**: Bank account payment information
- **BranchlessBankingPayment**: Mobile wallet details
- **Payment**: Payment transactions with status
- **Refund**: Refund processing and tracking

## 🔒 Security Features

- User authentication required for all API endpoints
- Payment information stored securely (only last 4 digits of card/account numbers)
- CSRF protection enabled
- User-specific data filtering (users can only see their own orders, payments, etc.)
- Staff-only access for administrative operations

## 🧪 Testing

Run the test suite:
```bash
python manage.py test
```

All 21 tests pass successfully, covering:
- Model creation and validation
- Auto-calculation features
- Data relationships
- Business logic

## 🚀 Development

### Running Tests
```bash
python manage.py test
```

### Creating Sample Data
Use the Django admin interface or Django shell to create sample data:
```bash
python manage.py shell
```

## ⚙️ Configuration

### Environment Variables
Create a `.env` file for production settings:
```
SECRET_KEY=your-secret-key
DEBUG=False
ALLOWED_HOSTS=your-domain.com
DATABASE_URL=your-database-url
```

### Database Configuration
The default configuration uses SQLite. For production, configure PostgreSQL or MySQL in `settings.py`.

## 🤝 Contributing

We welcome contributions! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

## 📧 Support

For issues and questions, please create an issue on the GitHub repository.

## 🎯 Roadmap

Future enhancements:
- Real-time notifications
- Advanced analytics and reporting
- Mobile app (iOS/Android)
- Additional payment gateway integrations
- Multi-currency support
- Automated inventory management
- Customer loyalty programs

## 👥 Contributors

Thanks to all contributors who have helped build this project!

---

**Built with ❤️ using Django and Django REST Framework**
