<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::create([ 'name'=>'Admin', 'email'=>'admin@komo.test', 'password'=>Hash::make('password'), 'role'=>'admin' ]);
        User::create([ 'name'=>'Customer', 'email'=>'user@komo.test', 'password'=>Hash::make('password') ]);
        \$c1 = Category::create(['name'=>'Elektronika','slug'=>'elektronika']);
        \$c2 = Category::create(['name'=>'Kiyim','slug'=>'kiyim']);
        \$p = Product::create(['name'=>'Test Telefon','slug'=>'test-telefon','price'=>1200000,'stock'=>10,'category_id'=>\$c1->id]);
        ProductImage::create(['product_id'=>\$p->id,'url'=>'/images/products/phone.jpg','alt'=>'Phone']);
    }
}
