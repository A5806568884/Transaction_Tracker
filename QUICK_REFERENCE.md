# Quick Reference Guide

Common commands and operations for the Transaction Tracker & E-Commerce Platform.

## Daily Development Tasks

### Start Development Server
```bash
python manage.py runserver
```

### Access Admin Panel
```
URL: http://127.0.0.1:8000/admin/
Default credentials: admin/admin123 (change after first login)
```

### Create Superuser
```bash
python manage.py createsuperuser
```

### Run All Tests
```bash
python manage.py test
```

### Run Specific App Tests
```bash
python manage.py test transactions
python manage.py test ecommerce
python manage.py test payments
```

## Database Operations

### Create Migrations
```bash
python manage.py makemigrations
```

### Apply Migrations
```bash
python manage.py migrate
```

### Reset Database (SQLite only - development)
```bash
rm db.sqlite3
python manage.py migrate
python manage.py createsuperuser
```

### Database Shell
```bash
python manage.py dbshell
```

### Django Shell
```bash
python manage.py shell
```

## Common Django Shell Operations

### Create Sample Transaction Data
```python
from django.contrib.auth.models import User
from transactions.models import TransactionCategory, Sale, Purchase
from decimal import Decimal

# Create a user
user = User.objects.create_user('testuser', 'test@example.com', 'password')

# Create a category
category = TransactionCategory.objects.create(name='Electronics', description='Electronic items')

# Create a sale
Sale.objects.create(
    customer_name='John Doe',
    product_name='iPhone 15',
    quantity=1,
    unit_price=Decimal('999.99'),
    category=category,
    created_by=user
)

# Create a purchase
Purchase.objects.create(
    supplier_name='Tech Supplier',
    product_name='Laptop',
    quantity=5,
    unit_price=Decimal('800.00'),
    category=category,
    created_by=user
)
```

### Create Sample E-commerce Data
```python
from ecommerce.models import ProductCategory, Product, Customer
from django.contrib.auth.models import User
from decimal import Decimal

# Create product category
cat = ProductCategory.objects.create(name='Smartphones', description='Mobile phones')

# Create product
Product.objects.create(
    name='iPhone 15 Pro',
    description='Latest iPhone',
    category=cat,
    price=Decimal('1199.99'),
    stock_quantity=50,
    sku='IP15PRO-256-BLK'
)

# Create customer profile
user = User.objects.create_user('customer', 'customer@example.com', 'password')
Customer.objects.create(
    user=user,
    phone='+1234567890',
    address='123 Main St',
    city='New York',
    state='NY',
    postal_code='10001',
    country='USA'
)
```

### Create Sample Payment Data
```python
from payments.models import PaymentMethod
from django.contrib.auth.models import User

user = User.objects.get(username='customer')

# Create payment method
PaymentMethod.objects.create(
    customer=user,
    payment_type='CREDIT_CARD',
    is_default=True
)
```

## API Testing with curl

### Login (Session Auth)
```bash
curl -c cookies.txt -X POST http://127.0.0.1:8000/api-auth/login/ \
  -d "username=admin&password=admin123"
```

### List Sales
```bash
curl -b cookies.txt http://127.0.0.1:8000/api/transactions/sales/
```

### Create a Sale
```bash
curl -b cookies.txt -X POST http://127.0.0.1:8000/api/transactions/sales/ \
  -H "Content-Type: application/json" \
  -d '{
    "customer_name": "Jane Smith",
    "product_name": "MacBook Pro",
    "quantity": 1,
    "unit_price": "2499.99"
  }'
```

### List Products
```bash
curl -b cookies.txt http://127.0.0.1:8000/api/ecommerce/products/
```

### Search Products
```bash
curl -b cookies.txt "http://127.0.0.1:8000/api/ecommerce/products/?search=iPhone"
```

## Static Files

### Collect Static Files
```bash
python manage.py collectstatic
```

### Clear Static Files
```bash
rm -rf staticfiles/
python manage.py collectstatic --noinput
```

## Logs and Debugging

### View Recent Logs (if configured)
```bash
tail -f /var/log/transaction_tracker/django.log
```

### Enable Debug Mode (Development Only)
In `settings.py`:
```python
DEBUG = True
```

### Check System
```bash
python manage.py check
```

### Check Deployment Readiness
```bash
python manage.py check --deploy
```

## Performance

