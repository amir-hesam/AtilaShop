<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Wishlist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. ایجاد کاربر مدیر
        $admin = User::firstOrCreate(
            ['email' => 'admin@atilashop.ir'],
            [
                'name' => 'مدیر فروشگاه آتیلا',
                'password' => Hash::make('admin123456'),
                'is_admin' => true,
            ]
        );

        // 2. ایجاد کاربر مشتری نمونه
        $customer = User::firstOrCreate(
            ['email' => 'sara@example.com'],
            [
                'name' => 'سارا راد',
                'password' => Hash::make('123456'),
                'is_admin' => false,
            ]
        );

        // غیرفعال‌سازی موقت قیدهای کلید خارجی و پاکسازی جداول وابسته (سازگار با MySQL/MariaDB)
        Schema::disableForeignKeyConstraints();
        Wishlist::query()->delete();
        OrderItem::query()->delete();
        Order::query()->delete();
        Product::query()->delete();
        Schema::enableForeignKeyConstraints();

        $braSizes = ['75B', '80B', '85B', '90B'];
        $pantySizes = ['M', 'L', 'XL', '2XL'];
        $menSizes = ['M', 'L', 'XL', '2XL', '3XL'];

        $productsData = [
            [
                'name' => 'ست شورت و سوتین دانتل مجلسی رویال',
                'slug' => 'set-lingerie-royal-lace',
                'category' => 'ست لباس زیر',
                'gender' => 'w',
                'price' => 790000,
                'original_price' => 950000,
                'stock' => 12,
                'sizes' => $braSizes,
                'icon' => 'set',
                'hues' => [345, 20, 260],
                'tag' => 'پرفروش',
                'description' => 'ست شورت و سوتین فوق‌العاده لطیف با پارچه دانتل ترک درجه یک، سوتین فنردار فرم‌دهنده با ایستایی عالی و شورت فانتزی ضد حساسیت با آستر نخ‌پنبه طبیعی.',
                'image' => 'products/set_lingerie.jpg',
            ],
            [
                'name' => 'سوتین اسفنجی فنردار گیپور شیک',
                'slug' => 'bra-padded-underwire-lace',
                'category' => 'سوتین',
                'gender' => 'w',
                'price' => 490000,
                'original_price' => 580000,
                'stock' => 18,
                'sizes' => ['75', '80', '85', '90'],
                'icon' => 'bra',
                'hues' => [350, 30, 200],
                'tag' => 'جدید',
                'description' => 'سوتین اسفنجی نازک کاپ B و C با لایه ضد تعریق، بندهای قابل تنظیم محکم و فنر سبک طبی بدون ایجاد فشار روی قفسه سینه.',
                'image' => 'products/bra_lace.jpg',
            ],
            [
                'name' => 'سوتین نخی روزمره بدون فنر (آنتی‌باکتریال)',
                'slug' => 'bra-cotton-daily-seamless',
                'category' => 'سوتین',
                'gender' => 'w',
                'price' => 320000,
                'original_price' => null,
                'stock' => 4, // کمتر از ۶ عدد جهت تست هشدار
                'sizes' => ['75', '80', '85', '90'],
                'icon' => 'bra',
                'hues' => [25, 200, 330],
                'tag' => 'پرفروش',
                'description' => 'سوتین تمام نخ پنبه ارگانیک بسیار خنک، بدون فنر و بدون اسفنج مناسب استفاده طولانی‌مدت در محل کار و منزل با خاصیت ضد حساسیت پوستی.',
                'image' => 'products/bra_black.jpg',
            ],
            [
                'name' => 'شورت نخی ارگانیک زنانه (پک ۳ عددی)',
                'slug' => 'panty-cotton-organic-pack3',
                'category' => 'شورت زنانه',
                'gender' => 'w',
                'price' => 280000,
                'original_price' => 350000,
                'stock' => 25,
                'sizes' => $pantySizes,
                'icon' => 'panty',
                'hues' => [340, 40, 210],
                'tag' => 'پرفروش',
                'description' => 'پک سه عددی شورت اسلیپ زنانه دوخته‌شده از الیاف نخ‌پنبه طبیعی با کشسانی استاندارد و فاق دولایه ضدقارچ و ضد رطوبت.',
                'image' => 'products/panty_pink.jpg',
            ],
            [
                'name' => 'شورت بدون درز لیزری (نامرئی مجلسی)',
                'slug' => 'panty-seamless-laser-cut',
                'category' => 'شورت زنانه',
                'gender' => 'w',
                'price' => 140000,
                'original_price' => null,
                'stock' => 30,
                'sizes' => ['M', 'L', 'XL'],
                'icon' => 'panty',
                'hues' => [35, 330, 260],
                'tag' => 'جدید',
                'description' => 'شورت لیزری کاملاً بدون خط دوخت، ایده‌آل برای پوشیدن زیر لباس‌های چسبان مجلسی و شلوار بدون ایجاد هرگونه رد و خط.',
                'image' => 'products/panty_seamless.jpg',
            ],
            [
                'name' => 'شورت توری فانتزی دانتل شیک',
                'slug' => 'panty-lace-fancy-floral',
                'category' => 'شورت زنانه',
                'gender' => 'w',
                'price' => 160000,
                'original_price' => 190000,
                'stock' => 15,
                'sizes' => ['M', 'L', 'XL'],
                'icon' => 'panty',
                'hues' => [350, 280, 20],
                'tag' => null,
                'description' => 'شورت فانتزی توری با طرح گل‌های برجسته، لبه‌های نرم ضدخارش و فاق تمام نخ ضدحساسیت.',
                'image' => 'products/panty_lace.jpg',
            ],
            [
                'name' => 'ست شورت و سوتین توری قرمز یاقوتی',
                'slug' => 'set-lingerie-ruby-red',
                'category' => 'ست لباس زیر',
                'gender' => 'w',
                'price' => 840000,
                'original_price' => 990000,
                'stock' => 8,
                'sizes' => $braSizes,
                'icon' => 'set',
                'hues' => [355, 330, 20],
                'tag' => 'جدید',
                'description' => 'ست خاص و جذاب قرمز با دانتل ظریف ایتالیایی، هارنس شیک سینه و کاپ استاندارد خوش‌فرم.',
                'image' => 'products/set_red.jpg',
            ],
            [
                'name' => 'بادی توری دانتل یقه هفت مجلسی',
                'slug' => 'bodysuit-lace-black-vneck',
                'category' => 'بادی',
                'gender' => 'w',
                'price' => 680000,
                'original_price' => null,
                'stock' => 5, // کمتر از ۶ عدد جهت تست هشدار
                'sizes' => ['S/M', 'L/XL'],
                'icon' => 'bodysuit',
                'hues' => [345, 270, 20],
                'tag' => 'پرفروش',
                'description' => 'بادی توری شیک با قزن بازشو پایین، قابل پوشیدن زیر کت و مانتو یا استفاده مجلسی با فرم‌دهی زیبای بالاتنه.',
                'image' => 'products/bodysuit.jpg',
            ],
            [
                'name' => 'نیم‌تنه کاپ‌دار اسپرت و راحتی زنانه',
                'slug' => 'sports-bra-crop-top',
                'category' => 'سوتین',
                'gender' => 'w',
                'price' => 390000,
                'original_price' => null,
                'stock' => 20,
                'sizes' => ['فری (۳۶ تا ۴۲)'],
                'icon' => 'bra',
                'hues' => [200, 340, 40],
                'tag' => 'جدید',
                'description' => 'نیم‌تنه با پد متحرک و پارچه کشسان تنفس‌پذیر، مناسب ورزش، پیاده‌روی و راحتی روزمره با کش پهن زیرسینه.',
                'image' => 'products/bra_sport.jpg',
            ],
            [
                'name' => 'شورت پادار پنبه‌ای مردانه (پک ۲ عددی)',
                'slug' => 'mens-boxer-briefs-cotton-pack2',
                'category' => 'لباس زیر مردانه',
                'gender' => 'm',
                'price' => 340000,
                'original_price' => 420000,
                'stock' => 22,
                'sizes' => $menSizes,
                'icon' => 'boxer',
                'hues' => [210, 160, 30],
                'tag' => 'پرفروش',
                'description' => 'شورت باکسر پادار ۱۰۰٪ پنبه سوپر، با کش کمر نرم بدون جا انداختن و الیاف ضد تعریق مناسب استفاده طولانی‌مدت.',
                'image' => 'products/boxer_men.jpg',
            ],
            [
                'name' => 'شورت اسلیپ نخی مودال مردانه',
                'slug' => 'mens-briefs-modal-soft',
                'category' => 'لباس زیر مردانه',
                'gender' => 'm',
                'price' => 180000,
                'original_price' => null,
                'stock' => 16,
                'sizes' => ['L', 'XL', '2XL'],
                'icon' => 'boxer',
                'hues' => [220, 40, 260],
                'tag' => null,
                'description' => 'شورت اسلیپ دوخته‌شده از الیاف گیاهی مودال بسیار نرم، ضد بو و ضد حساسیت با دوخت ارگونومیک.',
                'image' => 'products/briefs_men.jpg',
            ],
        ];

        $createdProducts = [];
        foreach ($productsData as $data) {
            $createdProducts[] = Product::create($data);
        }

        // سفارش نمونه کارت‌به‌کارت با فیش ثبت‌شده
        $order1 = Order::create([
            'order_number' => 'AT-1001',
            'user_id' => $customer->id,
            'receiver_name' => 'سارا راد',
            'phone' => '09123456789',
            'address' => 'تهران، زعفرانیه، خیابان آصف، کوچه بهار، پلاک ۴، واحد ۲',
            'total_amount' => 790000,
            'payment_method' => 'card_transfer',
            'status' => 'در انتظار تأیید پرداخت',
            'tracking_code' => 'TRX-849201',
            'notes' => 'لطفاً مرسوله در کارتن کاملاً مات و پوشیده بسته‌بندی شود.',
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $createdProducts[0]->id,
            'product_name' => $createdProducts[0]->name,
            'size' => '80B',
            'color_index' => 0,
            'unit_price' => 790000,
            'quantity' => 1,
            'total_price' => 790000,
        ]);
    }
}
