from rest_framework import serializers
from .models import (
    PaymentMethod, CreditCardPayment, BankAccountPayment,
    BranchlessBankingPayment, Payment, Refund
)


class CreditCardPaymentSerializer(serializers.ModelSerializer):
    class Meta:
        model = CreditCardPayment
        fields = [
            'id', 'card_holder_name', 'card_number_last4', 'card_type',
            'expiry_month', 'expiry_year', 'billing_address'
        ]


class BankAccountPaymentSerializer(serializers.ModelSerializer):
    class Meta:
        model = BankAccountPayment
        fields = [
            'id', 'account_holder_name', 'bank_name', 'account_number_last4',
            'routing_number', 'account_type'
        ]


class BranchlessBankingPaymentSerializer(serializers.ModelSerializer):
    class Meta:
        model = BranchlessBankingPayment
        fields = [
            'id', 'account_holder_name', 'provider_name', 'mobile_number', 'account_id'
        ]


class PaymentMethodSerializer(serializers.ModelSerializer):
    credit_card = CreditCardPaymentSerializer(read_only=True)
    bank_account = BankAccountPaymentSerializer(read_only=True)
    branchless_banking = BranchlessBankingPaymentSerializer(read_only=True)

    class Meta:
        model = PaymentMethod
        fields = [
            'id', 'customer', 'payment_type', 'is_default', 'is_active',
            'credit_card', 'bank_account', 'branchless_banking',
            'created_at', 'updated_at'
        ]
        read_only_fields = ['created_at', 'updated_at']


class PaymentSerializer(serializers.ModelSerializer):
    order_number = serializers.CharField(source='order.order_number', read_only=True)

    class Meta:
        model = Payment
        fields = [
            'id', 'order', 'order_number', 'payment_method', 'amount', 'status',
            'transaction_id', 'payment_gateway_response', 'notes',
            'created_at', 'updated_at'
        ]
        read_only_fields = ['created_at', 'updated_at']


class RefundSerializer(serializers.ModelSerializer):
    payment_transaction_id = serializers.CharField(source='payment.transaction_id', read_only=True)

    class Meta:
        model = Refund
        fields = [
            'id', 'payment', 'payment_transaction_id', 'amount', 'reason',
            'status', 'refund_transaction_id', 'created_by',
            'created_at', 'updated_at'
        ]
        read_only_fields = ['created_at', 'updated_at']
