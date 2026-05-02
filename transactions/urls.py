from django.urls import path, include
from rest_framework.routers import DefaultRouter
from .views import (
    TransactionCategoryViewSet, SaleViewSet, PurchaseViewSet,
    IncomeViewSet, ExpenseViewSet, BankingTransactionViewSet
)

router = DefaultRouter()
router.register(r'categories', TransactionCategoryViewSet)
router.register(r'sales', SaleViewSet)
router.register(r'purchases', PurchaseViewSet)
router.register(r'income', IncomeViewSet)
router.register(r'expenses', ExpenseViewSet)
router.register(r'banking-transactions', BankingTransactionViewSet)

urlpatterns = [
    path('', include(router.urls)),
]
