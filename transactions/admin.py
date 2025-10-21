from django.contrib import admin
from .models import TransactionCategory, Sale, Purchase, Income, Expense, BankingTransaction


@admin.register(TransactionCategory)
class TransactionCategoryAdmin(admin.ModelAdmin):
    list_display = ['name', 'created_at']
    search_fields = ['name']


@admin.register(Sale)
class SaleAdmin(admin.ModelAdmin):
    list_display = ['product_name', 'customer_name', 'quantity', 'total_amount', 'date', 'created_at']
    list_filter = ['date', 'category']
    search_fields = ['product_name', 'customer_name']
    readonly_fields = ['total_amount', 'created_at', 'updated_at']
    date_hierarchy = 'date'


@admin.register(Purchase)
class PurchaseAdmin(admin.ModelAdmin):
    list_display = ['product_name', 'supplier_name', 'quantity', 'total_amount', 'date', 'created_at']
    list_filter = ['date', 'category']
    search_fields = ['product_name', 'supplier_name']
    readonly_fields = ['total_amount', 'created_at', 'updated_at']
    date_hierarchy = 'date'


@admin.register(Income)
class IncomeAdmin(admin.ModelAdmin):
    list_display = ['source', 'amount', 'date', 'category', 'created_at']
    list_filter = ['date', 'category']
    search_fields = ['source', 'description']
    date_hierarchy = 'date'


@admin.register(Expense)
class ExpenseAdmin(admin.ModelAdmin):
    list_display = ['expense_type', 'amount', 'date', 'category', 'created_at']
    list_filter = ['date', 'category']
    search_fields = ['expense_type', 'description']
    date_hierarchy = 'date'


@admin.register(BankingTransaction)
class BankingTransactionAdmin(admin.ModelAdmin):
    list_display = ['transaction_type', 'account_number', 'amount', 'reference_number', 'date', 'created_at']
    list_filter = ['transaction_type', 'date']
    search_fields = ['reference_number', 'account_number', 'description']
    readonly_fields = ['created_at', 'updated_at']
    date_hierarchy = 'date'
