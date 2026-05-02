# Contributing to Transaction Tracker & E-Commerce Platform

Thank you for considering contributing to this project! This document provides guidelines for contributing.

## Code of Conduct

### Our Pledge
We are committed to providing a welcoming and inspiring community for all. Please be respectful and considerate in all interactions.

### Expected Behavior
- Use welcoming and inclusive language
- Be respectful of differing viewpoints
- Accept constructive criticism gracefully
- Focus on what is best for the community
- Show empathy towards other community members

## How to Contribute

### Reporting Bugs

Before creating a bug report:
1. Check if the issue already exists in the issue tracker
2. Ensure you're using the latest version
3. Verify the bug is reproducible

When creating a bug report, include:
- Clear, descriptive title
- Steps to reproduce the behavior
- Expected behavior
- Actual behavior
- Screenshots (if applicable)
- Environment details (OS, Python version, Django version)
- Error messages or logs

### Suggesting Enhancements

Enhancement suggestions are welcome! Include:
- Clear description of the feature
- Why this feature would be useful
- Possible implementation approach
- Examples from other projects (if applicable)

### Pull Requests

1. **Fork the repository**
   ```bash
   git clone https://github.com/A5806568884/Transaction_Tracker.git
   cd Transaction_Tracker
   ```

2. **Create a branch**
   ```bash
   git checkout -b feature/your-feature-name
   # or
   git checkout -b fix/your-bug-fix
   ```

3. **Make your changes**
   - Follow the coding standards (see below)
   - Add tests for new functionality
   - Update documentation as needed
   - Ensure all tests pass

4. **Commit your changes**
   ```bash
   git add .
   git commit -m "Add descriptive commit message"
   ```

5. **Push to your fork**
   ```bash
   git push origin feature/your-feature-name
   ```

6. **Create a Pull Request**
   - Provide a clear description of the changes
   - Reference any related issues
   - Include screenshots for UI changes

## Development Setup

### Prerequisites
- Python 3.8+
- pip
- virtualenv (recommended)
- Git

### Setup Instructions

1. **Clone and setup virtual environment**
   ```bash
   git clone https://github.com/A5806568884/Transaction_Tracker.git
   cd Transaction_Tracker
   python -m venv venv
   source venv/bin/activate  # On Windows: venv\Scripts\activate
   ```

2. **Install dependencies**
   ```bash
   pip install -r requirements.txt
   ```

3. **Setup database**
   ```bash
   python manage.py migrate
   python manage.py createsuperuser
   ```

4. **Run development server**
   ```bash
   python manage.py runserver
   ```

5. **Access the application**
   - Admin: http://127.0.0.1:8000/admin/
   - API: http://127.0.0.1:8000/api/

## Coding Standards

### Python Style Guide
Follow PEP 8 guidelines:
- Use 4 spaces for indentation
- Maximum line length: 79 characters for code, 72 for comments
- Use descriptive variable names
- Add docstrings to all functions, classes, and modules

### Django Best Practices
- Use Django's built-in features when possible
- Follow the DRY (Don't Repeat Yourself) principle
- Use class-based views for consistency
- Implement proper error handling
- Use Django's migration system for database changes

### Code Examples

**Good:**
```python
class ProductViewSet(viewsets.ModelViewSet):
    """
    ViewSet for managing products in the e-commerce catalog.
    
    Provides standard CRUD operations with filtering and search capabilities.
    """
    queryset = Product.objects.filter(is_active=True)
    serializer_class = ProductSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter]
    search_fields = ['name', 'description']
```

**Bad:**
```python
class ProductViewSet(viewsets.ModelViewSet):
    queryset = Product.objects.all()
    serializer_class = ProductSerializer
```

### Naming Conventions
- **Models**: Singular, PascalCase (e.g., `Product`, `OrderItem`)
- **Variables/Functions**: snake_case (e.g., `total_amount`, `calculate_price()`)
- **Constants**: UPPER_SNAKE_CASE (e.g., `MAX_QUANTITY`)
- **Classes**: PascalCase (e.g., `ProductSerializer`)

## Testing

### Running Tests
```bash
# Run all tests
python manage.py test

# Run tests for specific app
python manage.py test transactions
python manage.py test ecommerce
python manage.py test payments

# Run with coverage
pip install coverage
coverage run manage.py test
coverage report
coverage html  # Generate HTML report
```

### Writing Tests

Create tests for:
- Model creation and validation
- API endpoints (GET, POST, PUT, DELETE)
- Authentication and permissions
- Business logic and calculations
- Edge cases and error handling

Example test:
```python
from django.test import TestCase
from decimal import Decimal
from .models import Sale

class SaleModelTest(TestCase):
    def setUp(self):
        self.sale = Sale.objects.create(
            customer_name="Test Customer",
            product_name="Test Product",
            quantity=2,
            unit_price=Decimal('100.00')
        )
    
    def test_total_calculation(self):
        """Test that total_amount is calculated correctly"""
        expected_total = Decimal('200.00')
        self.assertEqual(self.sale.total_amount, expected_total)
    
    def test_sale_string_representation(self):
        """Test the string representation of Sale model"""
        self.assertIn("Test Product", str(self.sale))
```

## Documentation

### Code Documentation
- Add docstrings to all public functions and classes
- Include parameter descriptions and return values
- Provide usage examples for complex functionality

### API Documentation
- Document all endpoints in API_EXAMPLES.md
- Include request/response examples
- Document all query parameters and filters

### Updating README
Update README.md when:
- Adding new features
- Changing installation steps
- Modifying configuration requirements
- Adding new dependencies

## Commit Messages

Follow conventional commits format:

```
<type>(<scope>): <subject>

<body>

<footer>
```

**Types:**
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting, etc.)
- `refactor`: Code refactoring
- `test`: Adding or updating tests
- `chore`: Maintenance tasks

**Examples:**
```
feat(transactions): Add bulk import for sales data

Implement CSV import functionality for sales records.
Users can now upload a CSV file to import multiple sales at once.

Closes #123
```

```
fix(payments): Correct payment status update logic

Fixed issue where payment status wasn't updating correctly
after processing. Added additional validation checks.

Fixes #456
```

## Review Process

### Pull Request Checklist
- [ ] Code follows style guidelines
- [ ] Tests added for new functionality
- [ ] All tests pass
- [ ] Documentation updated
- [ ] No security vulnerabilities introduced
- [ ] Commit messages are clear and descriptive
- [ ] Code is properly commented

### Review Timeline
- Initial review: Within 2-3 days
- Follow-up reviews: Within 1-2 days
- Approval required from at least one maintainer

## Areas for Contribution

### High Priority
- Performance optimizations
- Additional payment gateway integrations
- Enhanced reporting features
- Mobile app development
- Advanced analytics dashboard

### Good First Issues
- Documentation improvements
- Test coverage expansion
- UI/UX enhancements
- Bug fixes
- Code refactoring

### Feature Requests
Check the issues page for feature requests marked as "enhancement"

## Getting Help

### Resources
- [Django Documentation](https://docs.djangoproject.com/)
- [Django REST Framework](https://www.django-rest-framework.org/)
- [Python Documentation](https://docs.python.org/)

### Communication
- GitHub Issues: For bugs and feature requests
- Pull Requests: For code discussions
- Email: For private inquiries

## License

By contributing, you agree that your contributions will be licensed under the same license as the project (MIT License).

## Recognition

Contributors will be:
- Listed in the project README
- Mentioned in release notes
- Credited in commit history

## Questions?

Don't hesitate to ask questions! Create an issue with the "question" label, and we'll be happy to help.

Thank you for contributing! 🎉
