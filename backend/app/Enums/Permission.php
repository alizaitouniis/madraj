<?php

namespace App\Enums;

/** Things a team member may do. Arabic labels match the Figma "Staff and roles" screen. */
enum Permission: string
{
    case ManageMatches = 'manage_matches';
    case ManagePricing = 'manage_pricing';
    case ViewOrders = 'view_orders';
    case RefundOrders = 'refund_orders';
    case CollectCash = 'collect_cash';
    case ViewPayouts = 'view_payouts';
    case ScanTickets = 'scan_tickets';
    case InviteStaff = 'invite_staff';

    public function label(): string
    {
        return match ($this) {
            self::ManageMatches => 'إنشاء المباريات وتعديلها',
            self::ManagePricing => 'تحديد الأسعار والمدرجات',
            self::ViewOrders => 'رؤية الطلبات والمشجعين',
            self::RefundOrders => 'الاسترداد والإلغاء',
            self::CollectCash => 'استلام النقد في الملعب',
            self::ViewPayouts => 'رؤية المدفوعات والتقارير',
            self::ScanTickets => 'مسح التذاكر عند الدخول',
            self::InviteStaff => 'دعوة الفريق',
        };
    }
}
