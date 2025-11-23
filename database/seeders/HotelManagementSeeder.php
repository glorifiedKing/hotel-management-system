<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{
    RoomType,
    Room,
    Amenity,
    Guest,
    Reservation,
    Invoice,
    Payment,
    Service,
    Employee,
    Shift,
    HousekeepingTask,
    MaintenanceRequest,
    PosOrder,
    PosOrderItem,
    User
};
use Illuminate\Support\Facades\Hash;

class HotelManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Amenities
        $amenities = [
            ['name' => 'WiFi', 'description' => 'High-speed wireless internet', 'icon' => 'heroicon-o-wifi'],
            ['name' => 'TV', 'description' => 'Flat-screen television', 'icon' => 'heroicon-o-tv'],
            ['name' => 'Air Conditioning', 'description' => 'Climate control', 'icon' => 'heroicon-o-sun'],
            ['name' => 'Mini Bar', 'description' => 'In-room refreshments', 'icon' => 'heroicon-o-beaker'],
            ['name' => 'Safe', 'description' => 'Electronic safe', 'icon' => 'heroicon-o-lock-closed'],
            ['name' => 'Coffee Maker', 'description' => 'In-room coffee maker', 'icon' => 'heroicon-o-beaker'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::create($amenity);
        }

        // Create Room Types
        $roomTypes = [
            [
                'name' => 'Standard Room',
                'description' => 'Comfortable room with essential amenities',
                'base_price' => 99.99,
                'max_occupancy' => 2,
                'default_occupancy' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Deluxe Room',
                'description' => 'Spacious room with premium amenities',
                'base_price' => 149.99,
                'max_occupancy' => 3,
                'default_occupancy' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Suite',
                'description' => 'Luxury suite with separate living area',
                'base_price' => 249.99,
                'max_occupancy' => 4,
                'default_occupancy' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Presidential Suite',
                'description' => 'Ultimate luxury with panoramic views',
                'base_price' => 499.99,
                'max_occupancy' => 6,
                'default_occupancy' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($roomTypes as $type) {
            $roomType = RoomType::create($type);
            // Attach amenities
            $roomType->amenities()->attach(Amenity::inRandomOrder()->take(rand(3, 5))->pluck('id'));
        }

        // Create Rooms
        $floors = ['1', '2', '3', '4', '5'];
        $roomNumber = 100;

        foreach ($floors as $floor) {
            for ($i = 1; $i <= 8; $i++) {
                Room::create([
                    'room_number' => $roomNumber++,
                    'room_type_id' => RoomType::inRandomOrder()->first()->id,
                    'floor' => $floor,
                    'status' => collect(['available', 'occupied', 'maintenance', 'cleaning'])->random(),
                    'is_smoking' => rand(0, 1),
                    'is_accessible' => rand(0, 1),
                ]);
            }
        }

        // Create Guests
        $guests = [
            [
                'first_name' => 'John',
                'last_name' => 'Smith',
                'email' => 'john.smith@example.com',
                'phone' => '+1234567890',
                'country' => 'USA',
                'guest_type' => 'regular',
                'loyalty_points' => 150,
            ],
            [
                'first_name' => 'Emma',
                'last_name' => 'Johnson',
                'email' => 'emma.j@example.com',
                'phone' => '+1234567891',
                'country' => 'UK',
                'guest_type' => 'vip',
                'loyalty_points' => 500,
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Brown',
                'email' => 'mbrown@company.com',
                'phone' => '+1234567892',
                'country' => 'Canada',
                'guest_type' => 'corporate',
                'loyalty_points' => 300,
            ],
        ];

        foreach ($guests as $guest) {
            Guest::create($guest);
        }

        // Create Services
        $services = [
            ['name' => 'Room Service Breakfast', 'category' => 'room_service', 'price' => 25.00],
            ['name' => 'Laundry Service', 'category' => 'laundry', 'price' => 15.00],
            ['name' => 'Spa Treatment', 'category' => 'spa', 'price' => 80.00],
            ['name' => 'Airport Transfer', 'category' => 'other', 'price' => 50.00],
            ['name' => 'Wine Bottle', 'category' => 'beverage', 'price' => 35.00],
            ['name' => 'Dinner Entree', 'category' => 'food', 'price' => 28.00],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Create Employees (link to existing users or create new ones)
        $user = User::first();

        $employees = [
            [
                'user_id' => $user->id,
                'employee_number' => 'EMP001',
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => $user->email,
                'phone' => '+1234567800',
                'department' => 'management',
                'position' => 'Hotel Manager',
                'hourly_rate' => 50.00,
                'hire_date' => now()->subYears(2),
                'employment_status' => 'active',
            ],
        ];

        foreach ($employees as $emp) {
            $employee = Employee::create($emp);

            // Create shifts for this employee
            for ($i = 0; $i < 5; $i++) {
                Shift::create([
                    'employee_id' => $employee->id,
                    'shift_date' => now()->addDays($i),
                    'start_time' => '09:00:00',
                    'end_time' => '17:00:00',
                    'shift_type' => 'full_day',
                    'status' => 'scheduled',
                ]);
            }
        }

        // Create Reservations
        $guest = Guest::first();
        $rooms = Room::where('status', 'available')->take(2)->get();

        $reservation = Reservation::create([
            'guest_id' => $guest->id,
            'check_in_date' => now()->addDays(1),
            'reservation_number' => 'RSV-' . strtoupper(uniqid()),
            'check_out_date' => now()->addDays(4),
            'number_of_guests' => 2,
            'number_of_rooms' => 2,
            'status' => 'confirmed',
            'total_amount' => 897.96,
            'deposit_amount' => 200.00,
            'booking_source' => 'website',
            'created_by' => $user->id,
        ]);

        // Attach rooms to reservation
        foreach ($rooms as $room) {
            $reservation->rooms()->attach($room->id, [
                'room_rate' => $room->roomType->base_price,
                'number_of_guests' => 1,
            ]);
        }

        // Create Invoice
        $invoice = Invoice::create([
            'reservation_id' => $reservation->id,
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'guest_id' => $guest->id,
            'subtotal' => 897.96,
            'tax_amount' => 89.80,
            'total_amount' => 987.76,
            'paid_amount' => 200.00,
            'balance_amount' => 787.76,
            'status' => 'issued',
            'issue_date' => now(),
            'due_date' => now()->addDays(4),
        ]);

        // Create Payment
        Payment::create([
            'invoice_id' => $invoice->id,
            'reservation_id' => $reservation->id,
            'payment_number' => 'PYT-' . strtoupper(uniqid()),
            'amount' => 200.00,
            'payment_method' => 'credit_card',
            'status' => 'completed',
            'payment_date' => now(),
            'processed_by' => $user->id,
        ]);

        // Create Housekeeping Tasks
        foreach (Room::take(5)->get() as $room) {
            HousekeepingTask::create([
                'room_id' => $room->id,
                'assigned_to' => $user->id,
                'task_type' => 'cleaning',
                'priority' => collect(['low', 'medium', 'high'])->random(),
                'status' => collect(['pending', 'in_progress', 'completed'])->random(),
                'scheduled_at' => now()->addHours(rand(1, 24)),
            ]);
        }

        // Create Maintenance Requests
        MaintenanceRequest::create([
            'room_id' => Room::first()->id,
            'reported_by' => $user->id,
            'title' => 'Air conditioning not working',
            'description' => 'The AC unit is not cooling properly',
            'category' => 'hvac',
            'priority' => 'high',
            'status' => 'open',
            'reported_at' => now(),
        ]);

        // Create POS Orders
        $posOrder = PosOrder::create([
            'reservation_id' => $reservation->id,
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'guest_id' => $guest->id,
            'order_type' => 'room_service',
            'subtotal' => 53.00,
            'tax_amount' => 5.30,
            'total_amount' => 58.30,
            'status' => 'delivered',
            'charge_to_room' => true,
            'served_by' => $user->id,
            'order_time' => now()->subHours(2),
            'delivered_at' => now()->subHour(),
        ]);

        // Add items to POS order
        $service = Service::where('category', 'room_service')->first();
        PosOrderItem::create([
            'pos_order_id' => $posOrder->id,
            'service_id' => $service->id,
            'quantity' => 2,
            'unit_price' => $service->price,
            'total_price' => $service->price * 2,
        ]);

        $beverage = Service::where('category', 'beverage')->first();
        PosOrderItem::create([
            'pos_order_id' => $posOrder->id,
            'service_id' => $beverage->id,
            'quantity' => 1,
            'unit_price' => $beverage->price,
            'total_price' => $beverage->price,
        ]);
    }
}
