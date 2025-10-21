from django.test import TestCase
from django.contrib.auth.models import User
from decimal import Decimal
from .models import TransactionCategory, Sale, Purchase, Income, Expense, BankingTransaction


class TransactionCategoryModelTest(TestCase):
    def setUp(self):
        self.category = TransactionCategory.objects.create(
            name="Electronics",
            description="Electronic items"
        )

    def test_category_creation(self):
        self.assertEqual(self.category.name, "Electronics")
        self.assertEqual(str(self.category), "Electronics")


class SaleModelTest(TestCase):
    def setUp(self):
        self.user = User.objects.create_user(username='testuser', password='12345')
        self.category = TransactionCategory.objects.create(name="Electronics")
        self.sale = Sale.objects.create(
            customer_name="John Doe",
            product_name="iPhone 15",
            quantity=2,
            unit_price=Decimal('999.99'),
            category=self.category,
            created_by=self.user
        )

    def test_sale_creation(self):
        self.assertEqual(self.sale.customer_name, "John Doe")
        self.assertEqual(self.sale.product_name, "iPhone 15")
        self.assertEqual(self.sale.quantity, 2)
        
    def test_sale_total_calculation(self):
        # Total should be automatically calculated
        expected_total = Decimal('1999.98')
        self.assertEqual(self.sale.total_amount, expected_total)


class PurchaseModelTest(TestCase):
    def setUp(self):
        self.purchase = Purchase.objects.create(
            supplier_name="Tech Supplier",
            product_name="Laptop",
            quantity=5,
            unit_price=Decimal('800.00')
        )

    def test_purchase_creation(self):
        self.assertEqual(self.purchase.supplier_name, "Tech Supplier")
        
    def test_purchase_total_calculation(self):
        expected_total = Decimal('4000.00')
        self.assertEqual(self.purchase.total_amount, expected_total)


class IncomeModelTest(TestCase):
    def setUp(self):
        self.income = Income.objects.create(
            source="Online Sales",
            amount=Decimal('5000.00'),
            description="Monthly revenue"
        )

    def test_income_creation(self):
        self.assertEqual(self.income.source, "Online Sales")
        self.assertEqual(self.income.amount, Decimal('5000.00'))


class ExpenseModelTest(TestCase):
    def setUp(self):
        self.expense = Expense.objects.create(
            expense_type="Rent",
            amount=Decimal('2000.00'),
            description="Office rent"
        )

    def test_expense_creation(self):
        self.assertEqual(self.expense.expense_type, "Rent")
        self.assertEqual(self.expense.amount, Decimal('2000.00'))


class BankingTransactionModelTest(TestCase):
    def setUp(self):
        self.transaction = BankingTransaction.objects.create(
            transaction_type="DEPOSIT",
            account_number="1234567890",
            amount=Decimal('10000.00'),
            reference_number="TXN001",
            balance_after=Decimal('15000.00')
        )

    def test_banking_transaction_creation(self):
        self.assertEqual(self.transaction.transaction_type, "DEPOSIT")
        self.assertEqual(self.transaction.amount, Decimal('10000.00'))
        self.assertEqual(self.transaction.reference_number, "TXN001")
