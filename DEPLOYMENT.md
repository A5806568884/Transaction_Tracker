# Deployment Guide

This guide provides step-by-step instructions for deploying the Transaction Tracker & E-Commerce Platform to production.

## Prerequisites

- Python 3.8+
- PostgreSQL or MySQL database (for production)
- Web server (Nginx or Apache)
- Process manager (Gunicorn or uWSGI)
- Domain name (optional)
- SSL certificate (recommended)

## Production Setup

### 1. Environment Configuration

Create a `.env` file in the project root:

```env
# Django Settings
SECRET_KEY=your-very-long-and-random-secret-key-here
DEBUG=False
ALLOWED_HOSTS=yourdomain.com,www.yourdomain.com

# Database Configuration (PostgreSQL example)
DB_ENGINE=django.db.backends.postgresql
DB_NAME=transaction_tracker_db
DB_USER=db_user
DB_PASSWORD=secure_db_password
DB_HOST=localhost
DB_PORT=5432

# Security Settings
SECURE_SSL_REDIRECT=True
SESSION_COOKIE_SECURE=True
CSRF_COOKIE_SECURE=True
SECURE_BROWSER_XSS_FILTER=True
SECURE_CONTENT_TYPE_NOSNIFF=True
X_FRAME_OPTIONS=DENY

# Email Configuration (for notifications)
EMAIL_BACKEND=django.core.mail.backends.smtp.EmailBackend
EMAIL_HOST=smtp.gmail.com
EMAIL_PORT=587
EMAIL_USE_TLS=True
EMAIL_HOST_USER=your-email@gmail.com
EMAIL_HOST_PASSWORD=your-email-password

# Payment Gateway (if using)
STRIPE_PUBLIC_KEY=your-stripe-public-key
STRIPE_SECRET_KEY=your-stripe-secret-key
```

### 2. Update settings.py for Production

Add to `transaction_tracker/settings.py`:

```python
from decouple import config

# Load environment variables
SECRET_KEY = config('SECRET_KEY')
DEBUG = config('DEBUG', default=False, cast=bool)
ALLOWED_HOSTS = config('ALLOWED_HOSTS', default='').split(',')

# Database
DATABASES = {
    'default': {
        'ENGINE': config('DB_ENGINE', default='django.db.backends.sqlite3'),
        'NAME': config('DB_NAME', default=BASE_DIR / 'db.sqlite3'),
        'USER': config('DB_USER', default=''),
        'PASSWORD': config('DB_PASSWORD', default=''),
        'HOST': config('DB_HOST', default=''),
        'PORT': config('DB_PORT', default=''),
    }
}

# Security settings
if not DEBUG:
    SECURE_SSL_REDIRECT = config('SECURE_SSL_REDIRECT', default=True, cast=bool)
    SESSION_COOKIE_SECURE = config('SESSION_COOKIE_SECURE', default=True, cast=bool)
    CSRF_COOKIE_SECURE = config('CSRF_COOKIE_SECURE', default=True, cast=bool)
    SECURE_BROWSER_XSS_FILTER = config('SECURE_BROWSER_XSS_FILTER', default=True, cast=bool)
    SECURE_CONTENT_TYPE_NOSNIFF = config('SECURE_CONTENT_TYPE_NOSNIFF', default=True, cast=bool)
    X_FRAME_OPTIONS = config('X_FRAME_OPTIONS', default='DENY')

# Static and Media Files
STATIC_ROOT = BASE_DIR / 'staticfiles'
MEDIA_ROOT = BASE_DIR / 'mediafiles'
```

### 3. Install Production Dependencies

Update `requirements.txt` to include production packages:

```txt
Django>=4.2,<5.0
djangorestframework>=3.14.0
django-cors-headers>=4.3.0
psycopg2-binary>=2.9.9
python-decouple>=3.8
Pillow>=10.0.0
stripe>=7.0.0
django-filter>=23.3
gunicorn>=21.2.0
whitenoise>=6.6.0
```

Install:
```bash
pip install -r requirements.txt
```

### 4. Database Setup

Create PostgreSQL database:
```bash
sudo -u postgres psql
CREATE DATABASE transaction_tracker_db;
CREATE USER db_user WITH PASSWORD 'secure_db_password';
ALTER ROLE db_user SET client_encoding TO 'utf8';
ALTER ROLE db_user SET default_transaction_isolation TO 'read committed';
ALTER ROLE db_user SET timezone TO 'UTC';
GRANT ALL PRIVILEGES ON DATABASE transaction_tracker_db TO db_user;
\q
```

