<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Faker\Factory as Faker;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $categories = [
            'Electronics' => [
                'description' => 'Cutting-edge gadgets and devices for work and entertainment.',
                'products' => [
                    'Smartphones' => 'Latest model with high-resolution display, powerful processor, and advanced camera system.',
                    'Laptops' => 'Lightweight and powerful laptop with long battery life, perfect for work and entertainment.',
                    'Tablets' => 'Versatile tablet with a large touchscreen, ideal for reading, browsing, and light productivity.',
                    'Smartwatches' => 'Feature-packed smartwatch with fitness tracking, notifications, and customizable watch faces.',
                    'Headphones' => 'Noise-cancelling wireless headphones with premium sound quality and comfortable design.',
                ],
            ],
            'Clothing' => [
                'description' => 'Stylish and comfortable apparel for all occasions.',
                'products' => [
                    'T-shirts' => 'Soft, breathable cotton t-shirts in various colors and sizes for everyday wear.',
                    'Jeans' => 'Classic denim jeans with a comfortable fit and durable construction.',
                    'Dresses' => 'Stylish dresses for various occasions, from casual to formal wear.',
                    'Jackets' => 'Weather-resistant jackets to keep you warm and dry in any condition.',
                    'Shoes' => 'Comfortable and fashionable shoes for all-day wear and various activities.',
                ],
            ],
            'Home & Garden' => [
                'description' => 'Everything you need to make your living space beautiful and functional.',
                'products' => [
                    'Furniture' => 'Modern and functional furniture pieces to enhance your living space.',
                    'Kitchenware' => 'High-quality kitchen tools and appliances for cooking enthusiasts.',
                    'Bedding' => 'Soft and cozy bedding sets for a comfortable night\'s sleep.',
                    'Gardening Tools' => 'Durable gardening tools to help maintain and beautify your outdoor space.',
                    'Home Decor' => 'Stylish decorative items to add personality to your home.',
                ],
            ],
            'Books' => [
                'description' => 'A wide selection of books to inform, entertain, and inspire.',
                'products' => [
                    'Fiction' => 'Engaging novels across various genres, from mystery to romance and science fiction.',
                    'Non-fiction' => 'Informative books on history, science, and current events.',
                    'Biographies' => 'Inspiring life stories of notable figures from various fields.',
                    'Cookbooks' => 'Recipe collections and cooking guides for all skill levels and cuisines.',
                    'Self-help' => 'Books focused on personal growth, motivation, and life improvement.',
                ],
            ],
            'Sports & Outdoors' => [
                'description' => 'Equipment and gear for sports enthusiasts and outdoor adventurers.',
                'products' => [
                    'Fitness Equipment' => 'High-quality exercise gear for home workouts and strength training.',
                    'Camping Gear' => 'Essential equipment for comfortable and safe outdoor adventures.',
                    'Bicycles' => 'Durable and efficient bicycles for commuting, exercise, or leisure riding.',
                    'Sports Apparel' => 'Performance clothing for various sports and outdoor activities.',
                    'Outdoor Games' => 'Fun and engaging games for backyard entertainment and family gatherings.',
                ],
            ],
        ];

        foreach ($categories as $categoryName => $categoryData) {
            $category = Category::create([
                'name' => $categoryName,
                'description' => $categoryData['description'],
            ]);

            foreach ($categoryData['products'] as $productName => $productDescription) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => $productName,
                    'description' => $productDescription,
                    'price' => $faker->randomFloat(2, 10, 1000),
                    'stock' => $faker->numberBetween(0, 100),
                    'image_url' => $faker->imageUrl(640, 480, $productName, true),
                ]);
            }
        }
    }
}
