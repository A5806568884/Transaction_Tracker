from rest_framework import serializers
from .models import TransactionCategory, Sale, Purchase, Income, Expense, BankingTransaction


class TransactionCategorySerializer(serializers.ModelSerializer):
    class Meta:
        model = TransactionCategory
        fields = ['id', 'name', 'description', 'created_at']
        read_only_fields = ['created_at']


class SaleSerializer(serializers.ModelSerializer):
    class Meta:
        model = Sale
        fields = [
            'id', 'customer_name', 'product_name', 'quantity', 'unit_price',
            'total_amount', 'category', 'date', 'notes', 'created_at', 'updated_at'
        ]
        read_only_fields = ['total_amount', 'date', 'created_at', 'updated_at']


class PurchaseSerializer(serializers.ModelSerializer):
    class Meta:
        model = Purchase
        fields = [
            'id', 'supplier_name', 'product_name', 'quantity', 'unit_price',
            'total_amount', 'category', 'date', 'notes', 'created_at', 'updated_at'
        ]
        read_only_fields = ['total_amount', 'date', 'created_at', 'updated_at']


class IncomeSerializer(serializers.ModelSerializer):
    class Meta:
        model = Income
        fields = [
            'id', 'source', 'amount', 'category', 'date', 
            'description', 'created_at', 'updated_at'
        ]
        read_only_fields = ['date', 'created_at', 'updated_at']


class ExpenseSerializer(serializers.ModelSerializer):
    class Meta:
        model = Expense
        fields = [
            'id', 'expense_type', 'amount', 'category', 'date',
            'description', 'created_at', 'updated_at'
        ]
        read_only_fields = ['date', 'created_at', 'updated_at']


class BankingTransactionSerializer(serializers.ModelSerializer):
    class Meta:
        model = BankingTransaction
        fields = [
            'id', 'transaction_type', 'account_number', 'amount', 'balance_after',
            'reference_number', 'date', 'description', 'created_at', 'updated_at'
        ]
        read_only_fields = ['date', 'created_at', 'updated_at']
