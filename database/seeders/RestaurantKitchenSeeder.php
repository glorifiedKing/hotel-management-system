<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Models\Kitchen;
use App\Models\RestaurantTable;
use App\Models\Service;

class RestaurantKitchenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Main Kitchen
        $mainKitchen = Kitchen::create([
            'name' => 'Main Kitchen',
            'type' => 'main',
            'description' => 'Primary hotel kitchen serving all restaurants',
            'location' => 'Ground Floor, Building A',
            'floor' => 0,
            'is_active' => true,
            'max_concurrent_orders' => 15,
            'specialties' => json_encode(['international', 'fine_dining', 'grills']),
        ]);

        // Create Bar Kitchen
        $barKitchen = Kitchen::create([
            'name' => 'Bar Kitchen',
            'type' => 'bar',
            'description' => 'Bar and lounge kitchen for beverages and light snacks',
            'location' => 'Ground Floor, Building A',
            'floor' => 0,
            'is_active' => true,
            'max_concurrent_orders' => 8,
            'specialties' => json_encode(['cocktails', 'appetizers', 'bar_food']),
        ]);

        // Create Pastry Kitchen
        $pastryKitchen = Kitchen::create([
            'name' => 'Pastry Kitchen',
            'type' => 'pastry',
            'description' => 'Specialized pastry and dessert kitchen',
            'location' => 'Ground Floor, Building A',
            'floor' => 0,
            'is_active' => true,
            'max_concurrent_orders' => 10,
            'specialties' => json_encode(['desserts', 'pastries', 'bread', 'cakes']),
        ]);

        // Create Main Restaurant
        $mainRestaurant = Restaurant::create([
            'name' => 'The Grand Dining',
            'type' => 'restaurant',
            'description' => 'Elegant fine dining restaurant serving international cuisine',
            'location' => 'Ground Floor, Building A',
            'floor' => 0,
            'opening_time' => '07:00:00',
            'closing_time' => '23:00:00',
            'seating_capacity' => 80,
            'kitchen_id' => $mainKitchen->id,
            'is_active' => true,
            'accepts_reservations' => true,
            'operating_days' => json_encode(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']),
        ]);

        // Create Rooftop Bar & Lounge
        $rooftopBar = Restaurant::create([
            'name' => 'Skyline Lounge',
            'type' => 'lounge',
            'description' => 'Rooftop bar with panoramic city views',
            'location' => 'Rooftop, Building A',
            'floor' => 10,
            'opening_time' => '17:00:00',
            'closing_time' => '02:00:00',
            'seating_capacity' => 50,
            'kitchen_id' => $barKitchen->id,
            'is_active' => true,
            'accepts_reservations' => true,
            'operating_days' => json_encode(['thursday', 'friday', 'saturday', 'sunday']),
        ]);

        // Create Cafe
        $cafe = Restaurant::create([
            'name' => 'Morning Brew Café',
            'type' => 'cafe',
            'description' => 'Cozy café serving coffee, pastries, and light meals',
            'location' => 'Lobby, Building A',
            'floor' => 0,
            'opening_time' => '06:00:00',
            'closing_time' => '20:00:00',
            'seating_capacity' => 30,
            'kitchen_id' => $pastryKitchen->id,
            'is_active' => true,
            'accepts_reservations' => false,
            'operating_days' => json_encode(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']),
        ]);

        // Update kitchens with restaurant associations
        $mainKitchen->update(['restaurant_id' => $mainRestaurant->id]);
        $barKitchen->update(['restaurant_id' => $rooftopBar->id]);
        $pastryKitchen->update(['restaurant_id' => $cafe->id]);

        // Create Tables for Main Restaurant
        $sections = ['A', 'B', 'C'];
        $tableNumber = 1;

        foreach ($sections as $section) {
            for ($i = 1; $i <= 10; $i++) {
                RestaurantTable::create([
                    'restaurant_id' => $mainRestaurant->id,
                    'table_number' => $mainRestaurant->name . '-' . $tableNumber++,
                    'location' => "Section $section",
                    'capacity' => rand(2, 6),
                    'status' => 'available',
                    'section' => $section,
                    'floor' => 0,
                    'is_active' => true,
                ]);
            }
        }

        // Create Tables for Rooftop Bar
        $tableNumber = 1;
        for ($i = 1; $i <= 15; $i++) {
            RestaurantTable::create([
                'restaurant_id' => $rooftopBar->id,
                'table_number' => $rooftopBar->name . '-' . $tableNumber++,
                'location' => $i <= 8 ? 'Indoor' : 'Terrace',
                'capacity' => rand(2, 4),
                'status' => 'available',
                'section' => $i <= 8 ? 'Indoor' : 'Outdoor',
                'floor' => 10,
                'is_active' => true,
            ]);
        }

        // Create Tables for Café
        $tableNumber = 1;
        for ($i = 1; $i <= 12; $i++) {
            RestaurantTable::create([
                'restaurant_id' => $cafe->id,
                'table_number' => $cafe->name . '-' . $tableNumber++,
                'location' => $i <= 6 ? 'Window Side' : 'Center',
                'capacity' => rand(2, 4),
                'status' => 'available',
                'section' => $i <= 6 ? 'Window' : 'Center',
                'floor' => 0,
                'is_active' => true,
            ]);
        }

        // Create Menu Services for Main Restaurant
        $mainMenuItems = [
            ['name' => 'Caesar Salad', 'category' => 'food', 'price' => 15.99, 'description' => 'Fresh romaine lettuce with Caesar dressing'],
            ['name' => 'Grilled Salmon', 'category' => 'food', 'price' => 32.99, 'description' => 'Atlantic salmon with herbs and lemon'],
            ['name' => 'Beef Tenderloin', 'category' => 'food', 'price' => 45.99, 'description' => 'Premium beef tenderloin with red wine sauce'],
            ['name' => 'Pasta Carbonara', 'category' => 'food', 'price' => 22.99, 'description' => 'Classic Italian pasta with bacon and cream'],
            ['name' => 'Lobster Bisque', 'category' => 'food', 'price' => 18.99, 'description' => 'Creamy lobster soup'],
            ['name' => 'Margherita Pizza', 'category' => 'food', 'price' => 19.99, 'description' => 'Traditional Italian pizza'],
            ['name' => 'Tiramisu', 'category' => 'food', 'price' => 12.99, 'description' => 'Classic Italian dessert'],
            ['name' => 'Red Wine (Glass)', 'category' => 'beverage', 'price' => 12.00, 'description' => 'House red wine'],
            ['name' => 'Sparkling Water', 'category' => 'beverage', 'price' => 5.00, 'description' => 'Premium sparkling water'],
        ];

        foreach ($mainMenuItems as $item) {
            Service::create([
                'restaurant_id' => $mainRestaurant->id,
                'name' => $item['name'],
                'category' => $item['category'],
                'price' => $item['price'],
                'description' => $item['description'],
                'is_available' => true,
            ]);
        }

        // Create Menu Services for Bar
        $barMenuItems = [
            ['name' => 'Mojito', 'category' => 'beverage', 'price' => 14.99, 'description' => 'Classic rum cocktail'],
            ['name' => 'Cosmopolitan', 'category' => 'beverage', 'price' => 15.99, 'description' => 'Vodka-based cocktail'],
            ['name' => 'Old Fashioned', 'category' => 'beverage', 'price' => 16.99, 'description' => 'Whiskey cocktail'],
            ['name' => 'Nachos Grande', 'category' => 'food', 'price' => 12.99, 'description' => 'Loaded tortilla chips'],
            ['name' => 'Chicken Wings', 'category' => 'food', 'price' => 14.99, 'description' => 'Spicy buffalo wings'],
            ['name' => 'Craft Beer', 'category' => 'beverage', 'price' => 8.99, 'description' => 'Local craft beer on tap'],
        ];

        foreach ($barMenuItems as $item) {
            Service::create([
                'restaurant_id' => $rooftopBar->id,
                'name' => $item['name'],
                'category' => $item['category'],
                'price' => $item['price'],
                'description' => $item['description'],
                'is_available' => true,
            ]);
        }

        // Create Menu Services for Café
        $cafeMenuItems = [
            ['name' => 'Espresso', 'category' => 'beverage', 'price' => 4.99, 'description' => 'Strong Italian coffee'],
            ['name' => 'Cappuccino', 'category' => 'beverage', 'price' => 5.99, 'description' => 'Coffee with steamed milk'],
            ['name' => 'Latte', 'category' => 'beverage', 'price' => 5.99, 'description' => 'Espresso with steamed milk'],
            ['name' => 'Croissant', 'category' => 'food', 'price' => 4.50, 'description' => 'Buttery French pastry'],
            ['name' => 'Blueberry Muffin', 'category' => 'food', 'price' => 5.50, 'description' => 'Fresh baked muffin'],
            ['name' => 'Avocado Toast', 'category' => 'food', 'price' => 12.99, 'description' => 'Sourdough with smashed avocado'],
            ['name' => 'Breakfast Sandwich', 'category' => 'food', 'price' => 9.99, 'description' => 'Egg, cheese, and bacon'],
            ['name' => 'Fresh Orange Juice', 'category' => 'beverage', 'price' => 6.99, 'description' => 'Freshly squeezed'],
        ];

        foreach ($cafeMenuItems as $item) {
            Service::create([
                'restaurant_id' => $cafe->id,
                'name' => $item['name'],
                'category' => $item['category'],
                'price' => $item['price'],
                'description' => $item['description'],
                'is_available' => true,
            ]);
        }

        $this->command->info('✅ Created 3 kitchens');
        $this->command->info('✅ Created 3 restaurants');
        $this->command->info('✅ Created 57 restaurant tables');
        $this->command->info('✅ Created 23 menu items');
    }
}
