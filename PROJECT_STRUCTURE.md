# Project Structure

This document describes the organization and structure of the Transaction Tracker & E-Commerce Platform.

```
Transaction_Tracker/
│
├── manage.py                    # Django management script
├── requirements.txt             # Python dependencies
├── .gitignore                  # Git ignore rules
├── README.md                   # Project documentation
├── API_EXAMPLES.md             # API usage examples
├── DEPLOYMENT.md               # Deployment guide
│
├── transaction_tracker/         # Main project configuration
│   ├── __init__.py
│   ├── settings.py             # Django settings
│   ├── urls.py                 # Root URL configuration
│   ├── wsgi.py                 # WSGI configuration
│   └── asgi.py                 # ASGI configuration
│
├── transactions/                # Transaction tracking app
│   ├── __init__.py
│   ├── admin.py                # Admin interface configuration
│   ├── apps.py                 # App configuration
│   ├── models.py               # Database models
│   │   ├── TransactionCategory
│   │   ├── Sale
│   │   ├── Purchase
│   │   ├── Income
│   │   ├── Expense
│   │   └── BankingTransaction
│   ├── serializers.py          # REST API serializers
│   ├── views.py                # API views/viewsets
│   ├── urls.py                 # URL routing
│   ├── tests.py                # Unit tests
│   └── migrations/             # Database migrations
│
├── ecommerce/                   # E-commerce app
│   ├── __init__.py
│   ├── admin.py                # Admin interface configuration
│   ├── apps.py                 # App configuration
│   ├── models.py               # Database models
│   │   ├── ProductCategory
│   │   ├── Product
│   │   ├── Customer
│   │   ├── Order
│   │   ├── OrderItem
│   │   ├── Cart
│   │   └── CartItem
│   ├── serializers.py          # REST API serializers
│   ├── views.py                # API views/viewsets
│   ├── urls.py                 # URL routing
│   ├── tests.py                # Unit tests
│   └── migrations/             # Database migrations
│
├── payments/                    # Payment processing app
│   ├── __init__.py
│   ├── admin.py                # Admin interface configuration
│   ├── apps.py                 # App configuration
│   ├── models.py               # Database models
│   │   ├── PaymentMethod
│   │   ├── CreditCardPayment
│   │   ├── BankAccountPayment
│   │   ├── BranchlessBankingPayment
│   │   ├── Payment
│   │   └── Refund
│   ├── serializers.py          # REST API serializers
│   ├── views.py                # API views/viewsets
│   ├── urls.py                 # URL routing
│   ├── tests.py                # Unit tests
│   └── migrations/             # Database migrations
│
├── media/                       # User-uploaded files (images, etc.)
│   ├── categories/
│   └── products/
│
└── staticfiles/                 # Collected static files (CSS, JS, images)
```

## App Responsibilities

### Transactions App
Handles all business transaction tracking:
- **Sales**: Record daily sales with customer and product details
- **Purchases**: Track supplier purchases and procurement
- **Income**: Monitor various income sources
- **Expenses**: Track business expenses by category
- **Banking Transactions**: Comprehensive banking transaction logs

### E-commerce App
Manages the online store functionality:
- **Product Management**: Catalog with categories, images, and inventory
- **Customer Management**: User profiles and shipping information
- **Order Processing**: Complete order lifecycle management
- **Shopping Cart**: Add/remove items, calculate totals

### Payments App
Handles payment processing and methods:
- **Payment Methods**: Support for multiple payment types
- **Credit Card**: Secure credit card information storage
- **Bank Account**: Bank account payment details
- **Branchless Banking**: Mobile wallet support
- **Payment Processing**: Transaction management
- **Refunds**: Refund processing and tracking

## Models Overview

### Transaction Models

#### TransactionCategory
- Groups transactions into categories
- Used across sales, purchases, income, and expenses
- Fields: name, description, created_at

#### Sale
- Records individual sales transactions
- Auto-calculates total_amount from quantity * unit_price
- Fields: customer_name, product_name, quantity, unit_price, total_amount, category, date, notes

#### Purchase
- Tracks purchases from suppliers
- Auto-calculates total_amount from quantity * unit_price
- Fields: supplier_name, product_name, quantity, unit_price, total_amount, category, date, notes

#### Income
- Records income from various sources
- Fields: source, amount, category, date, description

#### Expense
- Tracks business expenses
- Fields: expense_type, amount, category, date, description

#### BankingTransaction
- Comprehensive banking transaction log
- Fields: transaction_type, account_number, amount, balance_after, reference_number, date, description

### E-commerce Models

#### ProductCategory
- Organizes products into categories
- Fields: name, description, image

#### Product
- Product catalog with inventory management
- Fields: name, description, category, price, stock_quantity, image, sku, is_active
- Properties: is_in_stock

