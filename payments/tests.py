from django.test import TestCase
from django.contrib.auth.models import User
from decimal import Decimal
from ecommerce.models import Customer, Order, ProductCategory, Product
from .models import PaymentMethod, CreditCardPayment, BankAccountPayment, BranchlessBankingPayment, Payment, Refund


class PaymentMethodModelTest(TestCase):
    def setUp(self):
        self.user = User.objects.create_user(username='paymentuser')
        self.payment_method = PaymentMethod.objects.create(
            customer=self.user,
            payment_type='CREDIT_CARD',
            is_default=True
        )

    def test_payment_method_creation(self):
        self.assertEqual(self.payment_method.payment_type, 'CREDIT_CARD')
        self.assertTrue(self.payment_method.is_default)


class CreditCardPaymentModelTest(TestCase):
    def setUp(self):
        self.user = User.objects.create_user(username='ccuser')
        self.payment_method = PaymentMethod.objects.create(
            customer=self.user,
            payment_type='CREDIT_CARD'
        )
        self.credit_card = CreditCardPayment.objects.create(
            payment_method=self.payment_method,
            card_holder_name="John Doe",
            card_number_last4="1234",
            card_type="Visa",
            expiry_month=12,
            expiry_year=2025,
            billing_address="123 Main St"
        )

    def test_credit_card_creation(self):
        self.assertEqual(self.credit_card.card_type, "Visa")
        self.assertEqual(self.credit_card.card_number_last4, "1234")


class BankAccountPaymentModelTest(TestCase):
    def setUp(self):
        self.user = User.objects.create_user(username='bankuser')
        self.payment_method = PaymentMethod.objects.create(
            customer=self.user,
            payment_type='BANK_ACCOUNT'
        )
        self.bank_account = BankAccountPayment.objects.create(
            payment_method=self.payment_method,
            account_holder_name="Jane Doe",
            bank_name="Test Bank",
            account_number_last4="5678",
            account_type="Checking"
        )

    def test_bank_account_creation(self):
        self.assertEqual(self.bank_account.bank_name, "Test Bank")
        self.assertEqual(self.bank_account.account_number_last4, "5678")


class BranchlessBankingPaymentModelTest(TestCase):
    def setUp(self):
        self.user = User.objects.create_user(username='branchlessuser')
        self.payment_method = PaymentMethod.objects.create(
            customer=self.user,
            payment_type='BRANCHLESS_BANKING'
        )
        self.branchless = BranchlessBankingPayment.objects.create(
            payment_method=self.payment_method,
            account_holder_name="Ali Khan",
            provider_name="JazzCash",
            mobile_number="+923001234567",
            account_id="JAZZ123456"
        )

    def test_branchless_creation(self):
        self.assertEqual(self.branchless.provider_name, "JazzCash")
        self.assertEqual(self.branchless.mobile_number, "+923001234567")


class PaymentModelTest(TestCase):
    def setUp(self):
        self.user = User.objects.create_user(username='orderuser', email='order@test.com')
        self.customer = Customer.objects.create(
            user=self.user,
            phone="+1234567890",
            address="Address",
            city="City",
            state="ST",
            postal_code="12345",
            country="USA"
        )
        self.order = Order.objects.create(
            customer=self.customer,
            order_number="ORD-PAY-001",
            total_amount=Decimal('500.00'),
            shipping_address="Test Address",
            payment_method="CREDIT_CARD"
        )
        self.payment_method = PaymentMethod.objects.create(
            customer=self.user,
            payment_type='CREDIT_CARD'
        )
        self.payment = Payment.objects.create(
            order=self.order,
            payment_method=self.payment_method,
            amount=Decimal('500.00'),
            transaction_id="TXN-PAY-001"
        )

    def test_payment_creation(self):
        self.assertEqual(self.payment.amount, Decimal('500.00'))
        self.assertEqual(self.payment.status, "PENDING")
        self.assertEqual(self.payment.transaction_id, "TXN-PAY-001")


class RefundModelTest(TestCase):
    def setUp(self):
        self.user = User.objects.create_user(username='refunduser', email='refund@test.com')
        self.customer = Customer.objects.create(
            user=self.user,
            phone="+1234567890",
            address="Address",
            city="City",
            state="ST",
            postal_code="12345",
            country="USA"
        )
        self.order = Order.objects.create(
            customer=self.customer,
            order_number="ORD-REF-001",
            total_amount=Decimal('300.00'),
            shipping_address="Test Address",
            payment_method="CREDIT_CARD"
        )
        self.payment_method = PaymentMethod.objects.create(
            customer=self.user,
            payment_type='CREDIT_CARD'
        )
        self.payment = Payment.objects.create(
            order=self.order,
            payment_method=self.payment_method,
            amount=Decimal('300.00'),
            transaction_id="TXN-REF-001"
        )
        self.refund = Refund.objects.create(
            payment=self.payment,
            amount=Decimal('300.00'),
            reason="Product defect",
            refund_transaction_id="REF-001",
            created_by=self.user
        )

    def test_refund_creation(self):
        self.assertEqual(self.refund.amount, Decimal('300.00'))
        self.assertEqual(self.refund.status, "PENDING")
        self.assertEqual(self.refund.reason, "Product defect")