### Show SQL Queries
```bash
python manage.py shell
```
```python
from django.db import connection
from transactions.models import Sale

# Enable query logging
from django.conf import settings
settings.DEBUG = True

# Run query
list(Sale.objects.all())

# View queries
for query in connection.queries:
    print(query['sql'])
```

### Create Database Indexes
Already included in models, but to add custom ones:
```python
# In models.py
class Meta:
    indexes = [
        models.Index(fields=['date', 'customer_name']),
    ]
```

## Troubleshooting

### Clear Cache (if using cache)
```bash
python manage.py shell
```
```python
from django.core.cache import cache
cache.clear()
```

### Reset Migrations (Development Only)
```bash
find . -path "*/migrations/*.py" -not -name "__init__.py" -delete
find . -path "*/migrations/*.pyc" -delete
rm db.sqlite3
python manage.py makemigrations
python manage.py migrate
```

### Fix Permission Errors
```bash
sudo chown -R $USER:$USER .
chmod -R 755 .
```

## Code Quality

### Check Code Style (requires pylint)
```bash
pip install pylint
pylint transactions/ ecommerce/ payments/
```

### Check Security (requires bandit)
```bash
pip install bandit
bandit -r .
```

### Run Coverage Report
```bash
pip install coverage
coverage run manage.py test
coverage report
coverage html  # Creates htmlcov/index.html
```

## Backup and Restore

### Backup Database (SQLite)
```bash
cp db.sqlite3 backups/db_$(date +%Y%m%d).sqlite3
```

### Restore Database (SQLite)
```bash
cp backups/db_YYYYMMDD.sqlite3 db.sqlite3
```

### Export Data (JSON)
```bash
python manage.py dumpdata > backup.json
python manage.py dumpdata transactions > transactions_backup.json
python manage.py dumpdata ecommerce > ecommerce_backup.json
```

### Import Data (JSON)
```bash
python manage.py loaddata backup.json
```

## Environment Variables

### Create .env file
```bash
cat > .env << EOF
SECRET_KEY=your-secret-key-here
DEBUG=True
ALLOWED_HOSTS=localhost,127.0.0.1
EOF
```

### Load Environment Variables
```bash
source .env  # Linux/Mac
set -a; source .env; set +a  # More robust
```

## Production Deployment

### Check Production Readiness
```bash
python manage.py check --deploy
```

### Collect Static Files
```bash
python manage.py collectstatic --noinput
```

### Create Admin User
```bash
python manage.py createsuperuser --noinput \
  --username admin \
  --email admin@example.com
```

### Run with Gunicorn
```bash
gunicorn transaction_tracker.wsgi:application --bind 0.0.0.0:8000
```

## Useful Django Management Commands

### List All URLs
```bash
python manage.py show_urls  # Requires django-extensions
# Or
python manage.py shell
from django.urls import get_resolver
print(get_resolver().url_patterns)
```

### Clear Sessions
```bash
python manage.py clearsessions
```

### Create Cache Table (if using database cache)
```bash
python manage.py createcachetable
```

## API Endpoints Quick Reference

### Transactions
- `GET /api/transactions/sales/` - List sales
- `POST /api/transactions/sales/` - Create sale
- `GET /api/transactions/purchases/` - List purchases
- `POST /api/transactions/purchases/` - Create purchase
- `GET /api/transactions/income/` - List income
- `POST /api/transactions/income/` - Create income
- `GET /api/transactions/expenses/` - List expenses
- `POST /api/transactions/expenses/` - Create expense

### E-commerce
- `GET /api/ecommerce/products/` - List products
- `POST /api/ecommerce/products/` - Create product
- `GET /api/ecommerce/orders/` - List orders
- `POST /api/ecommerce/orders/` - Create order
- `GET /api/ecommerce/customers/me/` - Get my profile

### Payments
- `GET /api/payments/payment-methods/` - List payment methods
- `POST /api/payments/payment-methods/` - Add payment method
- `GET /api/payments/payments/` - List payments
- `POST /api/payments/payments/` - Create payment

## Need Help?

- Check [README.md](README.md) for installation and features
- See [API_EXAMPLES.md](API_EXAMPLES.md) for detailed API usage
- Read [CONTRIBUTING.md](CONTRIBUTING.md) for development guidelines
- Review [DEPLOYMENT.md](DEPLOYMENT.md) for production setup
