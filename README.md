# Event Photo Wall - Hướng dẫn cài đặt và sử dụng

Ứng dụng Photo Wall cho sự kiện - cho phép người tham dự sự kiện chia sẻ ảnh và cảm nhận, hiển thị trên màn hình lớn dạng "bức tường ảnh".

---

## 📑 Mục lục

- [� Yêu cầu hệ thống & Cài đặt packages](#-yêu-cầu-hệ-thống--cài-đặt-packages)
- [�🚀 Cài đặt nhanh (Local)](#-cài-đặt-nhanh-local)
- [🌐 Deploy Public với HTTPS](#-deploy-public-với-https)
- [📱 Sử dụng](#-sử-dụng)
- [🎯 Tính năng](#-tính-năng)
- [🔧 Cấu trúc thư mục](#-cấu-trúc-thư-mục)
- [🎨 Tùy chỉnh](#-tùy-chỉnh)
- [🔍 Troubleshooting](#-troubleshooting)

---

## 📦 Yêu cầu hệ thống & Cài đặt packages

### Yêu cầu tối thiểu

| Thành phần | Phiên bản | Ghi chú |
|------------|-----------|---------|
| **PHP** | >= 8.1 | Khuyến nghị 8.2 |
| **MySQL/MariaDB** | >= 5.7 / >= 10.3 | |
| **Nginx** | >= 1.18 | Hoặc Apache |
| **Composer** | >= 2.0 | Package manager PHP |
| **Node.js** | >= 18 | Cho Vite assets (optional) |

---

### Bước 0: Cài đặt các packages cần thiết (Ubuntu/Debian)

#### 1. Cập nhật hệ thống
```bash
sudo apt update && sudo apt upgrade -y
```

#### 2. Cài đặt PHP 8.2 và các extension cần thiết
```bash
# Thêm repository PHP (nếu cần)
sudo apt install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

# Cài đặt PHP 8.2 và các extension cho Laravel
sudo apt install php8.2 php8.2-fpm php8.2-cli php8.2-common \
    php8.2-mysql php8.2-pgsql php8.2-sqlite3 \
    php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip \
    php8.2-gd php8.2-imagick php8.2-bcmath php8.2-intl \
    php8.2-readline php8.2-tokenizer php8.2-fileinfo \
    php8.2-dom php8.2-ctype -y
```

**Danh sách PHP Extensions chi tiết:**

| Extension | Mô tả | Bắt buộc |
|-----------|-------|----------|
| `php8.2-fpm` | FastCGI Process Manager (cho Nginx) | ✅ |
| `php8.2-mysql` | Kết nối MySQL/MariaDB | ✅ |
| `php8.2-mbstring` | Xử lý chuỗi đa byte (UTF-8, tiếng Việt) | ✅ |
| `php8.2-xml` | Xử lý XML | ✅ |
| `php8.2-curl` | HTTP requests | ✅ |
| `php8.2-zip` | Nén/giải nén file | ✅ |
| `php8.2-gd` | Xử lý hình ảnh (resize, crop) | ✅ |
| `php8.2-imagick` | Xử lý ảnh nâng cao | Khuyến nghị |
| `php8.2-bcmath` | Tính toán số lớn | ✅ |
| `php8.2-intl` | Quốc tế hóa | Khuyến nghị |
| `php8.2-fileinfo` | Nhận diện loại file | ✅ |

#### 3. Cài đặt MySQL/MariaDB
```bash
# Cài đặt MariaDB (khuyến nghị)
sudo apt install mariadb-server mariadb-client -y

# Hoặc MySQL
# sudo apt install mysql-server mysql-client -y

# Khởi động và enable service
sudo systemctl start mariadb
sudo systemctl enable mariadb

# Bảo mật MySQL (đặt password root, xóa user anonymous...)
sudo mysql_secure_installation
```

#### 4. Cài đặt Nginx
```bash
# Cài đặt Nginx
sudo apt install nginx -y

# Khởi động và enable service
sudo systemctl start nginx
sudo systemctl enable nginx

# Kiểm tra trạng thái
sudo systemctl status nginx
```

#### 5. Cài đặt Composer
```bash
# Tải Composer installer
cd ~
curl -sS https://getcomposer.org/installer -o composer-setup.php

# Cài đặt Composer globally
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Xóa file cài đặt
rm composer-setup.php

# Kiểm tra version
composer --version
```

#### 6. Cài đặt Node.js và NPM (Optional - cho Vite)
```bash
# Cài đặt Node.js 20 LTS
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install nodejs -y

# Kiểm tra version
node -v
npm -v
```

#### 7. Cài đặt Certbot cho SSL (Let's Encrypt)
```bash
# Cài đặt Certbot và plugin Nginx
sudo apt install certbot python3-certbot-nginx -y

# Kiểm tra version
certbot --version
```

#### 8. Cài đặt các công cụ hỗ trợ
```bash
# Git (quản lý source code)
sudo apt install git -y

# Unzip (giải nén)
sudo apt install unzip -y

# Supervisor (quản lý queue - optional)
sudo apt install supervisor -y
```

---

### Cấu hình PHP cho upload ảnh

Chỉnh sửa file `/etc/php/8.2/fpm/php.ini`:

```bash
sudo nano /etc/php/8.2/fpm/php.ini
```

Tìm và sửa các dòng sau:
```ini
; Tăng kích thước upload (mặc định là 2M)
upload_max_filesize = 20M
post_max_size = 25M

; Tăng memory limit
memory_limit = 256M

; Tăng thời gian thực thi
max_execution_time = 300
max_input_time = 300
```

Restart PHP-FPM:
```bash
sudo systemctl restart php8.2-fpm
```

---

### Kiểm tra cài đặt

```bash
# Kiểm tra PHP version và modules
php -v
php -m

# Kiểm tra các service đang chạy
sudo systemctl status php8.2-fpm
sudo systemctl status nginx
sudo systemctl status mariadb

# Kiểm tra Composer
composer --version

# Kiểm tra Certbot
certbot --version
```

---

### Tóm tắt lệnh cài đặt (One-liner)

Copy và chạy lệnh sau để cài đặt tất cả trong 1 lần:

```bash
# Ubuntu 22.04/24.04 - Full installation
sudo apt update && sudo apt upgrade -y && \
sudo apt install software-properties-common -y && \
sudo add-apt-repository ppa:ondrej/php -y && \
sudo apt update && \
sudo apt install nginx mariadb-server mariadb-client \
    php8.2 php8.2-fpm php8.2-cli php8.2-common \
    php8.2-mysql php8.2-mbstring php8.2-xml php8.2-curl \
    php8.2-zip php8.2-gd php8.2-imagick php8.2-bcmath \
    php8.2-intl php8.2-fileinfo php8.2-dom php8.2-ctype \
    git unzip certbot python3-certbot-nginx -y && \
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer && \
sudo systemctl enable nginx php8.2-fpm mariadb && \
sudo systemctl start nginx php8.2-fpm mariadb
```

---

## 🚀 Cài đặt nhanh (Local)

### Bước 1: Import Database

```bash
# Chạy với quyền sudo (sẽ tự động tạo database, tables và user 'dung')
sudo mysql < /home/dung/DB_PRJ1/database_schema.sql
```

**Hoặc** đăng nhập MySQL và import:
```bash
mysql -u root -p
# Nhập password rồi chạy:
source /home/dung/DB_PRJ1/database_schema.sql;
```

Script SQL sẽ tự động:
- Tạo database `project1_db`
- Tạo các tables cần thiết
- Tạo user `dung` với password `P@ssw0rd`
- Cấp quyền cho user `dung` trên database

### Bước 2: Cấu hình đã sẵn sàng

File `.env` đã được cấu hình với:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project1_db
DB_USERNAME=dung
DB_PASSWORD=P@ssw0rd
```

### Bước 3: Cấu hình Nginx (Local)

Trang web đang được triển khai trên **Nginx**, song song với trang web `bvtn.com`.

Thêm cấu hình vào Nginx (tạo file `/etc/nginx/sites-available/project1.local`):

```nginx
server {
    listen 80;
    server_name project1.local;
    root /var/www/project1.local/public;
    
    index index.php index.html;
    
    charset utf-8;
    
    # Logging
    access_log /var/log/nginx/project1.local.access.log;
    error_log /var/log/nginx/project1.local.error.log;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    
    error_page 404 /index.php;
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

**Kích hoạt site và reload Nginx:**
```bash
# Tạo symbolic link 
sudo ln -s /etc/nginx/sites-available/project1.local /etc/nginx/sites-enabled/

# Kiểm tra cấu hình
sudo nginx -t

# Reload Nginx
sudo systemctl reload nginx
```

**Thêm vào file hosts (nếu test local):**
```bash
echo "127.0.0.1 project1.local" | sudo tee -a /etc/hosts
```

### Bước 4: Phân quyền thư mục

```bash
# Phân quyền cho storage và cache
sudo chmod -R 775 /var/www/project1.local/storage
sudo chmod -R 775 /var/www/project1.local/bootstrap/cache
sudo chown -R www-data:www-data /var/www/project1.local/storage
sudo chown -R www-data:www-data /var/www/project1.local/bootstrap/cache

# Storage link (nếu chưa chạy)
cd /var/www/project1.local
php artisan storage:link
```

---

## 🌐 Deploy Public với HTTPS

> ⚠️ **QUAN TRỌNG**: Chức năng chụp ảnh từ camera **BẮT BUỘC** phải chạy trên HTTPS hoặc localhost. Đây là yêu cầu bảo mật của trình duyệt.

### Yêu cầu trước khi bắt đầu

- ✅ Server đã cài đặt Nginx và PHP-FPM
- ✅ Có domain trỏ về IP của server (VD: `photowall.example.com`)
- ✅ Mở port 80 và 443 trên firewall
- ✅ Đã hoàn thành các bước cài đặt ở phần trên (Database, Storage...)

---

### Bước 1: Cấu hình DNS

Truy cập nhà cung cấp domain của bạn và tạo **A Record**:

| Loại | Host | Giá trị | TTL |
|------|------|---------|-----|
| A | photowall | `YOUR_SERVER_IP` | 300 |

> 💡 Thay `photowall` bằng subdomain bạn muốn, hoặc `@` nếu dùng domain chính.

Chờ DNS propagate (thường 5-30 phút). Kiểm tra bằng lệnh:
```bash
nslookup photowall.example.com
# hoặc
dig photowall.example.com
```

---

### Bước 2: Cài đặt Certbot (Let's Encrypt)

```bash
# Cài đặt Certbot và plugin Nginx
sudo apt update
sudo apt install certbot python3-certbot-nginx -y
```

---

### Bước 3: Cấu hình Nginx cho Domain thật

Tạo file cấu hình mới `/etc/nginx/sites-available/photowall.example.com`:

```bash
sudo nano /etc/nginx/sites-available/photowall.example.com
```

Nội dung file (thay `photowall.example.com` bằng domain thật của bạn):

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name photowall.example.com;
    root /var/www/project1.local/public;
    
    index index.php index.html;
    
    charset utf-8;
    
    # Tăng kích thước upload cho ảnh
    client_max_body_size 20M;
    
    # Logging
    access_log /var/log/nginx/photowall.access.log;
    error_log /var/log/nginx/photowall.error.log;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    
    error_page 404 /index.php;
    
    # PHP-FPM
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        
        # Timeout cho upload
        fastcgi_read_timeout 300;
    }
    
    # Bảo mật - chặn các file ẩn (trừ .well-known cho Let's Encrypt)
    location ~ /\.(?!well-known).* {
        deny all;
    }
    
    # Cache static files
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff|woff2)$ {
        expires 1M;
        access_log off;
        add_header Cache-Control "public, immutable";
    }
}
```

Kích hoạt site:
```bash
# Tạo symbolic link
sudo ln -s /etc/nginx/sites-available/photowall.example.com /etc/nginx/sites-enabled/

# Kiểm tra cấu hình
sudo nginx -t

# Reload Nginx
sudo systemctl reload nginx
```

---

### Bước 4: Lấy SSL Certificate (HTTPS)

Chạy Certbot để tự động lấy và cấu hình SSL:

```bash
sudo certbot --nginx -d photowall.example.com
```

Certbot sẽ hỏi bạn:
1. **Email**: Nhập email để nhận thông báo hết hạn SSL
2. **Terms of Service**: Nhấn `A` để đồng ý
3. **Newsletter**: Nhấn `N` để bỏ qua
4. **Redirect HTTP to HTTPS**: Chọn `2` để tự động redirect

> ✅ Sau khi hoàn tất, Certbot sẽ tự động:
> - Lấy SSL certificate miễn phí
> - Thêm cấu hình HTTPS vào Nginx
> - Thiết lập auto-redirect từ HTTP sang HTTPS
> - Thiết lập tự động gia hạn SSL

Kiểm tra SSL:
```bash
sudo certbot certificates
```

---

### Bước 5: Cập nhật file .env

Cập nhật file `.env` với domain mới:

```bash
cd /var/www/project1.local
nano .env
```

Sửa các dòng sau:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://photowall.example.com
```

Clear cache:
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

### Bước 6: Kiểm tra cấu hình HTTPS

Nginx config sau khi Certbot cập nhật sẽ tương tự:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name photowall.example.com;
    
    # Redirect tất cả HTTP sang HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name photowall.example.com;
    root /var/www/project1.local/public;
    
    # SSL Certificate (được Certbot thêm tự động)
    ssl_certificate /etc/letsencrypt/live/photowall.example.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/photowall.example.com/privkey.pem;
    include /etc/letsencrypt/options-ssl-nginx.conf;
    ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem;
    
    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    
    index index.php index.html;
    charset utf-8;
    client_max_body_size 20M;
    
    # Logging
    access_log /var/log/nginx/photowall.access.log;
    error_log /var/log/nginx/photowall.error.log;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    
    error_page 404 /index.php;
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_read_timeout 300;
    }
    
    location ~ /\.(?!well-known).* {
        deny all;
    }
    
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff|woff2)$ {
        expires 1M;
        access_log off;
        add_header Cache-Control "public, immutable";
    }
}
```

---

### Bước 7: Mở Firewall (nếu cần)

```bash
# UFW (Ubuntu)
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw reload

# Hoặc dùng iptables
sudo iptables -A INPUT -p tcp --dport 80 -j ACCEPT
sudo iptables -A INPUT -p tcp --dport 443 -j ACCEPT
```

---

### Bước 8: Kiểm tra hoạt động

1. **Truy cập trang form**: `https://photowall.example.com/form`
2. **Truy cập Photo Wall**: `https://photowall.example.com/wall`
3. **Kiểm tra camera**: Mở camera trên điện thoại và chụp thử

> ✅ Nếu camera hoạt động và submit ảnh thành công, bạn đã deploy thành công!

---

### 🔄 Tự động gia hạn SSL

Let's Encrypt certificates hết hạn sau 90 ngày. Certbot đã thiết lập tự động gia hạn:

```bash
# Kiểm tra timer tự động gia hạn
sudo systemctl status certbot.timer

# Test thử gia hạn (dry-run)
sudo certbot renew --dry-run
```

---

### 📋 Checklist Deploy HTTPS

- [ ] DNS đã trỏ về server
- [ ] Certbot đã cài đặt
- [ ] Nginx config đã tạo
- [ ] SSL Certificate đã lấy thành công  
- [ ] `.env` đã cập nhật `APP_URL` với HTTPS
- [ ] Cache đã clear
- [ ] Camera hoạt động trên mobile
- [ ] Ảnh upload được và hiển thị trên wall

---

## 📱 Sử dụng

### Trang Form (cho người tham dự)
- **URL Local**: `http://project1.local/form`
- **URL HTTPS**: `https://your-domain.com/form`
- Người tham dự nhập tên, cảm nhận và chụp ảnh
- Sau khi submit sẽ hiển thị trang cảm ơn

### Trang Photo Wall (để trình chiếu)
- **URL Local**: `http://project1.local/wall`
- **URL HTTPS**: `https://your-domain.com/wall`
- Hiển thị tất cả ảnh đã submit dạng "bức tường"
- Tự động cập nhật mỗi 3 giây khi có ảnh mới
- Hiệu ứng slideshow: ảnh xuất hiện và fade ngẫu nhiên

## 🎯 Tính năng

- ✅ Form điền thông tin: Tên, Cảm nhận, Chụp ảnh trực tiếp từ camera
- ✅ Photo Wall: Hiển thị ảnh xếp ngẫu nhiên, góc xoay ngẫu nhiên
- ✅ Auto-refresh: Tự động cập nhật khi có ảnh mới (realtime)
- ✅ Responsive: Hoạt động trên cả PC và mobile
- ✅ Design premium: Dark theme với gradient và animations
- ✅ Modal xem chi tiết: Click vào ảnh để xem lớn hơn

## 🔧 Cấu trúc thư mục

```
/var/www/project1.local/
├── app/
│   ├── Http/Controllers/
│   │   └── SubmissionController.php    # Controller xử lý form
│   └── Models/
│       └── Submission.php              # Model cho submissions
├── database/
│   └── migrations/
│       └── 2024_01_15_..._submissions.php
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php               # Layout chung
│   └── submissions/
│       ├── create.blade.php            # Trang form
│       ├── success.blade.php           # Trang cảm ơn
│       └── wall.blade.php              # Photo Wall
├── routes/
│   └── web.php                         # Routes
├── storage/app/public/submissions/     # Thư mục lưu ảnh
└── .env                                # Config database

/home/dung/DB_PRJ1/
└── database_schema.sql                 # SQL script tạo database
```

## 🌐 Cấu hình song song với bvtn.com

Hiện tại Nginx đang chạy song song 2 sites:
- `bvtn.com` - Trang web chính
- `project1.local` - Event Photo Wall

Cấu trúc `/etc/nginx/sites-enabled/`:
```
/etc/nginx/sites-enabled/
├── bvtn.com          # Config cho bvtn.com
└── project1.local    # Config cho project1.local
```

## ⚠️ Lưu ý quan trọng

1. **HTTPS cho camera:** Chức năng chụp ảnh từ camera **BẮT BUỘC** phải chạy trên HTTPS hoặc localhost. Xem hướng dẫn chi tiết ở phần [Deploy Public với HTTPS](#-deploy-public-với-https).

2. **Database connection:**
   - User: `dung`
   - Password: `P@ssw0rd`
   - Database: `project1_db`

3. **PHP-FPM Socket:** Đảm bảo path `unix:/var/run/php/php8.2-fpm.sock` đúng với phiên bản PHP đang dùng.

4. **Production Mode:** Khi deploy public, nhớ đổi `APP_DEBUG=false` và `APP_ENV=production` trong file `.env`.

## 🎨 Tùy chỉnh

### Đổi màu sắc
Chỉnh sửa CSS variables trong `/resources/views/layouts/app.blade.php`:

```css
:root {
    --accent-primary: #8b5cf6;    /* Tím */
    --accent-secondary: #06b6d4;  /* Cyan */
    --accent-pink: #ec4899;       /* Hồng */
    --accent-orange: #f97316;     /* Cam */
}
```

### Đổi thời gian refresh
Chỉnh sửa `REFRESH_INTERVAL` trong `/resources/views/submissions/wall.blade.php`:

```javascript
const REFRESH_INTERVAL = 5000; // 5 giây (đổi thành ms tùy ý)
```

## 🔍 Troubleshooting

### Lỗi kết nối database
```bash
# Test kết nối
mysql -u dung -p'P@ssw0rd' project1_db -e "SHOW TABLES;"
```

### Lỗi permission storage
```bash
sudo chown -R www-data:www-data /var/www/project1.local/storage
sudo chmod -R 775 /var/www/project1.local/storage
```

### Clear cache Laravel
```bash
cd /var/www/project1.local
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

Chúc bạn tổ chức sự kiện thành công! 🎉
