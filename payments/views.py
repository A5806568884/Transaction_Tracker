from rest_framework import viewsets, filters, status
from rest_framework.decorators import action
from rest_framework.response import Response
from django_filters.rest_framework import DjangoFilterBackend
from .models import PaymentMethod, Payment, Refund
from .serializers import PaymentMethodSerializer, PaymentSerializer, RefundSerializer


class PaymentMethodViewSet(viewsets.ModelViewSet):
    queryset = PaymentMethod.objects.all()
    serializer_class = PaymentMethodSerializer
    filter_backends = [DjangoFilterBackend]
    filterset_fields = ['payment_type', 'is_default', 'is_active']

    def get_queryset(self):
        """Filter to show only user's payment methods"""
        return PaymentMethod.objects.filter(customer=self.request.user)

    def perform_create(self, serializer):
        serializer.save(customer=self.request.user)

    @action(detail=True, methods=['post'])
    def set_default(self, request, pk=None):
        """Set a payment method as default"""
        payment_method = self.get_object()
        # Remove default from all other payment methods
        PaymentMethod.objects.filter(
            customer=request.user,
            is_default=True
        ).update(is_default=False)
        # Set this one as default
        payment_method.is_default = True
        payment_method.save()
        serializer = self.get_serializer(payment_method)
        return Response(serializer.data)


class PaymentViewSet(viewsets.ModelViewSet):
    queryset = Payment.objects.all()
    serializer_class = PaymentSerializer
    filter_backends = [DjangoFilterBackend, filters.OrderingFilter]
    filterset_fields = ['status']
    ordering_fields = ['created_at', 'amount']
    ordering = ['-created_at']

    def get_queryset(self):
        """Filter payments based on user's orders if not staff"""
        if self.request.user.is_staff:
            return Payment.objects.all()
        return Payment.objects.filter(order__customer__user=self.request.user)

    @action(detail=True, methods=['post'])
    def process(self, request, pk=None):
        """Process a payment"""
        payment = self.get_object()
        if payment.status != 'PENDING':
            return Response(
                {'detail': 'Payment can only be processed if status is PENDING'},
                status=status.HTTP_400_BAD_REQUEST
            )
        
        # Here you would integrate with actual payment gateway
        # For now, we'll just mark it as completed
        payment.status = 'COMPLETED'
        payment.save()
        
        serializer = self.get_serializer(payment)
        return Response(serializer.data)


class RefundViewSet(viewsets.ModelViewSet):
    queryset = Refund.objects.all()
    serializer_class = RefundSerializer
    filter_backends = [DjangoFilterBackend, filters.OrderingFilter]
    filterset_fields = ['status']
    ordering_fields = ['created_at', 'amount']
    ordering = ['-created_at']

    def get_queryset(self):
        """Filter refunds based on user's payments if not staff"""
        if self.request.user.is_staff:
            return Refund.objects.all()
        return Refund.objects.filter(payment__order__customer__user=self.request.user)

    def perform_create(self, serializer):
        serializer.save(created_by=self.request.user)

