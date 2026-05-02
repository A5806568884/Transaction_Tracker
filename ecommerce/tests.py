from django.test import TestCase
from django.contrib.auth.models import User
from decimal import Decimal
from .models import ProductCategory, Product, Customer, Order, OrderItem, Cart, CartItem


class ProductCategoryModelTest(TestCase):
    def setUp(self):
        self.category = ProductCategory.objects.create(
            name="Smartphones",
            description="Mobile phones"
        )

    def test_category_creation(self):
        self.assertEqual(self.category.name, "Smartphones")
        self.assertEqual(str(self.category), "Smartphones")


class ProductModelTest(TestCase):
    def setUp(self):
        self.category = ProductCategory.objects.create(name="Laptops")
        self.product = Product.objects.create(
            name="MacBook Pro",
            description="High-end laptop",
            category=self.category,
            price=Decimal('2499.99'),
            stock_quantity=10,
            sku="MBP-2024-001"
        )

    def test_product_creation(self):
        self.assertEqual(self.product.name, "MacBook Pro")
        self.assertEqual(self.product.price, Decimal('2499.99'))
        self.assertTrue(self.product.is_active)
        
    def test_product_in_stock(self):
        self.assertTrue(self.product.is_in_stock)
        
        # Test out of stock
        self.product.stock_quantity = 0
        self.assertFalse(self.product.is_in_stock)


class CustomerModelTest(TestCase):
    def setUp(self):
        self.user = User.objects.create_user(
            username='testcustomer',
            email='test@example.com',
            first_name='John',
            last_name='Doe'
        )
        self.customer = Customer.objects.create(
            user=self.user,
            phone="+1234567890",
            address="123 Main St",
            city="New York",
            state="NY",
            postal_code="10001",
            country="USA"
        )

    def test_customer_creation(self):
        self.assertEqual(self.customer.phone, "+1234567890")
        self.assertEqual(self.customer.city, "New York")


class OrderModelTest(TestCase):
    def setUp(self):
        self.user = User.objects.create_user(username='customer', email='customer@test.com')
        self.customer = Customer.objects.create(
            user=self.user,
            phone="+1111111111",
            address="Test Address",
            city="Test City",
            state="TS",
            postal_code="12345",
            country="USA"
        )
        self.order = Order.objects.create(
            customer=self.customer,
            order_number="ORD-001",
            total_amount=Decimal('1999.99'),
            shipping_address="Test Address",
            payment_method="CREDIT_CARD"
        )

    def test_order_creation(self):
        self.assertEqual(self.order.order_number, "ORD-001")
        self.assertEqual(self.order.status, "PENDING")
        self.assertEqual(self.order.total_amount, Decimal('1999.99'))


class CartModelTest(TestCase):
    def setUp(self):
        self.user = User.objects.create_user(username='cartuser')
        self.customer = Customer.objects.create(
            user=self.user,
            phone="+1234567890",
            address="Address",
            city="City",
            state="ST",
            postal_code="12345",
            country="USA"
        )
        self.cart = Cart.objects.create(customer=self.customer)
        
        self.category = ProductCategory.objects.create(name="Electronics")
        self.product = Product.objects.create(
            name="Test Product",
            description="Test",
            category=self.category,
            price=Decimal('99.99'),
            stock_quantity=10,
            sku="TEST-001"
        )

    def test_cart_creation(self):
        self.assertIsNotNone(self.cart)
        self.assertEqual(self.cart.customer, self.customer)
        
    def test_cart_item_addition(self):
        cart_item = CartItem.objects.create(
            cart=self.cart,
            product=self.product,
            quantity=2
        )
        self.assertEqual(cart_item.total_price, Decimal('199.98'))
        self.assertEqual(self.cart.total_items, 2)
