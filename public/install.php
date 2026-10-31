<?php
/**
 * AtilaShop - Automated Web Installer for cPanel Shared Hosting (No SSH Required)
 * نصب‌کننده خودکار و تحت وب فروشگاه آتیلاشاپ ویژه هاست‌های اشتراکی سی‌پنل بدون نیاز به SSH
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
set_time_limit(300);

$basePath = dirname(__DIR__);
$installedLockFile = $basePath . '/storage/installed';

// بررسی وضعیت قفل نصب
$isInstalled = file_exists($installedLockFile);

// تابع کمکی کپی دایرکتوری (فال‌بک در صورت غیرفعال بودن symlink)
function copyDirRecursive($src, $dst) {
    if (!is_dir($src)) return;
    if (!is_dir($dst)) @mkdir($dst, 0755, true);
    $files = scandir($src);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $srcPath = $src . '/' . $file;
        $dstPath = $dst . '/' . $file;
        if (is_dir($srcPath)) {
            copyDirRecursive($srcPath, $dstPath);
        } else {
            @copy($srcPath, $dstPath);
        }
    }
}

// اگر درخواست AJAX باشد:
if (isset($_GET['action'])) {
    header('Content-Type: application/json; charset=utf-8');

    if ($isInstalled && $_GET['action'] !== 'status') {
        echo json_encode(['success' => false, 'message' => 'اینستالر قبلاً اجرا شده و قفل است. جهت نصب مجدد فایل storage/installed را حذف فرمایید.']);
        exit;
    }

    // تست اتصال به دیتابیس
    if ($_GET['action'] === 'test_db') {
        $dbType = $_POST['db_type'] ?? 'mysql';
        if ($dbType === 'sqlite') {
            $sqlitePath = $basePath . '/database/database.sqlite';
            if (!file_exists($sqlitePath)) {
                @touch($sqlitePath);
            }
            if (is_writable($sqlitePath) || is_writable(dirname($sqlitePath))) {
                echo json_encode(['success' => true, 'message' => 'اتصال و دسترسی به فایل دیتابیس SQLite با موفقیت برقرار شد.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'پوشه database یا فایل SQLite دسترسی نوشتن ندارد.']);
            }
            exit;
        }

        $host = trim($_POST['db_host'] ?? '127.0.0.1');
        $port = trim($_POST['db_port'] ?? '3306');
        $database = trim($_POST['db_database'] ?? '');
        $username = trim($_POST['db_username'] ?? '');
        $password = $_POST['db_password'] ?? '';

        if (empty($database) || empty($username)) {
            echo json_encode(['success' => false, 'message' => 'لطفاً نام دیتابیس و نام کاربری را وارد فرمایید.']);
            exit;
        }

        try {
            $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";
            $pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 5,
            ]);
            echo json_encode(['success' => true, 'message' => 'ارتباط با دیتابیس MySQL سی‌پنل با موفقیت برقرار شد!']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'خطا در اتصال به دیتابیس: ' . $e->getMessage()]);
        }
        exit;
    }

    // فرآیند اصلی نصب
    if ($_GET['action'] === 'run_install') {
        $dbType = $_POST['db_type'] ?? 'mysql';
        $host = trim($_POST['db_host'] ?? '127.0.0.1');
        $port = trim($_POST['db_port'] ?? '3306');
        $database = trim($_POST['db_database'] ?? '');
        $username = trim($_POST['db_username'] ?? '');
        $password = $_POST['db_password'] ?? '';
        $appUrl = rtrim(trim($_POST['app_url'] ?? ''), '/');
        $adminName = trim($_POST['admin_name'] ?? 'مدیر فروشگاه آتیلا');
        $adminEmail = trim($_POST['admin_email'] ?? 'admin@atilashop.ir');
        $adminPassword = $_POST['admin_password'] ?? 'admin123456';

        $steps = [];

        try {
            // ۱. تنظیم و نوشتن فایل .env
            $envPath = $basePath . '/.env';
            $envExamplePath = $basePath . '/.env.example';

            $appKey = '';
            if (file_exists($envPath)) {
                $existingEnv = file_get_contents($envPath);
                if (preg_match('/^APP_KEY=(.+)$/m', $existingEnv, $m)) {
                    $appKey = trim($m[1]);
                }
            }
            if (empty($appKey)) {
                $appKey = 'base64:' . base64_encode(random_bytes(32));
            }

            $envContent = "APP_NAME=\"AtilaShop\"\n";
            $envContent .= "APP_ENV=production\n";
            $envContent .= "APP_KEY={$appKey}\n";
            $envContent .= "APP_DEBUG=false\n";
            $envContent .= "APP_URL={$appUrl}\n\n";
            $envContent .= "APP_LOCALE=fa\n";
            $envContent .= "APP_FALLBACK_LOCALE=fa\n\n";

            if ($dbType === 'sqlite') {
                $sqliteFile = $basePath . '/database/database.sqlite';
                if (!file_exists($sqliteFile)) @touch($sqliteFile);
                $envContent .= "DB_CONNECTION=sqlite\n";
                $envContent .= "DB_DATABASE=" . str_replace('\\', '/', $sqliteFile) . "\n\n";
            } else {
                $envContent .= "DB_CONNECTION=mysql\n";
                $envContent .= "DB_HOST={$host}\n";
                $envContent .= "DB_PORT={$port}\n";
                $envContent .= "DB_DATABASE={$database}\n";
                $envContent .= "DB_USERNAME={$username}\n";
                $envContent .= "DB_PASSWORD=\"{$password}\"\n\n";
            }

            $envContent .= "SESSION_DRIVER=database\n";
            $envContent .= "SESSION_LIFETIME=120\n";
            $envContent .= "CACHE_STORE=file\n";
            $envContent .= "QUEUE_CONNECTION=sync\n";
            $envContent .= "FILESYSTEM_DISK=public\n";

            if (!file_exists($envPath) || file_get_contents($envPath) !== $envContent) {
                if (@file_put_contents($envPath, $envContent) === false) {
                    throw new Exception("امکان ایجاد فایل .env در مسیر اصلی پروژه وجود ندارد. لطفاً دسترسی رایت (Permission) به پوشه اصلی بدهید.");
                }
            }
            $steps[] = 'فایل پیکربندی .env با موفقیت ایجاد و کلید اختصاصی APP_KEY تنظیم شد.';

            // ۲. لود کردن فریم‌ورک لاراول در حافظه PHP
            require_once $basePath . '/vendor/autoload.php';
            $app = require_once $basePath . '/bootstrap/app.php';
            $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
            $kernel->bootstrap();

            // تنظیم دیتابیس فعال در صورت لزوم
            if ($dbType === 'mysql') {
                config([
                    'database.default' => 'mysql',
                    'database.connections.mysql.host' => $host,
                    'database.connections.mysql.port' => $port,
                    'database.connections.mysql.database' => $database,
                    'database.connections.mysql.username' => $username,
                    'database.connections.mysql.password' => $password,
                ]);
            }

            // ۳. اجرای مایگریشن‌ها و ساخت جداول
            Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--force' => true]);
            $steps[] = 'تمامی جداول پایگاه‌داده (کاربران، محصولات، سفارشات، نوتیفیکیشن‌ها و تنظیمات) ایجاد شدند.';

            // ۴. اجرای سیدرها و ورود محصولات و ایجاد حساب مدیر
            Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
            
            // به‌روزرسانی مدیر با اطلاعات وارده توسط کاربر
            $adminUser = App\Models\User::where('is_admin', true)->first();
            if ($adminUser) {
                $adminUser->update([
                    'name' => $adminName,
                    'email' => $adminEmail,
                    'password' => Illuminate\Support\Facades\Hash::make($adminPassword),
                ]);
            } else {
                App\Models\User::create([
                    'name' => $adminName,
                    'email' => $adminEmail,
                    'password' => Illuminate\Support\Facades\Hash::make($adminPassword),
                    'is_admin' => true,
                ]);
            }
            $steps[] = 'محصولات تخصصی لباس زیر ثبت و حساب ادمین با مشخصات شما فعال شد.';

            // ۵. اتصال استوریج (symlink یا کپی مستقیم عکس‌ها)
            $storageTarget = $basePath . '/storage/app/public';
            $storageLink = __DIR__ . '/storage';

            $symlinkSuccess = false;
            if (!file_exists($storageLink)) {
                if (function_exists('symlink')) {
                    $symlinkSuccess = @symlink($storageTarget, $storageLink);
                }
            } else {
                $symlinkSuccess = true;
            }

            // فال‌بک تضمینی در صورت عدم پشتیبانی هاست از symlink:
            if (!$symlinkSuccess || !is_dir($storageLink)) {
                copyDirRecursive($storageTarget, $storageLink);
                $steps[] = 'اتصال پوشه فایل‌ها (Storage) با متد کپی تضمینی هاست اشتراکی ایجاد شد.';
            } else {
                // اطمینان از وجود عکس‌ها
                copyDirRecursive($storageTarget . '/products', $storageLink . '/products');
                $steps[] = 'اتصال نمادین پوشه تصاویر محصولات (Storage Symlink) با موفقیت ایجاد شد.';
            }

            // ۶. پاکسازی کش‌ها
            Illuminate\Support\Facades\Artisan::call('config:clear');
            Illuminate\Support\Facades\Artisan::call('cache:clear');
            Illuminate\Support\Facades\Artisan::call('view:clear');
            $steps[] = 'کش‌های موقت کانفیگ و کدهای قالب بهینه‌سازی و پاکسازی شدند.';

            // ۷. ایجاد قفل نصب
            @file_put_contents($installedLockFile, json_encode([
                'installed_at' => date('Y-m-d H:i:s'),
                'app_url' => $appUrl,
                'db_type' => $dbType,
                'admin_email' => $adminEmail,
            ], JSON_PRETTY_PRINT));
            $steps[] = 'فایل امنیتی قفل نصب ایجاد شد (از اجرای دوباره جلوگیری می‌شود).';

            echo json_encode([
                'success' => true,
                'message' => 'فروشگاه آتیلاشاپ با موفقیت کامل روی هاست شما نصب و آماده استفاده شد!',
                'steps' => $steps,
                'admin_url' => $appUrl . '/admin',
                'home_url' => $appUrl,
                'admin_email' => $adminEmail,
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'خطا در فرآیند نصب: ' . $e->getMessage(),
                'steps' => $steps,
            ]);
        }
        exit;
    }
}

// بررسی پیش‌نیازهای سرور
$reqs = [
    'PHP Version (>= 8.2)' => [
        'status' => version_compare(PHP_VERSION, '8.2.0', '>='),
        'current' => PHP_VERSION,
        'req' => '>= 8.2',
    ],
    'PDO Extension' => [
        'status' => extension_loaded('pdo'),
        'current' => extension_loaded('pdo') ? 'فعال' : 'غیرفعال',
        'req' => 'الزامی',
    ],
    'PDO MySQL Extension' => [
        'status' => extension_loaded('pdo_mysql'),
        'current' => extension_loaded('pdo_mysql') ? 'فعال' : 'غیرفعال',
        'req' => 'الزامی برای سی‌پنل',
    ],
    'OpenSSL Extension' => [
        'status' => extension_loaded('openssl'),
        'current' => extension_loaded('openssl') ? 'فعال' : 'غیرفعال',
        'req' => 'الزامی',
    ],
    'Mbstring Extension' => [
        'status' => extension_loaded('mbstring'),
        'current' => extension_loaded('mbstring') ? 'فعال' : 'غیرفعال',
        'req' => 'الزامی',
    ],
    'Tokenizer Extension' => [
        'status' => extension_loaded('tokenizer'),
        'current' => extension_loaded('tokenizer') ? 'فعال' : 'غیرفعال',
        'req' => 'الزامی',
    ],
    'XML / ctype Extension' => [
        'status' => extension_loaded('xml') && extension_loaded('ctype'),
        'current' => (extension_loaded('xml') && extension_loaded('ctype')) ? 'فعال' : 'غیرفعال',
        'req' => 'الزامی',
    ],
    'FileInfo Extension' => [
        'status' => extension_loaded('fileinfo'),
        'current' => extension_loaded('fileinfo') ? 'فعال' : 'غیرفعال',
        'req' => 'الزامی (جهت آپلود فیش و عکس)',
    ],
    'cURL Extension' => [
        'status' => extension_loaded('curl'),
        'current' => extension_loaded('curl') ? 'فعال' : 'غیرفعال',
        'req' => 'الزامی (جهت درگاه بانکی)',
    ],
];

// بررسی دسترسی فایل‌ها و پوشه‌ها
$paths = [
    $basePath . '/storage' => 'پوشه storage',
    $basePath . '/storage/framework' => 'پوشه framework',
    $basePath . '/storage/logs' => 'پوشه logs',
    $basePath . '/storage/app/public' => 'پوشه public storage',
    $basePath . '/bootstrap/cache' => 'پوشه bootstrap/cache',
];

$permissionsOk = true;
$permissionResults = [];
foreach ($paths as $path => $name) {
    if (!file_exists($path)) {
        @mkdir($path, 0755, true);
    }
    $writable = is_writable($path);
    if (!$writable) $permissionsOk = false;
    $permissionResults[] = [
        'name' => $name,
        'path' => $path,
        'writable' => $writable,
    ];
}

$allReqsOk = true;
foreach ($reqs as $r) {
    if (!$r['status']) $allReqsOk = false;
}

$canProceed = $allReqsOk && $permissionsOk;

// تشخیص هوشمند URL فعلی
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$detectedUrl = $protocol . $host;
?>
<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>نصب‌کننده خودکار فروشگاه آتیلاشاپ | AtilaShop cPanel Installer</title>
    
    <!-- Digikala Official Font Preload -->
    <link rel="preload" href="/fonts/digikala-variable.woff2" as="font" type="font/woff2" crossorigin>
    
    <style>
        /* Digikala & IRANSansX Variable Webfont */
        @font-face {
            font-family: 'Digikala';
            font-style: normal;
            font-weight: 100 1000;
            font-display: swap;
            src: url('/fonts/digikala-variable.woff2') format('woff2-variations'),
                 url('/fonts/digikala-variable.woff2') format('woff2');
        }
        @font-face {
            font-family: 'IRANSansX';
            font-style: normal;
            font-weight: 100 1000;
            font-display: swap;
            src: url('/fonts/digikala-variable.woff2') format('woff2-variations'),
                 url('/fonts/digikala-variable.woff2') format('woff2');
        }
        :root {
            --bg: #f8fafc;
            --card: #ffffff;
            --ink: #0f172a;
            --muted: #64748b;
            --line: #e2e8f0;
            --brand: #b84462;
            --brand-hover: #9e3650;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Digikala', 'IRANSansX', 'IRANSans', system-ui, -apple-system, BlinkMacSystemFont, Tahoma, sans-serif;
            background: var(--bg);
            color: var(--ink);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 30px 16px;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .installer-card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 24px;
            max-width: 760px;
            width: 100%;
            padding: 32px;
            box-shadow: 0 10px 40px rgba(0,0,0,.06);
        }

        .header-box {
            text-align: center;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--line);
        }
        .logo {
            font-size: 26px;
            font-weight: 900;
            letter-spacing: -0.5px;
        }
        .logo b { color: var(--brand); }

        /* Step Indicators */
        .stepper {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-bottom: 32px;
        }
        .stepper::before {
            content: "";
            position: absolute;
            top: 18px;
            right: 30px;
            left: 30px;
            height: 3px;
            background: var(--line);
            z-index: 1;
        }
        .step-item {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            flex: 1;
        }
        .step-num {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--card);
            border: 2px solid var(--line);
            display: grid;
            place-items: center;
            font-weight: 800;
            font-size: 14px;
            color: var(--muted);
            transition: all .2s;
        }
        .step-item.active .step-num {
            background: var(--brand);
            border-color: var(--brand);
            color: #fff;
            box-shadow: 0 0 0 4px color-mix(in srgb, var(--brand) 20%, transparent);
        }
        .step-item.done .step-num {
            background: var(--success);
            border-color: var(--success);
            color: #fff;
        }
        .step-title {
            font-size: 12.5px;
            font-weight: 700;
            color: var(--muted);
        }
        .step-item.active .step-title { color: var(--brand); }
        .step-item.done .step-title { color: var(--ink); }

        /* Forms & Inputs */
        .form-group {
            margin-bottom: 18px;
        }
        label {
            display: block;
            font-size: 13.5px;
            font-weight: 600;
            margin-bottom: 6px;
        }
        input, select {
            font: inherit;
            color: inherit;
            background: var(--bg);
            border: 1px solid var(--line);
            border-radius: 12px;
            padding: 10px 14px;
            width: 100%;
            transition: border-color .2s;
        }
        input:focus, select:focus {
            outline: none;
            border-color: var(--brand);
            background: #fff;
        }

        .btn {
            background: var(--ink);
            color: #fff;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 700;
            font-size: 14px;
            border: 0;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: opacity .2s, transform .1s;
        }
        .btn:hover { opacity: .9; }
        .btn.brand { background: var(--brand); }
        .btn.success { background: var(--success); }
        .btn.o { background: none; color: var(--ink); border: 1px solid var(--line); }

        .alert {
            padding: 14px 18px;
            border-radius: 14px;
            font-size: 13.5px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-warning { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .alert-info { background: #e0f2fe; color: #075985; border: 1px solid #bae6fd; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-bottom: 20px;
        }
        th, td {
            padding: 9px 12px;
            border-bottom: 1px solid var(--line);
            text-align: right;
        }
        th { font-weight: 700; color: var(--muted); }

        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 700;
        }
        .badge.ok { background: #dcfce7; color: #166534; }
        .badge.fail { background: #fee2e2; color: #991b1b; }

        .section-pane { display: none; }
        .section-pane.active { display: block; }

        .progress-box {
            background: var(--bg);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 16px;
            max-height: 220px;
            overflow-y: auto;
            font-family: monospace;
            font-size: 13px;
            margin: 16px 0;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .progress-line {
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>
<body>

<div class="installer-card">
    <div class="header-box">
        <div class="logo">Atila<b>Shop</b></div>
        <p style="margin: 6px 0 0; color: var(--muted); font-size: 14px;">
            نصب‌کننده هوشمند و تحت وب ویژه هاست اشتراکی سی‌پنل (بدون نیاز به SSH)
        </p>
    </div>

    <?php if ($isInstalled): ?>
        <div class="alert alert-warning" style="text-align: center; padding: 28px;">
            <div style="font-size: 32px; margin-bottom: 12px;">🔒</div>
            <h3 style="margin: 0 0 8px; font-size: 18px; font-weight: 800;">سایت قبلاً با موفقیت نصب شده است!</h3>
            <p style="margin: 0 0 20px; color: var(--muted); font-size: 13.5px; line-height: 1.8;">
                اینستالر جهت حفظ امنیت پایگاه‌داده و اطلاعات سایت قفل گردیده است. در صورتی که تمایل دارید دوباره نصب را تکرار فرمایید، ابتدا فایل <code>storage/installed</code> را از فایل منیجر سی‌پنل حذف کنید.
            </p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <a href="/" class="btn brand">مشاهده فروشگاه</a>
                <a href="/admin" class="btn o">ورود به پنل ادمین</a>
            </div>
        </div>
        <?php exit; ?>
    <?php endif; ?>

    <!-- Stepper Header -->
    <div class="stepper">
        <div class="step-item active" id="st-1">
            <div class="step-num">۱</div>
            <div class="step-title">پیش‌نیازها</div>
        </div>
        <div class="step-item" id="st-2">
            <div class="step-num">۲</div>
            <div class="step-title">پایگاه‌داده</div>
        </div>
        <div class="step-item" id="st-3">
            <div class="step-num">۳</div>
            <div class="step-title">حساب مدیر</div>
        </div>
        <div class="step-item" id="st-4">
            <div class="step-num">۴</div>
            <div class="step-title">نصب نهایی</div>
        </div>
    </div>

    <!-- Step 1: Requirements & Permissions -->
    <div class="section-pane active" id="pane-1">
        <h3 style="font-size: 17px; font-weight: 800; margin: 0 0 14px;">بررسی پیش‌نیازهای سرور و دسترسی فایل‌ها</h3>
        
        <table style="margin-bottom: 16px;">
            <thead>
                <tr>
                    <th>پیش‌نیاز</th>
                    <th>حداقل نسخه</th>
                    <th>وضعیت سرور</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($reqs as $name => $r): ?>
                    <tr>
                        <td><b><?= $name ?></b></td>
                        <td class="muted"><?= $r['req'] ?></td>
                        <td>
                            <span class="badge <?= $r['status'] ? 'ok' : 'fail' ?>">
                                <?= $r['current'] ?> <?= $r['status'] ? '✓' : '✗' ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4 style="font-size: 15px; font-weight: 700; margin: 16px 0 10px;">مجوز نوشتن پوشه‌ها (Permissions):</h4>
        <table>
            <thead>
                <tr>
                    <th>پوشه سیستم</th>
                    <th>وضعیت دسترسی</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($permissionResults as $p): ?>
                    <tr>
                        <td><?= $p['name'] ?> (<code><?= basename($p['path']) ?></code>)</td>
                        <td>
                            <span class="badge <?= $p['writable'] ? 'ok' : 'fail' ?>">
                                <?= $p['writable'] ? 'قابل نوشتن (Writable) ✓' : 'غیرقابل نوشتن (Permission Denied) ✗' ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if(!$canProceed): ?>
            <div class="alert alert-error">
                برخی پیش‌نیازها یا دسترسی‌های بالا تایید نشدند. لطفاً در سی‌پنل نسخه PHP را روی 8.2 یا بالاتر قرار دهید و دسترسی پوشه‌های مشخص شده را 755 یا 775 تنظیم کنید.
            </div>
        <?php else: ?>
            <div class="alert alert-success">
                ✓ عالی است! سرور شما تمامی پیش‌نیازهای لاراول و فروشگاه را داراست.
            </div>
        <?php endif; ?>

        <div style="text-align: left; margin-top: 24px;">
            <button type="button" class="btn brand" onclick="goToStep(2)" <?= !$canProceed ? 'disabled style="opacity:.5;"' : '' ?>>
                مرحله بعد: تنظیمات پایگاه‌داده ›
            </button>
        </div>
    </div>

    <!-- Step 2: Database Configuration -->
    <div class="section-pane" id="pane-2">
        <h3 style="font-size: 17px; font-weight: 800; margin: 0 0 8px;">تنظیمات پایگاه‌داده (Database)</h3>
        <p class="muted" style="font-size: 13px; margin: 0 0 18px;">
            اطلاعات دیتابیسی که در بخش <b>MySQL Databases</b> سی‌پنل ساختید را در کادرهای زیر وارد نمایید:
        </p>

        <div class="form-group">
            <label>نوع پایگاه داده:</label>
            <select id="db_type" onchange="toggleDbType()">
                <option value="mysql" selected>MySQL / MariaDB (پیشنهادی سی‌پنل)</option>
                <option value="sqlite">SQLite (فایل لوکال بدون نیاز به ساخت در سی‌پنل)</option>
            </select>
        </div>

        <div id="mysql-fields">
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 12px;">
                <div class="form-group">
                    <label>آدرس هاست دیتابیس (DB Host):</label>
                    <input type="text" id="db_host" value="localhost" dir="ltr" placeholder="localhost">
                </div>
                <div class="form-group">
                    <label>پورت:</label>
                    <input type="text" id="db_port" value="3306" dir="ltr" placeholder="3306">
                </div>
            </div>

            <div class="form-group">
                <label>نام پایگاه داده (Database Name) در سی‌پنل * :</label>
                <input type="text" id="db_database" dir="ltr" placeholder="مثلاً: cpaneluser_atila">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div class="form-group">
                    <label>نام کاربری دیتابیس (DB User) * :</label>
                    <input type="text" id="db_username" dir="ltr" placeholder="مثلاً: cpaneluser_dbuser">
                </div>
                <div class="form-group">
                    <label>رمز عبور کاربر دیتابیس (DB Password):</label>
                    <input type="password" id="db_password" dir="ltr" placeholder="رمز عبور دیتابیس">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>آدرس اینترنتی وب‌سایت (App URL) * :</label>
            <input type="url" id="app_url" value="<?= htmlspecialchars($detectedUrl) ?>" dir="ltr" placeholder="https://yourdomain.com">
            <small class="muted" style="font-size: 11.5px;">در صورت داشتن گواهینامه SSL، با https وارد فرمایید.</small>
        </div>

        <div id="db-test-alert" style="display: none;" class="alert"></div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 24px;">
            <button type="button" class="btn o" onclick="goToStep(1)">‹ بازگشت</button>
            <div style="display: flex; gap: 10px;">
                <button type="button" class="btn o" onclick="testDbConnection()">🔌 تست اتصال به دیتابیس</button>
                <button type="button" class="btn brand" onclick="validateStep2()">مرحله بعد: حساب مدیر ›</button>
            </div>
        </div>
    </div>

    <!-- Step 3: Admin User Credentials -->
    <div class="section-pane" id="pane-3">
        <h3 style="font-size: 17px; font-weight: 800; margin: 0 0 8px;">اطلاعات حساب مدیر کل سایت (Admin)</h3>
        <p class="muted" style="font-size: 13px; margin: 0 0 18px;">
            این اطلاعات جهت ورود به پنل مدیریت ادمین (در آدرس <code>/admin</code>) استفاده خواهد شد:
        </p>

        <div class="form-group">
            <label>نام و نام خانوادگی مدیر:</label>
            <input type="text" id="admin_name" value="مدیر فروشگاه آتیلا" placeholder="مدیر فروشگاه">
        </div>

        <div class="form-group">
            <label>ایمیل ورود ادمین (Admin Email) * :</label>
            <input type="email" id="admin_email" value="admin@atilashop.ir" dir="ltr" placeholder="admin@yourdomain.com">
        </div>

        <div class="form-group">
            <label>رمز عبور ورود ادمین (Password) * :</label>
            <input type="text" id="admin_password" value="admin123456" dir="ltr" placeholder="حداقل ۶ کاراکتر">
            <small class="muted" style="font-size: 11.5px;">رمز را ذخیره داشته باشید؛ بعداً از داخل پنل قابل تغییر است.</small>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 24px;">
            <button type="button" class="btn o" onclick="goToStep(2)">‹ بازگشت</button>
            <button type="button" class="btn brand" onclick="startInstallation()">
                🚀 شروع نصب خودکار و راه‌اندازی
            </button>
        </div>
    </div>

    <!-- Step 4: Installation Progress & Finish -->
    <div class="section-pane" id="pane-4">
        <h3 style="font-size: 17px; font-weight: 800; margin: 0 0 8px;" id="install-heading">در حال راه‌اندازی و نصب پایگاه‌داده...</h3>
        <p class="muted" style="font-size: 13px; margin: 0 0 14px;" id="install-sub">
            لطفاً این پنجره را نبندید؛ مایگریشن‌ها، ثبت کاتالوگ و پیکربندی در حال انجام است:
        </p>

        <div class="progress-box" id="progress-box">
            <div class="progress-line">⏳ در حال آماده‌سازی و اتصال به سرور...</div>
        </div>

        <div id="finish-actions" style="display: none; margin-top: 24px;">
            <div class="alert alert-success">
                🎉 <b>تبریک! نصب با موفقیت به پایان رسید.</b> فروشگاه و پنل مدیریت آماده بهره‌برداری است.
            </div>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="/" target="_blank" class="btn success" style="flex: 1;">
                    🛍️ مشاهده فروشگاه آتیلاشاپ
                </a>
                <a href="/admin" target="_blank" class="btn brand" style="flex: 1;">
                    🔐 ورود به پنل مدیریت ادمین
                </a>
            </div>
            <div style="margin-top: 16px; font-size: 12.5px; color: var(--muted); text-align: center;">
                جهت امنیت هاست، فایل قفل نصب <code>storage/installed</code> فعال گردید.
            </div>
        </div>
    </div>
</div>

<script>
    function goToStep(step) {
        document.querySelectorAll('.section-pane').forEach(p => p.classList.remove('active'));
        document.querySelectorAll('.step-item').forEach((item, idx) => {
            item.classList.remove('active');
            if (idx + 1 < step) item.classList.add('done');
            else item.classList.remove('done');
            if (idx + 1 === step) item.classList.add('active');
        });
        document.getElementById('pane-' + step).classList.add('active');
    }

    function toggleDbType() {
        const type = document.getElementById('db_type').value;
        document.getElementById('mysql-fields').style.display = type === 'sqlite' ? 'none' : 'block';
    }

    async function testDbConnection() {
        const alertBox = document.getElementById('db-test-alert');
        alertBox.style.display = 'block';
        alertBox.className = 'alert alert-info';
        alertBox.innerHTML = '⏳ در حال تست ارتباط با دیتابیس...';

        const formData = new FormData();
        formData.append('db_type', document.getElementById('db_type').value);
        formData.append('db_host', document.getElementById('db_host').value);
        formData.append('db_port', document.getElementById('db_port').value);
        formData.append('db_database', document.getElementById('db_database').value);
        formData.append('db_username', document.getElementById('db_username').value);
        formData.append('db_password', document.getElementById('db_password').value);

        try {
            const res = await fetch('install.php?action=test_db', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();
            alertBox.className = 'alert ' + (data.success ? 'alert-success' : 'alert-error');
            alertBox.innerHTML = data.message;
            return data.success;
        } catch (err) {
            alertBox.className = 'alert alert-error';
            alertBox.innerHTML = 'خطا در برقراری ارتباط با اسکریپت نصب: ' + err.message;
            return false;
        }
    }

    async function validateStep2() {
        const dbType = document.getElementById('db_type').value;
        if (dbType === 'mysql') {
            const dbName = document.getElementById('db_database').value.trim();
            const dbUser = document.getElementById('db_username').value.trim();
            if (!dbName || !dbUser) {
                alert('لطفاً نام دیتابیس و کاربر را وارد کنید.');
                return;
            }
            const ok = await testDbConnection();
            if (!ok) return;
        }
        goToStep(3);
    }

    async function startInstallation() {
        const email = document.getElementById('admin_email').value.trim();
        const pass = document.getElementById('admin_password').value.trim();
        if (!email || !pass) {
            alert('لطفاً ایمیل و رمز عبور ادمین را وارد نمایید.');
            return;
        }

        goToStep(4);
        const logBox = document.getElementById('progress-box');
        const appendLog = (msg, isOk = true) => {
            const el = document.createElement('div');
            el.className = 'progress-line';
            el.innerHTML = (isOk ? '✓ ' : '✗ ') + msg;
            logBox.appendChild(el);
            logBox.scrollTop = logBox.scrollHeight;
        };

        const formData = new FormData();
        formData.append('db_type', document.getElementById('db_type').value);
        formData.append('db_host', document.getElementById('db_host').value);
        formData.append('db_port', document.getElementById('db_port').value);
        formData.append('db_database', document.getElementById('db_database').value);
        formData.append('db_username', document.getElementById('db_username').value);
        formData.append('db_password', document.getElementById('db_password').value);
        formData.append('app_url', document.getElementById('app_url').value);
        formData.append('admin_name', document.getElementById('admin_name').value);
        formData.append('admin_email', email);
        formData.append('admin_password', pass);

        appendLog('ارسال درخواست به کنترلر نصب و ایجاد فایل .env...');

        try {
            const res = await fetch('install.php?action=run_install', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();

            if (data.steps && Array.isArray(data.steps)) {
                data.steps.forEach(s => appendLog(s, true));
            }

            if (data.success) {
                document.getElementById('install-heading').innerHTML = '✅ نصب با موفقیت کامل انجام شد!';
                document.getElementById('install-sub').innerHTML = 'سایت و پایگاه‌داده با موفقیت راه‌اندازی شدند.';
                document.getElementById('finish-actions').style.display = 'block';
                document.getElementById('st-4').classList.add('done');
            } else {
                appendLog(data.message, false);
                alert('خطا در مراحل نصب: ' + data.message);
            }
        } catch (err) {
            appendLog('خطای سیستمی یا تایم‌اوت: ' + err.message, false);
        }
    }
</script>

</body>
</html>