#### Customer
- Customer profile information
- Links to Django User model
- Fields: user, phone, address, city, state, postal_code, country

#### Order
- Customer order management
- Fields: customer, order_number, status, total_amount, shipping_address, payment_method, payment_status, notes

#### OrderItem
- Individual items in an order
- Auto-calculates total_price from quantity * unit_price
- Fields: order, product, quantity, unit_price, total_price

#### Cart
- Shopping cart for customers
- Properties: total_items, total_amount

#### CartItem
- Items in shopping cart
- Fields: cart, product, quantity
- Properties: total_price

### Payment Models

#### PaymentMethod
- User's payment method preferences
- Fields: customer, payment_type, is_default, is_active

#### CreditCardPayment
- Secure credit card information
- Stores only last 4 digits of card number
- Fields: card_holder_name, card_number_last4, card_type, expiry_month, expiry_year, billing_address

#### BankAccountPayment
- Bank account details
- Stores only last 4 digits of account number
- Fields: account_holder_name, bank_name, account_number_last4, routing_number, account_type

#### BranchlessBankingPayment
- Mobile wallet information
- Fields: account_holder_name, provider_name, mobile_number, account_id

#### Payment
- Payment transaction records
- Fields: order, payment_method, amount, status, transaction_id, payment_gateway_response, notes

#### Refund
- Refund processing
- Fields: payment, amount, reason, status, refund_transaction_id, created_by

## API Endpoints Structure

### Transaction APIs
```
/api/transactions/
    ├── categories/              # Transaction categories
    ├── sales/                   # Sales records
    ├── purchases/               # Purchase records
    ├── income/                  # Income records
    ├── expenses/                # Expense records
    └── banking-transactions/    # Banking transactions
```

### E-commerce APIs
```
/api/ecommerce/
    ├── product-categories/      # Product categories
    ├── products/                # Product catalog
    ├── customers/               # Customer profiles
    │   └── me/                  # Current user's profile
    ├── orders/                  # Order management
    └── carts/                   # Shopping carts
        └── {id}/
            ├── add_item/        # Add item to cart
            ├── remove_item/     # Remove item from cart
            └── clear/           # Clear cart
```

### Payment APIs
```
/api/payments/
    ├── payment-methods/         # Payment methods
    │   └── {id}/
    │       └── set_default/     # Set as default
    ├── payments/                # Payment transactions
    │   └── {id}/
    │       └── process/         # Process payment
    └── refunds/                 # Refund management
```

## Database Schema

The application uses Django ORM with the following key relationships:

1. **One-to-Many**:
   - TransactionCategory → Sales, Purchases, Income, Expenses
   - ProductCategory → Products
   - Customer → Orders
   - Order → OrderItems
   - Cart → CartItems
   - User → PaymentMethods
   - Order → Payments
   - Payment → Refunds

2. **One-to-One**:
   - User → Customer
   - PaymentMethod → CreditCardPayment/BankAccountPayment/BranchlessBankingPayment

3. **Many-to-Many**:
   - Through CartItem: Cart ↔ Products

## Key Features Implementation

### Auto-calculation
- Sale and Purchase models automatically calculate total_amount
- OrderItem automatically calculates total_price
- Cart provides total_items and total_amount properties

### User-specific Filtering
- Orders filtered by customer (non-staff users see only their orders)
- Payments filtered by user's orders
- Payment methods filtered by user
- Cart filtered by customer

### Search and Filtering
- Full-text search on relevant fields
- Date-based filtering for transactions
- Category filtering
- Status filtering for orders and payments

### Admin Interface
- Comprehensive admin panels for all models
- Inline editing for OrderItems in Orders
- Inline editing for CartItems in Carts
- Read-only fields for calculated values

## Testing Structure

Tests are organized by app with coverage for:
- Model creation and validation
- Auto-calculation functionality
- Property methods
- String representations
- Relationships between models

## Security Features

1. **Authentication Required**: All API endpoints require authentication
2. **User Data Isolation**: Users can only access their own data
3. **Secure Payment Storage**: Only last 4 digits stored for sensitive numbers
4. **CSRF Protection**: Enabled for all forms
5. **Staff-only Operations**: Administrative operations restricted to staff users

## Extensibility

The modular structure allows for easy extension:
- Add new transaction types in transactions app
- Add new product types or categories in ecommerce app
- Add new payment gateways in payments app
- Each app is independent and can be modified separately

## Best Practices Followed

1. **DRY Principle**: Reusable serializers and viewsets
2. **Separation of Concerns**: Each app handles specific functionality
3. **Security First**: Authentication, authorization, and data protection
4. **RESTful Design**: Standard HTTP methods and status codes
5. **Documentation**: Comprehensive inline comments and docstrings
6. **Testing**: Unit tests for all critical functionality
7. **Type Safety**: Proper field types and validation
8. **Indexing**: Database indexes on frequently queried fields
