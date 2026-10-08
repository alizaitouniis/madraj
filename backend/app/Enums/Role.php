<?php

namespace App\Enums;

/** Role of a team member. The permission matrix is the one in CLAUDE.md. */
enum Role: string
{
    case Owner = 'owner';
    case Manager = 'manager';
    case Finance = 'finance';
    case BoxOffice = 'box_office';
    case Security = 'security';

    public function label(): string
    {
        return match ($this) {
            self::Owner => 'المالك',
            self::Manager => 'مدير',
            self::Finance => 'المالية',
            self::BoxOffice => 'شباك التذاكر',
            self::Security => 'الأمن',
        };
    }

    /**
     * @return list<Permission>
     */
    public function permissions(): array
    {
        return match ($this) {
            self::Owner => Permission::cases(),
            self::Manager => [
                Permission::ManageMatches,
                Permission::ManagePricing,
                Permission::ViewOrders,
                Permission::RefundOrders,
                Permission::CollectCash,
                Permission::ScanTickets,
            ],
            self::Finance => [
                Permission::ViewOrders,
                Permission::RefundOrders,
                Permission::CollectCash,
                Permission::ViewPayouts,
            ],
            self::BoxOffice => [
                Permission::ViewOrders,
                Permission::CollectCash,
                Permission::ScanTickets,
            ],
            self::Security => [
                Permission::CollectCash,
                Permission::ScanTickets,
            ],
        };
    }

    public function can(Permission $permission): bool
    {
        return in_array($permission, $this->permissions(), true);
    }
}
