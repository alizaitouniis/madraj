<?php

namespace Tests\Unit;

use App\Enums\Permission;
use App\Enums\Role;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class RolePermissionTest extends TestCase
{
    /**
     * The roles and permissions table from CLAUDE.md.
     *
     * @return array<string, array{Permission, list<Role>}>
     */
    public static function matrix(): array
    {
        return [
            'create and edit matches' => [Permission::ManageMatches, [Role::Owner, Role::Manager]],
            'set prices and zones' => [Permission::ManagePricing, [Role::Owner, Role::Manager]],
            'see orders and fans' => [Permission::ViewOrders, [Role::Owner, Role::Manager, Role::Finance, Role::BoxOffice]],
            'refund and cancel' => [Permission::RefundOrders, [Role::Owner, Role::Manager, Role::Finance]],
            'take cash at the stadium' => [Permission::CollectCash, Role::cases()],
            'see payouts and reports' => [Permission::ViewPayouts, [Role::Owner, Role::Finance]],
            'scan tickets at entry' => [Permission::ScanTickets, [Role::Owner, Role::Manager, Role::BoxOffice, Role::Security]],
            'invite staff' => [Permission::InviteStaff, [Role::Owner]],
        ];
    }

    /**
     * @param  list<Role>  $allowed
     */
    #[DataProvider('matrix')]
    public function test_role_permissions_match_the_brief(Permission $permission, array $allowed): void
    {
        foreach (Role::cases() as $role) {
            $this->assertSame(
                in_array($role, $allowed, true),
                $role->can($permission),
                "{$role->value} / {$permission->value}",
            );
        }
    }

    public function test_every_permission_is_covered_by_the_matrix(): void
    {
        $covered = array_map(fn (array $row) => $row[0], self::matrix());

        $this->assertEqualsCanonicalizing(Permission::cases(), array_values($covered));
    }
}
