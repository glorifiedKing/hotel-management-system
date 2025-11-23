<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    InventoryCategory,
    InventoryItem,
    Supplier,
    PurchaseOrder,
    PurchaseOrderItem,
    RestaurantTable,
    Service,
    User
};

class InventoryAndPOSSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        // If no user exists, create one
        if (!$user) {
            $user = User::create([
                'name' => 'Admin User',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Create Inventory Categories
        $categories = [
            ['name' => 'Fresh Produce', 'type' => 'food', 'description' => 'Fresh fruits and vegetables'],
            ['name' => 'Meat & Seafood', 'type' => 'food', 'description' => 'Fresh and frozen meats'],
            ['name' => 'Dairy Products', 'type' => 'food', 'description' => 'Milk, cheese, butter, etc.'],
            ['name' => 'Dry Goods', 'type' => 'food', 'description' => 'Rice, pasta, flour, etc.'],
            ['name' => 'Beverages', 'type' => 'beverage', 'description' => 'Soft drinks, juices, water'],
            ['name' => 'Alcoholic Beverages', 'type' => 'beverage', 'description' => 'Wine, beer, spirits'],
            ['name' => 'Kitchen Supplies', 'type' => 'supplies', 'description' => 'Cleaning and kitchen tools'],
        ];

        foreach ($categories as $cat) {
            InventoryCategory::create($cat);
        }

        // Create Inventory Items
        $inventoryItems = [
            // Fresh Produce
            ['category_id' => 1, 'name' => 'Tomatoes', 'sku' => 'PRD-001', 'unit_of_measurement' => 'kg', 'current_stock' => 50, 'minimum_stock' => 10, 'reorder_point' => 15, 'cost_per_unit' => 3.50, 'is_perishable' => true],
            ['category_id' => 1, 'name' => 'Lettuce', 'sku' => 'PRD-002', 'unit_of_measurement' => 'kg', 'current_stock' => 30, 'minimum_stock' => 5, 'reorder_point' => 10, 'cost_per_unit' => 2.75, 'is_perishable' => true],
            ['category_id' => 1, 'name' => 'Onions', 'sku' => 'PRD-003', 'unit_of_measurement' => 'kg', 'current_stock' => 40, 'minimum_stock' => 15, 'reorder_point' => 20, 'cost_per_unit' => 1.50, 'is_perishable' => false],

            // Meat & Seafood
            ['category_id' => 2, 'name' => 'Chicken Breast', 'sku' => 'MEAT-001', 'unit_of_measurement' => 'kg', 'current_stock' => 25, 'minimum_stock' => 10, 'reorder_point' => 15, 'cost_per_unit' => 8.50, 'is_perishable' => true],
            ['category_id' => 2, 'name' => 'Beef Tenderloin', 'sku' => 'MEAT-002', 'unit_of_measurement' => 'kg', 'current_stock' => 15, 'minimum_stock' => 5, 'reorder_point' => 8, 'cost_per_unit' => 25.00, 'is_perishable' => true],
            ['category_id' => 2, 'name' => 'Salmon Fillet', 'sku' => 'FISH-001', 'unit_of_measurement' => 'kg', 'current_stock' => 12, 'minimum_stock' => 5, 'reorder_point' => 7, 'cost_per_unit' => 18.50, 'is_perishable' => true],

            // Dairy
            ['category_id' => 3, 'name' => 'Fresh Milk', 'sku' => 'DAIRY-001', 'unit_of_measurement' => 'liters', 'current_stock' => 60, 'minimum_stock' => 20, 'reorder_point' => 30, 'cost_per_unit' => 1.25, 'is_perishable' => true],
            ['category_id' => 3, 'name' => 'Butter', 'sku' => 'DAIRY-002', 'unit_of_measurement' => 'kg', 'current_stock' => 20, 'minimum_stock' => 5, 'reorder_point' => 10, 'cost_per_unit' => 4.50, 'is_perishable' => true],
            ['category_id' => 3, 'name' => 'Cheese', 'sku' => 'DAIRY-003', 'unit_of_measurement' => 'kg', 'current_stock' => 15, 'minimum_stock' => 5, 'reorder_point' => 8, 'cost_per_unit' => 12.00, 'is_perishable' => true],

            // Dry Goods
            ['category_id' => 4, 'name' => 'Rice', 'sku' => 'DRY-001', 'unit_of_measurement' => 'kg', 'current_stock' => 100, 'minimum_stock' => 30, 'reorder_point' => 40, 'cost_per_unit' => 1.20, 'is_perishable' => false],
            ['category_id' => 4, 'name' => 'Pasta', 'sku' => 'DRY-002', 'unit_of_measurement' => 'kg', 'current_stock' => 50, 'minimum_stock' => 15, 'reorder_point' => 20, 'cost_per_unit' => 2.00, 'is_perishable' => false],
            ['category_id' => 4, 'name' => 'Flour', 'sku' => 'DRY-003', 'unit_of_measurement' => 'kg', 'current_stock' => 80, 'minimum_stock' => 25, 'reorder_point' => 35, 'cost_per_unit' => 0.85, 'is_perishable' => false],

            // Beverages
            ['category_id' => 5, 'name' => 'Coca Cola', 'sku' => 'BEV-001', 'unit_of_measurement' => 'bottles', 'current_stock' => 200, 'minimum_stock' => 50, 'reorder_point' => 75, 'cost_per_unit' => 0.75, 'is_perishable' => false],
            ['category_id' => 5, 'name' => 'Orange Juice', 'sku' => 'BEV-002', 'unit_of_measurement' => 'liters', 'current_stock' => 40, 'minimum_stock' => 10, 'reorder_point' => 20, 'cost_per_unit' => 3.50, 'is_perishable' => true],
            ['category_id' => 5, 'name' => 'Mineral Water', 'sku' => 'BEV-003', 'unit_of_measurement' => 'bottles', 'current_stock' => 300, 'minimum_stock' => 100, 'reorder_point' => 150, 'cost_per_unit' => 0.50, 'is_perishable' => false],

            // Alcoholic Beverages
            ['category_id' => 6, 'name' => 'Red Wine', 'sku' => 'ALC-001', 'unit_of_measurement' => 'bottles', 'current_stock' => 50, 'minimum_stock' => 15, 'reorder_point' => 20, 'cost_per_unit' => 12.00, 'is_perishable' => false],
            ['category_id' => 6, 'name' => 'Beer', 'sku' => 'ALC-002', 'unit_of_measurement' => 'bottles', 'current_stock' => 150, 'minimum_stock' => 40, 'reorder_point' => 60, 'cost_per_unit' => 2.50, 'is_perishable' => false],
            ['category_id' => 6, 'name' => 'Vodka', 'sku' => 'ALC-003', 'unit_of_measurement' => 'bottles', 'current_stock' => 30, 'minimum_stock' => 10, 'reorder_point' => 15, 'cost_per_unit' => 18.00, 'is_perishable' => false],
        ];

        foreach ($inventoryItems as $item) {
            InventoryItem::create($item);
        }

        // Create Suppliers
        $suppliers = [
            ['name' => 'Fresh Farm Suppliers', 'phone' => '+1234567890', 'email' => 'orders@freshfarm.com', 'supplier_type' => 'food', 'contact_person' => 'John Farmer'],
            ['name' => 'Premium Meats Co.', 'phone' => '+1234567891', 'email' => 'sales@premiummeats.com', 'supplier_type' => 'food', 'contact_person' => 'Mike Butcher'],
            ['name' => 'Dairy Delights', 'phone' => '+1234567892', 'email' => 'info@dairydelights.com', 'supplier_type' => 'food', 'contact_person' => 'Sarah Milk'],
            ['name' => 'Beverage Distributors Inc.', 'phone' => '+1234567893', 'email' => 'orders@bevdist.com', 'supplier_type' => 'beverage', 'contact_person' => 'Tom Drinks'],
            ['name' => 'Wine & Spirits Wholesale', 'phone' => '+1234567894', 'email' => 'sales@winespirits.com', 'supplier_type' => 'beverage', 'contact_person' => 'Lisa Sommelier'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        // Create a Sample Purchase Order
        $po = PurchaseOrder::create([
            'supplier_id' => 1,
            'order_date' => now(),
            'expected_delivery_date' => now()->addDays(3),
            'status' => 'pending',
            'subtotal' => 500.00,
            'tax_amount' => 50.00,
            'total_amount' => 550.00,
            'created_by' => $user->id,
        ]);

        // Add items to purchase order
        PurchaseOrderItem::create([
            'purchase_order_id' => $po->id,
            'inventory_item_id' => 1,
            'quantity' => 50,
            'unit_cost' => 3.50,
            'total_cost' => 175.00,
        ]);

        PurchaseOrderItem::create([
            'purchase_order_id' => $po->id,
            'inventory_item_id' => 2,
            'quantity' => 30,
            'unit_cost' => 2.75,
            'total_cost' => 82.50,
        ]);

        // Create Restaurant Tables
        $tables = [
            // Restaurant Tables
            ['table_number' => 'R1', 'location' => 'restaurant', 'capacity' => 2, 'status' => 'available', 'section' => 'Main Hall'],
            ['table_number' => 'R2', 'location' => 'restaurant', 'capacity' => 4, 'status' => 'available', 'section' => 'Main Hall'],
            ['table_number' => 'R3', 'location' => 'restaurant', 'capacity' => 4, 'status' => 'available', 'section' => 'Main Hall'],
            ['table_number' => 'R4', 'location' => 'restaurant', 'capacity' => 6, 'status' => 'available', 'section' => 'Main Hall'],
            ['table_number' => 'R5', 'location' => 'restaurant', 'capacity' => 2, 'status' => 'available', 'section' => 'Window Side'],
            ['table_number' => 'R6', 'location' => 'restaurant', 'capacity' => 2, 'status' => 'available', 'section' => 'Window Side'],
            ['table_number' => 'R7', 'location' => 'restaurant', 'capacity' => 8, 'status' => 'available', 'section' => 'Private'],
            ['table_number' => 'R8', 'location' => 'restaurant', 'capacity' => 10, 'status' => 'available', 'section' => 'Private'],

            // Bar Tables
            ['table_number' => 'B1', 'location' => 'bar', 'capacity' => 2, 'status' => 'available', 'section' => 'Bar Counter'],
            ['table_number' => 'B2', 'location' => 'bar', 'capacity' => 2, 'status' => 'available', 'section' => 'Bar Counter'],
            ['table_number' => 'B3', 'location' => 'bar', 'capacity' => 4, 'status' => 'available', 'section' => 'Lounge'],
            ['table_number' => 'B4', 'location' => 'bar', 'capacity' => 4, 'status' => 'available', 'section' => 'Lounge'],
            ['table_number' => 'B5', 'location' => 'bar', 'capacity' => 6, 'status' => 'available', 'section' => 'Lounge'],

            // Outdoor Tables
            ['table_number' => 'O1', 'location' => 'outdoor', 'capacity' => 4, 'status' => 'available', 'section' => 'Patio'],
            ['table_number' => 'O2', 'location' => 'outdoor', 'capacity' => 4, 'status' => 'available', 'section' => 'Patio'],
            ['table_number' => 'O3', 'location' => 'outdoor', 'capacity' => 6, 'status' => 'available', 'section' => 'Garden'],

            // VIP Tables
            ['table_number' => 'V1', 'location' => 'vip', 'capacity' => 4, 'status' => 'available', 'section' => 'VIP Room'],
            ['table_number' => 'V2', 'location' => 'vip', 'capacity' => 8, 'status' => 'available', 'section' => 'VIP Room'],
        ];

        foreach ($tables as $table) {
            RestaurantTable::create($table);
        }

        // Update existing services with inventory tracking and preparation time
        Service::where('name', 'Room Service Breakfast')->update([
            'track_inventory' => true,
            'preparation_time' => 15,
        ]);

        Service::where('name', 'Dinner Entree')->update([
            'track_inventory' => true,
            'preparation_time' => 25,
        ]);

        // Create additional menu items for restaurant
        $menuItems = [
            // Food
            ['name' => 'Caesar Salad', 'category' => 'food', 'price' => 12.00, 'track_inventory' => true, 'preparation_time' => 10],
            ['name' => 'Grilled Chicken', 'category' => 'food', 'price' => 22.00, 'track_inventory' => true, 'preparation_time' => 20],
            ['name' => 'Beef Steak', 'category' => 'food', 'price' => 35.00, 'track_inventory' => true, 'preparation_time' => 25],
            ['name' => 'Salmon Teriyaki', 'category' => 'food', 'price' => 28.00, 'track_inventory' => true, 'preparation_time' => 20],
            ['name' => 'Pasta Carbonara', 'category' => 'food', 'price' => 18.00, 'track_inventory' => true, 'preparation_time' => 15],
            ['name' => 'Margherita Pizza', 'category' => 'food', 'price' => 16.00, 'track_inventory' => true, 'preparation_time' => 18],
            ['name' => 'French Fries', 'category' => 'food', 'price' => 6.00, 'track_inventory' => true, 'preparation_time' => 8],
            ['name' => 'Chocolate Cake', 'category' => 'food', 'price' => 8.00, 'track_inventory' => true, 'preparation_time' => 5],

            // Beverages
            ['name' => 'Fresh Orange Juice', 'category' => 'beverage', 'price' => 6.00, 'track_inventory' => true, 'preparation_time' => 3],
            ['name' => 'Cappuccino', 'category' => 'beverage', 'price' => 5.00, 'track_inventory' => true, 'preparation_time' => 5],
            ['name' => 'Espresso', 'category' => 'beverage', 'price' => 4.00, 'track_inventory' => true, 'preparation_time' => 3],
            ['name' => 'Iced Tea', 'category' => 'beverage', 'price' => 4.50, 'track_inventory' => true, 'preparation_time' => 2],
            ['name' => 'Mojito', 'category' => 'beverage', 'price' => 10.00, 'track_inventory' => true, 'preparation_time' => 5],
            ['name' => 'Margarita', 'category' => 'beverage', 'price' => 12.00, 'track_inventory' => true, 'preparation_time' => 5],
            ['name' => 'Red Wine Glass', 'category' => 'beverage', 'price' => 15.00, 'track_inventory' => true, 'preparation_time' => 1],
            ['name' => 'Draft Beer', 'category' => 'beverage', 'price' => 7.00, 'track_inventory' => true, 'preparation_time' => 2],
        ];

        foreach ($menuItems as $item) {
            Service::create($item);
        }
    }
}
