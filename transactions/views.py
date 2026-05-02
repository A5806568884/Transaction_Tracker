from rest_framework import viewsets, filters
from django_filters.rest_framework import DjangoFilterBackend
from .models import TransactionCategory, Sale, Purchase, Income, Expense, BankingTransaction
from .serializers import (
    TransactionCategorySerializer, SaleSerializer, PurchaseSerializer,
    IncomeSerializer, ExpenseSerializer, BankingTransactionSerializer
)


class TransactionCategoryViewSet(viewsets.ModelViewSet):
    queryset = TransactionCategory.objects.all()
    serializer_class = TransactionCategorySerializer
    filter_backends = [filters.SearchFilter]
    search_fields = ['name']


class SaleViewSet(viewsets.ModelViewSet):
    queryset = Sale.objects.all()
    serializer_class = SaleSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['date', 'category']
    search_fields = ['customer_name', 'product_name']
    ordering_fields = ['date', 'total_amount', 'created_at']
    ordering = ['-date']

    def perform_create(self, serializer):
        serializer.save(created_by=self.request.user)


class PurchaseViewSet(viewsets.ModelViewSet):
    queryset = Purchase.objects.all()
    serializer_class = PurchaseSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['date', 'category']
    search_fields = ['supplier_name', 'product_name']
    ordering_fields = ['date', 'total_amount', 'created_at']
    ordering = ['-date']

    def perform_create(self, serializer):
        serializer.save(created_by=self.request.user)


class IncomeViewSet(viewsets.ModelViewSet):
    queryset = Income.objects.all()
    serializer_class = IncomeSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['date', 'category']
    search_fields = ['source', 'description']
    ordering_fields = ['date', 'amount', 'created_at']
    ordering = ['-date']

    def perform_create(self, serializer):
        serializer.save(created_by=self.request.user)


class ExpenseViewSet(viewsets.ModelViewSet):
    queryset = Expense.objects.all()
    serializer_class = ExpenseSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['date', 'category']
    search_fields = ['expense_type', 'description']
    ordering_fields = ['date', 'amount', 'created_at']
    ordering = ['-date']

    def perform_create(self, serializer):
        serializer.save(created_by=self.request.user)


class BankingTransactionViewSet(viewsets.ModelViewSet):
    queryset = BankingTransaction.objects.all()
    serializer_class = BankingTransactionSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter, filters.OrderingFilter]
    filterset_fields = ['transaction_type', 'date']
    search_fields = ['reference_number', 'account_number', 'description']
    ordering_fields = ['date', 'amount', 'created_at']
    ordering = ['-date']

    def perform_create(self, serializer):
        serializer.save(created_by=self.request.user)