Run migrations:
```bash
python manage.py migrate
python manage.py createsuperuser
```

### 5. Collect Static Files

```bash
python manage.py collectstatic --noinput
```

### 6. Configure Gunicorn

Create `gunicorn_config.py`:

```python
bind = "127.0.0.1:8000"
workers = 4
worker_class = "sync"
worker_connections = 1000
timeout = 120
keepalive = 5
max_requests = 1000
max_requests_jitter = 50
accesslog = "/var/log/gunicorn/access.log"
errorlog = "/var/log/gunicorn/error.log"
loglevel = "info"
```

Create systemd service file `/etc/systemd/system/transaction_tracker.service`:

```ini
[Unit]
Description=Transaction Tracker Gunicorn Service
After=network.target

[Service]
User=www-data
Group=www-data
WorkingDirectory=/path/to/Transaction_Tracker
Environment="PATH=/path/to/venv/bin"
ExecStart=/path/to/venv/bin/gunicorn \
    --config /path/to/Transaction_Tracker/gunicorn_config.py \
    transaction_tracker.wsgi:application

[Install]
WantedBy=multi-user.target
```

Enable and start the service:
```bash
sudo systemctl daemon-reload
sudo systemctl enable transaction_tracker
sudo systemctl start transaction_tracker
sudo systemctl status transaction_tracker
```

### 7. Configure Nginx

Create `/etc/nginx/sites-available/transaction_tracker`:

```nginx
upstream transaction_tracker {
    server 127.0.0.1:8000;
}

server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;

    ssl_certificate /path/to/ssl/certificate.crt;
    ssl_certificate_key /path/to/ssl/private.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    client_max_body_size 100M;

    location /static/ {
        alias /path/to/Transaction_Tracker/staticfiles/;
        expires 30d;
        add_header Cache-Control "public, immutable";
    }

    location /media/ {
        alias /path/to/Transaction_Tracker/mediafiles/;
        expires 7d;
        add_header Cache-Control "public";
    }

    location / {
        proxy_pass http://transaction_tracker;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_redirect off;
    }
}
```

Enable the site:
```bash
sudo ln -s /etc/nginx/sites-available/transaction_tracker /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### 8. SSL Certificate (Let's Encrypt)

Install Certbot:
```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

### 9. Firewall Configuration

```bash
sudo ufw allow 'Nginx Full'
sudo ufw allow ssh
sudo ufw enable
sudo ufw status
```

### 10. Database Backup

Create a backup script `/usr/local/bin/backup_db.sh`:

```bash
#!/bin/bash
BACKUP_DIR="/backups/transaction_tracker"
DATE=$(date +%Y%m%d_%H%M%S)
mkdir -p $BACKUP_DIR

# PostgreSQL backup
pg_dump -U db_user -h localhost transaction_tracker_db | gzip > $BACKUP_DIR/db_backup_$DATE.sql.gz

# Keep only last 30 days of backups
find $BACKUP_DIR -name "db_backup_*.sql.gz" -mtime +30 -delete
```

Make it executable and add to crontab:
```bash
sudo chmod +x /usr/local/bin/backup_db.sh
sudo crontab -e
# Add this line for daily backup at 2 AM:
0 2 * * * /usr/local/bin/backup_db.sh
```

## Docker Deployment (Alternative)

### Create Dockerfile

```dockerfile
FROM python:3.11-slim

ENV PYTHONUNBUFFERED=1
ENV PYTHONDONTWRITEBYTECODE=1

WORKDIR /app

RUN apt-get update && apt-get install -y \
    postgresql-client \
    && rm -rf /var/lib/apt/lists/*

COPY requirements.txt /app/
RUN pip install --no-cache-dir -r requirements.txt

COPY . /app/

RUN python manage.py collectstatic --noinput

EXPOSE 8000

CMD ["gunicorn", "--bind", "0.0.0.0:8000", "--workers", "4", "transaction_tracker.wsgi:application"]
```

### Create docker-compose.yml

