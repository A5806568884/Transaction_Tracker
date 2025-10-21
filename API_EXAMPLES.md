# API Usage Examples

This document provides practical examples for using the Transaction Tracker & E-Commerce Platform API.

## Authentication

All API endpoints require authentication. You can authenticate using:
1. Session authentication (for web browsers)
2. Token authentication (for API clients)

### Login
```bash
# Using session authentication
curl -X POST http://127.0.0.1:8000/api-auth/login/ \
  -H "Content-Type: application/json" \
  -d '{"username": "admin", "password": "password"}'
```

## Transaction APIs

### Create a Sale
```bash
curl -X POST http://127.0.0.1:8000/api/transactions/sales/ \
  -H "Content-Type: application/json" \
  -H "Authorization: Token YOUR_TOKEN" \
  -d '{
    "customer_name": "John Doe",
    "product_name": "iPhone 15 Pro",
    "quantity": 1,
    "unit_price": "999.99",
    "notes": "Customer requested gift wrapping"
  }'
```

### Get Sales with Filters
```bash
# Filter by date
curl http://127.0.0.1:8000/api/transactions/sales/?date=2024-01-15

# Search by customer name
curl http://127.0.0.1:8000/api/transactions/sales/?search=John

# Order by amount
curl http://127.0.0.1:8000/api/transactions/sales/?ordering=-total_amount
```

### Create a Purchase
```bash
curl -X POST http://127.0.0.1:8000/api/transactions/purchases/ \
  -H "Content-Type: application/json" \
  -d '{
    "supplier_name": "Tech Wholesale Inc",
    "product_name": "Samsung Galaxy S24",
    "quantity": 10,
    "unit_price": "750.00"
  }'
```

### Record Income
```bash
curl -X POST http://127.0.0.1:8000/api/transactions/income/ \
  -H "Content-Type: application/json" \
  -d '{
    "source": "Online Sales Revenue",
    "amount": "5000.00",
    "description": "Monthly online sales"
  }'
```

### Record Expense
```bash
curl -X POST http://127.0.0.1:8000/api/transactions/expenses/ \
  -H "Content-Type: application/json" \
  -d '{
    "expense_type": "Office Rent",
    "amount": "2000.00",
    "description": "Monthly office rent payment"
  }'
```

### Create Banking Transaction
```bash
curl -X POST http://127.0.0.1:8000/api/transactions/banking-transactions/ \
  -H "Content-Type: application/json" \
  -d '{
    "transaction_type": "DEPOSIT",
    "account_number": "1234567890",
    "amount": "10000.00",
    "reference_number": "TXN2024010115001",
    "description": "Customer deposit"
  }'
```

## E-Commerce APIs

### Create Product Category
```bash
curl -X POST http://127.0.0.1:8000/api/ecommerce/product-categories/ \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Smartphones",
    "description": "Latest smartphones and mobile devices"
  }'
```

### Add a Product
```bash
curl -X POST http://127.0.0.1:8000/api/ecommerce/products/ \
  -H "Content-Type: application/json" \
  -d '{
    "name": "iPhone 15 Pro Max",
    "description": "Latest iPhone with A17 Pro chip",
    "category": 1,
    "price": "1199.99",
    "stock_quantity": 50,
    "sku": "IPHONE15PROMAX-256-BLK",
    "is_active": true
  }'
```

### Get Products with Filters
```bash
# Filter by category
curl http://127.0.0.1:8000/api/ecommerce/products/?category=1

# Search by name
curl http://127.0.0.1:8000/api/ecommerce/products/?search=iPhone

# Filter by price (order by lowest first)
curl http://127.0.0.1:8000/api/ecommerce/products/?ordering=price
```

### Create Customer Profile
```bash
curl -X POST http://127.0.0.1:8000/api/ecommerce/customers/ \
  -H "Content-Type: application/json" \
  -d '{
    "phone": "+1234567890",
    "address": "123 Main Street, Apt 4B",
    "city": "New York",
    "state": "NY",
    "postal_code": "10001",
    "country": "USA"
  }'
```

### Add Item to Cart
```bash
curl -X POST http://127.0.0.1:8000/api/ecommerce/carts/1/add_item/ \
  -H "Content-Type: application/json" \
  -d '{
    "product_id": 1,
    "quantity": 2
  }'
```

### Remove Item from Cart
```bash
curl -X POST http://127.0.0.1:8000/api/ecommerce/carts/1/remove_item/ \
  -H "Content-Type: application/json" \
  -d '{
    "product_id": 1
  }'
```

### Create Order
```bash
curl -X POST http://127.0.0.1:8000/api/ecommerce/orders/ \
  -H "Content-Type: application/json" \
  -d '{
    "customer": 1,
    "order_number": "ORD-2024-001",
    "total_amount": "1199.99",
    "shipping_address": "123 Main Street, Apt 4B, New York, NY 10001",
    "payment_method": "CREDIT_CARD",
    "notes": "Please deliver before 5 PM"
  }'
```

