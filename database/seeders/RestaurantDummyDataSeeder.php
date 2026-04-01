<?php

namespace Database\Seeders;

use App\Models\Addon;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemAddon;
use App\Models\Chef;
use App\Models\Product;
use App\Models\ProductAddon;
use App\Models\ProductIngredient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RestaurantDummyDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // Ensure a couple of known users exist (phone-based)
            $customer1 = User::updateOrCreate(
                ['phone' => '01711111111'],
                [
                    'name' => 'Customer One',
                    'email' => 'customer1@example.com',
                    'password' => Hash::make('password'),
                ]
            );

            $customer2 = User::updateOrCreate(
                ['phone' => '01722222222'],
                [
                    'name' => 'Customer Two',
                    'email' => 'customer2@example.com',
                    'password' => Hash::make('password'),
                ]
            );

            // Chefs
            $chefRows = [
                [
                    'name' => 'Julian Vane',
                    'designation' => 'Executive Chef',
                    'phone' => '01810000001',
                    'image_url' => 'https://images.unsplash.com/photo-1548940740-204726a19be3?auto=format&fit=crop&q=80&w=800',
                ],
                [
                    'name' => 'Amelia Hart',
                    'designation' => 'Sous Chef',
                    'phone' => '01810000002',
                    'image_url' => 'https://images.unsplash.com/photo-1548940740-204726a19be3?auto=format&fit=crop&q=80&w=800',
                ],
                [
                    'name' => 'Noah King',
                    'designation' => 'Pastry Chef',
                    'phone' => '01810000003',
                    'image_url' => 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&q=80&w=800',
                ],
            ];

            foreach ($chefRows as $row) {
                Chef::updateOrCreate(
                    ['phone' => $row['phone']],
                    [
                        'name' => $row['name'],
                        'designation' => $row['designation'],
                        'image_url' => $row['image_url'],
                        'password' => Hash::make('password'),
                    ]
                );
            }

            // Categories
            $categories = collect([
                'Starters',
                'Main Course',
                'Desserts',
                'Beverages',
            ])->map(function (string $name) {
                return Category::updateOrCreate(
                    ['slug' => Str::slug($name)],
                    [
                        'name' => $name,
                        'status' => 1,
                    ]
                );
            });

            // Ingredients
            $ingredients = collect([
                ['name' => 'Salt', 'unit' => 'g', 'stock_qty' => 5000],
                ['name' => 'Sugar', 'unit' => 'g', 'stock_qty' => 5000],
                ['name' => 'Butter', 'unit' => 'g', 'stock_qty' => 2000],
                ['name' => 'Flour', 'unit' => 'g', 'stock_qty' => 8000],
                ['name' => 'Chicken', 'unit' => 'g', 'stock_qty' => 6000],
                ['name' => 'Beef', 'unit' => 'g', 'stock_qty' => 4000],
                ['name' => 'Rice', 'unit' => 'g', 'stock_qty' => 10000],
                ['name' => 'Tomato', 'unit' => 'pcs', 'stock_qty' => 200],
                ['name' => 'Onion', 'unit' => 'pcs', 'stock_qty' => 200],
                ['name' => 'Garlic', 'unit' => 'clove', 'stock_qty' => 500],
            ])->map(function (array $row) {
                return Ingredient::updateOrCreate(
                    ['name' => $row['name']],
                    [
                        'unit' => $row['unit'],
                        'stock_qty' => $row['stock_qty'],
                    ]
                );
            });

            // Addons
            $addons = collect([
                ['name' => 'Extra Cheese', 'price' => 20],
                ['name' => 'Extra Sauce', 'price' => 10],
                ['name' => 'French Fries', 'price' => 60],
                ['name' => 'Coke', 'price' => 40],
                ['name' => 'Lemon', 'price' => 5],
            ])->map(function (array $row) {
                return Addon::updateOrCreate(
                    ['name' => $row['name']],
                    ['price' => $row['price']]
                );
            });

            // Products
            $products = collect([
                ['name' => 'Chicken Burger', 'category' => 'Main Course', 'price' => 220, 'is_available' => true],
                ['name' => 'Beef Burger', 'category' => 'Main Course', 'price' => 260, 'is_available' => true],
                ['name' => 'French Fries', 'category' => 'Starters', 'price' => 120, 'is_available' => true],
                ['name' => 'Chocolate Cake', 'category' => 'Desserts', 'price' => 180, 'is_available' => true],
                ['name' => 'Lemonade', 'category' => 'Beverages', 'price' => 90, 'is_available' => true],
            ])->map(function (array $row) use ($categories) {
                $category = $categories->firstWhere('name', $row['category']);

                return Product::updateOrCreate(
                    ['slug' => Str::slug($row['name'])],
                    [
                        'name' => $row['name'],
                        'description' => $row['name'] . ' - delicious restaurant item.',
                        'category_id' => $category?->id,
                        'price' => $row['price'],
                        'is_available' => (bool) $row['is_available'],
                        'image_url' => null,
                    ]
                );
            });

            // Product Ingredients (simple attach)
            foreach ($products as $product) {
                ProductIngredient::where('product_id', $product->id)->delete();

                $pick = $ingredients->shuffle()->take(3);
                foreach ($pick as $ing) {
                    ProductIngredient::create([
                        'product_id' => $product->id,
                        'ingredient_id' => $ing->id,
                        'qty' => 1,
                    ]);
                }
            }

            // Product Addons (simple attach)
            foreach ($products as $product) {
                ProductAddon::where('product_id', $product->id)->delete();

                $pick = $addons->shuffle()->take(3);
                foreach ($pick as $addon) {
                    ProductAddon::firstOrCreate([
                        'product_id' => $product->id,
                        'addon_id' => $addon->id,
                    ]);
                }
            }

            // Orders + items + item addons (snapshot pricing)
            foreach ([$customer1, $customer2] as $customer) {
                // Create 2 orders each time (idempotent by "soft_delete=false + phone + date" would be complex; just create new)
                for ($i = 0; $i < 2; $i++) {
                    $order = Order::create([
                        'user_id' => $customer->id,
                        'customer_name' => $customer->name,
                        'customer_phone' => $customer->phone ?? '01700000000',
                        'order_status' => 'pending',
                        'payment_status' => 'unpaid',
                        'total_amount' => 0,
                        'soft_delete' => false,
                    ]);

                    $grand = 0;
                    $pickedProducts = $products->shuffle()->take(2);

                    foreach ($pickedProducts as $product) {
                        $qty = rand(1, 3);

                        $item = OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'quantity' => $qty,
                            'price' => (float) $product->price,
                        ]);

                        $addonTotal = 0;
                        $pickedAddons = $addons->shuffle()->take(rand(0, 2));
                        foreach ($pickedAddons as $addon) {
                            OrderItemAddon::create([
                                'order_item_id' => $item->id,
                                'addon_id' => $addon->id,
                                'price' => (float) $addon->price,
                            ]);
                            $addonTotal += (float) $addon->price;
                        }

                        // keep effective unit price
                        $item->update(['price' => (float) $product->price + $addonTotal]);

                        $grand += ((float) $item->price * $qty);
                    }

                    $order->update(['total_amount' => $grand]);
                }
            }
        });
    }
}