```yaml
version: '3.8'

services:
  db:
    image: postgres:15
    volumes:
      - postgres_data:/var/lib/postgresql/data
    environment:
      - POSTGRES_DB=transaction_tracker_db
      - POSTGRES_USER=db_user
      - POSTGRES_PASSWORD=secure_db_password
    ports:
      - "5432:5432"

  web:
    build: .
    command: gunicorn transaction_tracker.wsgi:application --bind 0.0.0.0:8000
    volumes:
      - .:/app
      - static_volume:/app/staticfiles
      - media_volume:/app/mediafiles
    ports:
      - "8000:8000"
    depends_on:
      - db
    env_file:
      - .env

  nginx:
    image: nginx:alpine
    volumes:
      - ./nginx.conf:/etc/nginx/conf.d/default.conf
      - static_volume:/app/staticfiles
      - media_volume:/app/mediafiles
    ports:
      - "80:80"
      - "443:443"
    depends_on:
      - web

volumes:
  postgres_data:
  static_volume:
  media_volume:
```

### Build and Run

```bash
docker-compose up -d --build
docker-compose exec web python manage.py migrate
docker-compose exec web python manage.py createsuperuser
```

## Monitoring

### Setup Logging

Update `settings.py`:

```python
LOGGING = {
    'version': 1,
    'disable_existing_loggers': False,
    'formatters': {
        'verbose': {
            'format': '{levelname} {asctime} {module} {process:d} {thread:d} {message}',
            'style': '{',
        },
    },
    'handlers': {
        'file': {
            'level': 'INFO',
            'class': 'logging.handlers.RotatingFileHandler',
            'filename': '/var/log/transaction_tracker/django.log',
            'maxBytes': 1024 * 1024 * 15,  # 15MB
            'backupCount': 10,
            'formatter': 'verbose',
        },
        'console': {
            'level': 'INFO',
            'class': 'logging.StreamHandler',
            'formatter': 'verbose',
        },
    },
    'root': {
        'handlers': ['console', 'file'],
        'level': 'INFO',
    },
}
```

### Performance Monitoring

Consider using:
- **New Relic** or **Datadog** for APM
- **Sentry** for error tracking
- **Prometheus + Grafana** for metrics

## Maintenance

### Regular Tasks

1. **Database maintenance**:
   ```bash
   python manage.py dbshell
   VACUUM ANALYZE;
   ```

2. **Clear old sessions**:
   ```bash
   python manage.py clearsessions
   ```

3. **Update dependencies**:
   ```bash
   pip list --outdated
   pip install --upgrade package_name
   ```

4. **Check for security issues**:
   ```bash
   pip install safety
   safety check
   ```

### Scaling Considerations

For high traffic:
1. Use a CDN for static files (CloudFront, CloudFlare)
2. Implement Redis for caching
3. Use Celery for async tasks
4. Consider load balancing with multiple app servers
5. Implement database read replicas

## Troubleshooting

### Common Issues

1. **Static files not loading**:
   - Check STATIC_ROOT and STATIC_URL settings
   - Run `python manage.py collectstatic`
   - Verify Nginx configuration

2. **Database connection errors**:
   - Verify database credentials in .env
   - Check PostgreSQL is running: `sudo systemctl status postgresql`
   - Test connection: `psql -U db_user -d transaction_tracker_db`

3. **Permission errors**:
   - Check file ownership: `chown -R www-data:www-data /path/to/project`
   - Verify log directory permissions

4. **502 Bad Gateway**:
   - Check Gunicorn is running: `sudo systemctl status transaction_tracker`
   - Review error logs: `sudo journalctl -u transaction_tracker -n 50`

## Security Checklist

- [ ] DEBUG=False in production
- [ ] Strong SECRET_KEY (50+ characters)
- [ ] Database password is strong and unique
- [ ] SSL/TLS certificate installed and configured
- [ ] Firewall configured (ufw or iptables)
- [ ] Regular security updates applied
- [ ] Database backups automated
- [ ] Environment variables stored securely
- [ ] ALLOWED_HOSTS configured correctly
- [ ] CSRF and XSS protection enabled
- [ ] User input validation in place
- [ ] API rate limiting configured
- [ ] Logs monitored regularly

## Support

For deployment issues:
1. Check logs: `/var/log/nginx/error.log` and `/var/log/gunicorn/error.log`
2. Review Django debug output (temporarily set DEBUG=True in safe environment)
3. Consult Django documentation: https://docs.djangoproject.com/
4. Open an issue on GitHub