## Payment APIs

### Add Credit Card Payment Method
```bash
curl -X POST http://127.0.0.1:8000/api/payments/payment-methods/ \
  -H "Content-Type: application/json" \
  -d '{
    "payment_type": "CREDIT_CARD",
    "is_default": true
  }'
```

### Add Bank Account Payment Method
```bash
curl -X POST http://127.0.0.1:8000/api/payments/payment-methods/ \
  -H "Content-Type: application/json" \
  -d '{
    "payment_type": "BANK_ACCOUNT",
    "is_default": false
  }'
```

### Add Branchless Banking Payment Method
```bash
curl -X POST http://127.0.0.1:8000/api/payments/payment-methods/ \
  -H "Content-Type: application/json" \
  -d '{
    "payment_type": "BRANCHLESS_BANKING",
    "is_default": false
  }'
```

### Set Default Payment Method
```bash
curl -X POST http://127.0.0.1:8000/api/payments/payment-methods/1/set_default/
```

### Create Payment
```bash
curl -X POST http://127.0.0.1:8000/api/payments/payments/ \
  -H "Content-Type: application/json" \
  -d '{
    "order": 1,
    "payment_method": 1,
    "amount": "1199.99",
    "transaction_id": "PAY-2024-001-XYZ123"
  }'
```

### Process Payment
```bash
curl -X POST http://127.0.0.1:8000/api/payments/payments/1/process/
```

### Create Refund
```bash
curl -X POST http://127.0.0.1:8000/api/payments/refunds/ \
  -H "Content-Type: application/json" \
  -d '{
    "payment": 1,
    "amount": "1199.99",
    "reason": "Product defect - customer requested refund",
    "refund_transaction_id": "REF-2024-001-ABC456"
  }'
```

## Filtering and Pagination

### Date Range Filtering
Most transaction endpoints support date filtering:
```bash
# Filter by specific date
curl http://127.0.0.1:8000/api/transactions/sales/?date=2024-01-15

# Filter by date range (if implemented)
curl "http://127.0.0.1:8000/api/transactions/sales/?date_from=2024-01-01&date_to=2024-01-31"
```

### Pagination
API responses are paginated. Navigate through pages:
```bash
# First page (default)
curl http://127.0.0.1:8000/api/transactions/sales/

# Specific page
curl http://127.0.0.1:8000/api/transactions/sales/?page=2

# Adjust page size
curl http://127.0.0.1:8000/api/transactions/sales/?page_size=20
```

### Search
Use the `search` parameter for full-text search:
```bash
curl http://127.0.0.1:8000/api/ecommerce/products/?search=iPhone
```

### Ordering
Use the `ordering` parameter to sort results:
```bash
# Ascending order
curl http://127.0.0.1:8000/api/transactions/sales/?ordering=total_amount

# Descending order
curl http://127.0.0.1:8000/api/transactions/sales/?ordering=-total_amount
```

## Response Format

All responses follow this format:

### Success Response
```json
{
  "count": 100,
  "next": "http://127.0.0.1:8000/api/transactions/sales/?page=2",
  "previous": null,
  "results": [
    {
      "id": 1,
      "customer_name": "John Doe",
      "product_name": "iPhone 15 Pro",
      "quantity": 1,
      "unit_price": "999.99",
      "total_amount": "999.99",
      "date": "2024-01-15",
      "created_at": "2024-01-15T10:30:00Z"
    }
  ]
}
```

### Error Response
```json
{
  "detail": "Not found."
}
```

or

```json
{
  "field_name": [
    "This field is required."
  ]
}
```

## Best Practices

1. **Always validate input data** before sending requests
2. **Use pagination** for large datasets
3. **Implement proper error handling** in your client application
4. **Cache frequently accessed data** when appropriate
5. **Use HTTPS** in production
6. **Implement rate limiting** to prevent abuse
7. **Keep sensitive data secure** (never log payment details)
8. **Use appropriate HTTP methods** (GET for reading, POST for creating, PUT/PATCH for updating, DELETE for removing)

## Testing with Postman

Import the following collection structure:
1. Create a new collection named "Transaction Tracker API"
2. Add environment variables for base URL and authentication token
3. Organize requests by resource (Transactions, E-commerce, Payments)
4. Use pre-request scripts for authentication
5. Add tests to validate responses

## Webhooks (Future Enhancement)

For real-time notifications, you can implement webhooks for:
- Order status changes
- Payment confirmations
- Refund processing
- Low stock alerts

## Rate Limiting (Future Enhancement)

Implement rate limiting to prevent abuse:
- Unauthenticated: 100 requests/hour
- Authenticated: 1000 requests/hour
- Staff: 10000 requests/hour
