# Event Photo Wall - Hướng dẫn cài đặt và sử dụng

Ứng dụng Photo Wall cho sự kiện - cho phép người tham dự sự kiện chia sẻ ảnh và cảm nhận, hiển thị trên màn hình lớn dạng "bức tường ảnh".

## 🚀 Cài đặt nhanh

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

### Bước 3: Cấu hình Nginx

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

## 📱 Sử dụng

### Trang Form (cho người tham dự)
- **URL**: `http://project1.local/form`
- Người tham dự nhập tên, cảm nhận và chụp ảnh
- Sau khi submit sẽ hiển thị trang cảm ơn

### Trang Photo Wall (để trình chiếu)
- **URL**: `http://project1.local/wall`
- Hiển thị tất cả ảnh đã submit dạng "bức tường"
- Tự động cập nhật mỗi 5 giây khi có ảnh mới
- Hiệu ứng animation khi có ảnh mới

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

1. **HTTPS cho camera:** Chức năng chụp ảnh chỉ hoạt động trên:
   - `localhost`
   - HTTPS (https://)
   
   Nếu cần camera hoạt động trên domain thật, cần cấu hình SSL (có thể dùng Let's Encrypt):
   ```bash
   sudo certbot --nginx -d project1.local
   ```

2. **Database connection:**
   - User: `dung`
   - Password: `P@ssw0rd`
   - Database: `project1_db`

3. **PHP-FPM Socket:** Đảm bảo path `unix:/var/run/php/php8.2-fpm.sock` đúng với phiên bản PHP đang dùng.

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
