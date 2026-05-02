from django.contrib import admin
from .models import (
    PaymentMethod, CreditCardPayment, BankAccountPayment, 
    BranchlessBankingPayment, Payment, Refund
)


@admin.register(PaymentMethod)
class PaymentMethodAdmin(admin.ModelAdmin):
    list_display = ['customer', 'payment_type', 'is_default', 'is_active', 'created_at']
    list_filter = ['payment_type', 'is_default', 'is_active']
    search_fields = ['customer__email']
    readonly_fields = ['created_at', 'updated_at']


@admin.register(CreditCardPayment)
class CreditCardPaymentAdmin(admin.ModelAdmin):
    list_display = ['card_holder_name', 'card_type', 'card_number_last4', 'expiry_month', 'expiry_year']
    search_fields = ['card_holder_name', 'card_number_last4']


@admin.register(BankAccountPayment)
class BankAccountPaymentAdmin(admin.ModelAdmin):
    list_display = ['account_holder_name', 'bank_name', 'account_number_last4', 'account_type']
    search_fields = ['account_holder_name', 'bank_name']


@admin.register(BranchlessBankingPayment)
class BranchlessBankingPaymentAdmin(admin.ModelAdmin):
    list_display = ['account_holder_name', 'provider_name', 'mobile_number']
    search_fields = ['account_holder_name', 'provider_name', 'mobile_number']


@admin.register(Payment)
class PaymentAdmin(admin.ModelAdmin):
    list_display = ['transaction_id', 'order', 'amount', 'status', 'created_at']
    list_filter = ['status', 'created_at']
    search_fields = ['transaction_id', 'order__order_number']
    readonly_fields = ['created_at', 'updated_at']


@admin.register(Refund)
class RefundAdmin(admin.ModelAdmin):
    list_display = ['refund_transaction_id', 'payment', 'amount', 'status', 'created_at']
    list_filter = ['status', 'created_at']
    search_fields = ['refund_transaction_id', 'reason']
    readonly_fields = ['created_at', 'updated_at']
