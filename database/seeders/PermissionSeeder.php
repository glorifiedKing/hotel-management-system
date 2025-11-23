<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all models that need permissions
        $models = [
            'Amenity',
            'Employee',
            'Guest',
            'HousekeepingTask',
            'InventoryCategory',
            'InventoryItem',
            'InventoryTransaction',
            'Invoice',
            'InvoiceItem',
            'Kitchen',
            'KitchenOrder',
            'KitchenOrderItem',
            'MaintenanceRequest',
            'Payment',
            'PosOrder',
            'PosOrderItem',
            'PurchaseOrder',
            'PurchaseOrderItem',
            'Reservation',
            'ReservationRoom',
            'Restaurant',
            'RestaurantTable',
            'Room',
            'RoomType',
            'Service',
            'Shift',
            'Supplier',
            'Role',
            'User',
        ];

        // Define all permission actions
        $actions = [
            'ViewAny',
            'View',
            'Create',
            'Update',
            'Delete',
            'Restore',
            'ForceDelete',
            'ForceDeleteAny',
            'RestoreAny',
            'Replicate',
            'Reorder',
        ];

        // Create permissions for each model
        foreach ($models as $model) {
            foreach ($actions as $action) {
                Permission::updateOrCreate(
                    [
                        'name' => "{$action}:{$model}",
                        'guard_name' => 'web',
                    ]
                );
            }
        }

        $this->command->info('Permissions created successfully!');
    }
}
