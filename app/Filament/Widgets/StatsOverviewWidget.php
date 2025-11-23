<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\{Room, Reservation, Invoice, Guest, HousekeepingTask, MaintenanceRequest};

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100, 1) : 0;

        $todayCheckIns = Reservation::whereDate('check_in_date', today())
            ->whereIn('status', ['confirmed', 'checked_in'])
            ->count();

        $todayCheckOuts = Reservation::whereDate('check_out_date', today())
            ->whereIn('status', ['checked_in', 'checked_out'])
            ->count();

        $pendingInvoices = Invoice::where('status', 'issued')->count();
        $totalRevenue = Invoice::where('status', 'paid')->sum('total_amount');

        $pendingHousekeeping = HousekeepingTask::where('status', 'pending')->count();
        $openMaintenanceRequests = MaintenanceRequest::where('status', 'open')->count();

        return [
            Stat::make('Occupancy Rate', $occupancyRate . '%')
                ->description("$occupiedRooms of $totalRooms rooms occupied")
                ->descriptionIcon('heroicon-m-home')
                ->color($occupancyRate > 80 ? 'success' : ($occupancyRate > 50 ? 'warning' : 'danger')),

            Stat::make('Available Rooms', $availableRooms)
                ->description('Ready for booking')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Check-ins Today', $todayCheckIns)
                ->description('Expected arrivals')
                ->descriptionIcon('heroicon-m-arrow-down-on-square')
                ->color('info'),

            Stat::make('Check-outs Today', $todayCheckOuts)
                ->description('Expected departures')
                ->descriptionIcon('heroicon-m-arrow-up-on-square')
                ->color('warning'),

            Stat::make('Total Revenue', '$' . number_format($totalRevenue, 2))
                ->description('From paid invoices')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),

            Stat::make('Pending Invoices', $pendingInvoices)
                ->description('Awaiting payment')
                ->descriptionIcon('heroicon-m-document-text')
                ->color($pendingInvoices > 10 ? 'warning' : 'info'),

            Stat::make('Housekeeping Tasks', $pendingHousekeeping)
                ->description('Pending tasks')
                ->descriptionIcon('heroicon-m-wrench-screwdriver')
                ->color($pendingHousekeeping > 20 ? 'danger' : 'info'),

            Stat::make('Maintenance Requests', $openMaintenanceRequests)
                ->description('Open requests')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($openMaintenanceRequests > 5 ? 'danger' : 'warning'),
        ];
    }
}
