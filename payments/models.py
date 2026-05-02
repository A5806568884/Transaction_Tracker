from django.db import models
from django.contrib.auth.models import User
from ecommerce.models import Order


class PaymentMethod(models.Model):
    """Payment methods available: Credit Card, Bank Account, Branchless Banking"""
    PAYMENT_TYPES = [
        ('CREDIT_CARD', 'Credit Card'),
        ('BANK_ACCOUNT', 'Bank Account'),
        ('BRANCHLESS_BANKING', 'Branchless Banking'),
        ('CASH_ON_DELIVERY', 'Cash on Delivery'),
    ]

    customer = models.ForeignKey(User, on_delete=models.CASCADE, related_name='payment_methods')
    payment_type = models.CharField(max_length=30, choices=PAYMENT_TYPES)
    is_default = models.BooleanField(default=False)
    is_active = models.BooleanField(default=True)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)

    class Meta:
        ordering = ['-is_default', '-created_at']

    def __str__(self):
        return f"{self.customer.email} - {self.payment_type}"


class CreditCardPayment(models.Model):
    """Credit card payment details"""
    payment_method = models.OneToOneField(PaymentMethod, on_delete=models.CASCADE, related_name='credit_card')
    card_holder_name = models.CharField(max_length=200)
    card_number_last4 = models.CharField(max_length=4)  # Store only last 4 digits
    card_type = models.CharField(max_length=20)  # Visa, MasterCard, etc.
    expiry_month = models.PositiveIntegerField()
    expiry_year = models.PositiveIntegerField()
    billing_address = models.TextField()

    def __str__(self):
        return f"{self.card_type} ending in {self.card_number_last4}"


class BankAccountPayment(models.Model):
    """Bank account payment details"""
    payment_method = models.OneToOneField(PaymentMethod, on_delete=models.CASCADE, related_name='bank_account')
    account_holder_name = models.CharField(max_length=200)
    bank_name = models.CharField(max_length=200)
    account_number_last4 = models.CharField(max_length=4)  # Store only last 4 digits
    routing_number = models.CharField(max_length=20, blank=True)
    account_type = models.CharField(max_length=20)  # Savings, Checking

    def __str__(self):
        return f"{self.bank_name} - {self.account_number_last4}"


class BranchlessBankingPayment(models.Model):
    """Branchless banking payment details (Mobile wallets, etc.)"""
    payment_method = models.OneToOneField(PaymentMethod, on_delete=models.CASCADE, related_name='branchless_banking')
    account_holder_name = models.CharField(max_length=200)
    provider_name = models.CharField(max_length=100)  # Easypaisa, JazzCash, etc.
    mobile_number = models.CharField(max_length=20)
    account_id = models.CharField(max_length=100)

    def __str__(self):
        return f"{self.provider_name} - {self.mobile_number}"


class Payment(models.Model):
    """Payment transactions"""
    PAYMENT_STATUS = [
        ('PENDING', 'Pending'),
        ('PROCESSING', 'Processing'),
        ('COMPLETED', 'Completed'),
        ('FAILED', 'Failed'),
        ('REFUNDED', 'Refunded'),
    ]

    order = models.ForeignKey(Order, on_delete=models.CASCADE, related_name='payments')
    payment_method = models.ForeignKey(PaymentMethod, on_delete=models.SET_NULL, null=True)
    amount = models.DecimalField(max_digits=10, decimal_places=2)
    status = models.CharField(max_length=20, choices=PAYMENT_STATUS, default='PENDING')
    transaction_id = models.CharField(max_length=200, unique=True)
    payment_gateway_response = models.JSONField(blank=True, null=True)
    notes = models.TextField(blank=True)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)

    class Meta:
        ordering = ['-created_at']
        indexes = [
            models.Index(fields=['transaction_id']),
            models.Index(fields=['-created_at']),
        ]

    def __str__(self):
        return f"Payment {self.transaction_id} - {self.amount} ({self.status})"


class Refund(models.Model):
    """Refund transactions"""
    REFUND_STATUS = [
        ('PENDING', 'Pending'),
        ('PROCESSING', 'Processing'),
        ('COMPLETED', 'Completed'),
        ('FAILED', 'Failed'),
    ]

    payment = models.ForeignKey(Payment, on_delete=models.CASCADE, related_name='refunds')
    amount = models.DecimalField(max_digits=10, decimal_places=2)
    reason = models.TextField()
    status = models.CharField(max_length=20, choices=REFUND_STATUS, default='PENDING')
    refund_transaction_id = models.CharField(max_length=200, unique=True)
    created_by = models.ForeignKey(User, on_delete=models.SET_NULL, null=True)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)

    class Meta:
        ordering = ['-created_at']

    def __str__(self):
        return f"Refund {self.refund_transaction_id} - {self.amount}"
