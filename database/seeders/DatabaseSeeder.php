<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserManagement\MenuModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Super admin',
            'email' => 'superadmin@admin.com',
            'company_id' => 1,
            'role_id' => 1,
            'is_superadmin' => true,
            'password' => bcrypt('mavora123$#'),
        ]);

        User::factory()->create([
            'name' => 'Admin 2',
            'email' => 'admin2@admin.com',
            'company_id' => 2,
            'role_id' => 2,
            'is_superadmin' => false,
            'password' => bcrypt('admin2123$#'),
        ]);

        User::factory()->create([
            'name' => 'Admin 3',
            'email' => 'admin3@admin.com',
            'company_id' => 1,
            'role_id' => 2,
            'is_superadmin' => false,
            'password' => bcrypt('admin3123$#'),
        ]);

        $this->createAddress();

        $this->createMenus();

        $this->createCompanyManagement();

        $this->createRolePermission();

    }

    private function createLevel($parentId, $prefix, $level, $maxLevel)
    {
        if ($level > $maxLevel) {
            return;
        }

        for ($i = 1; $i <= 3; $i++) {
            $menu = MenuModel::create([
                'parent_id' => $parentId,
                'name' => "{$prefix} L{$level}-{$i}",
                'icon' => 'ri-car-line',
                'route' => $level == $maxLevel ? 'route.name' : null,
                'seq_id' => $i,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->createLevel($menu->id, "{$prefix} L{$level}-{$i}", $level + 1, $maxLevel);
        }
    }

    // private function createLevel($parentId, $prefix, $level, $maxLevel)
    // {
    //     if ($level > $maxLevel) return;

    //     for ($i = 1; $i <= 3; $i++) {
    //         $menu = Menu::create([
    //             'parent_id' => $parentId,
    //             'name' => "{$prefix} L{$level}-{$i}",
    //             'icon' => 'ri-car-line',
    //             'route' => $level == $maxLevel ? 'route.name' : null,
    //             'order' => $i,
    //             'is_active' => true,
    //             'level' => $level, 
    //         ]);

    //         $this->createLevel($menu->id, "{$prefix} L{$level}-{$i}", $level + 1, $maxLevel);
    //     }
    // }

    
    public function createCompanyManagement()
    {
         DB::unprepared("
            INSERT INTO public.companies
             (id, code, name, short_desc, logo, province_id, city_id, sub_district_id, address, zip_code, country, email, phone, 
             whatsapp, fax, domain, npwp, po_box, is_active, deleted_at, deleted_by, created_by, updated_by, created_at, updated_at)
            VALUES(1, 'CMPN', 'PT ALTAN BERKAH JAYA ABADI', 'PT ALTAN BERKAH JAYA ABADI', NULL, 1, 1, 2, 'jl. pakulonan selatan', '09898', 'indonesia', 'cs@altan.com', '081999073207', '081999073207', 'x8878', 'altan.com', '80808887897887', 'po bix', true, NULL, NULL, 1, NULL, '2025-07-04 23:06:37.000', '2025-07-04 23:06:37.000');
           
            INSERT INTO public.companies
            (id, code, name, short_desc, logo, province_id, city_id, sub_district_id, address, zip_code, country, email, phone, whatsapp, fax, domain, npwp, po_box, is_active, deleted_at, deleted_by, created_by, updated_by, created_at, updated_at)
            VALUES(2, 'BHKKJD', 'PT MOTIVA TEKNOLOGI NUSANTARA', 'PT MOTIVA TEKNOLOGI NUSANTARA', NULL, 1, 1, 2, 'sumbawa', '998989', 'Indonesia', 'cs@mavora.id', '081999073207', '081999073207', '2334', 'mavora.id', '989898 989898 98989898', '1093', true, NULL, NULL, 1, NULL, '2025-07-04 23:08:00.000', '2025-07-04 23:08:00.000');
        

            INSERT INTO public.departments
            (id, company_id, code, name, is_active, deleted_at, deleted_by, created_by, updated_by, created_at, updated_at)
            VALUES(1, 1, 'NA', 'NA', true, NULL, NULL, 1, NULL, '2025-07-15 14:07:48.000', '2025-07-15 14:07:48.000');

            INSERT INTO public.positions
            (id, company_id, department_id, code, name, is_active, deleted_at, deleted_by, created_by, updated_by, created_at, updated_at)
            VALUES(1, 1, 1, 'NA', 'NA', true, NULL, NULL, 1, NULL, '2025-07-15 14:08:03.000', '2025-07-15 14:08:03.000');
            
            INSERT INTO public.levels
            (id, company_id, position_id, code, name, is_active, deleted_at, deleted_by, created_by, updated_by, created_at, updated_at)
            VALUES(1, 1, 1, 'NA', 'NA', true, NULL, NULL, 1, NULL, '2025-07-15 14:08:18.000', '2025-07-15 14:08:18.000');
        ");
            

    }

    public function createAddress()
    {
        DB::table('provinces')->insert([
            ['code' => '01', 'name' => 'Aceh', 'created_by' => 1],
            ['code' => '02', 'name' => 'Sumatera Utara', 'created_by' => 1],
            ['code' => '03', 'name' => 'Sumatera Barat', 'created_by' => 1],
        ]);

        DB::table('cities')->insert([
            ['code' => '0101', 'name' => 'Banda Aceh', 'province_id' => 1, 'postal_code' => '23111', 'created_by' => 1],
            ['code' => '0102', 'name' => 'Langsa', 'province_id' => 1, 'postal_code' => '24411', 'created_by' => 1],
            ['code' => '0201', 'name' => 'Medan', 'province_id' => 2, 'postal_code' => '20111', 'created_by' => 1],
        ]);

        DB::table('sub_districts')->insert([
            ['code' => '010101', 'name' => 'Meuraxa', 'province_id' => 1, 'city_id' => 1, 'created_by' => 1],
            ['code' => '010102', 'name' => 'Jaya Baru', 'province_id' => 1, 'city_id' => 1, 'created_by' => 1],
            ['code' => '020101', 'name' => 'Medan Barat', 'province_id' => 2, 'city_id' => 3, 'created_by' => 1],
        ]);
    }

     public function createMenus()
    {
        DB::unprepared("


            create view vw_menu_tree as 
            WITH RECURSIVE menu_tree AS (
                SELECT
                    id,
                    name,
                    route,
                    icon,
                    parent_id,
                    seq_id,
                    is_active,
                    1 AS level
                FROM
                    menus
                WHERE
                    parent_id IS NULL AND is_active = TRUE

                UNION ALL

                SELECT
                    m.id,
                    m.name,
                    m.route,
                    m.icon,
                    m.parent_id,
                    m.seq_id,
                    m.is_active,
                    mt.level + 1 AS level
                FROM
                    menus m
                JOIN
                    menu_tree mt ON m.parent_id = mt.id
                WHERE
                    m.is_active = TRUE
            )
            SELECT
                id,
                name,
                route,
                icon,
                parent_id,
                level
            FROM
                menu_tree
            ORDER BY
                level, parent_id NULLS FIRST, seq_id;

        ");

        DB::unprepared("
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(9, 2, 'Company', 'company-management-company', NULL, 1, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(10, 2, 'Department', 'company-management-department', NULL, 2, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(12, 2, 'Level', 'company-management-level', NULL, 4, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(11, 2, 'Position', 'company-management-position', NULL, 3, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(1, NULL, 'Dashboard', 'home', 'ri-home-smile-line', 1, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(46, 25, 'Adjustment Type', 'inventory-master-adjustmenttype', NULL, 12, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(19, 25, 'Brand', 'inventory-master-brand', NULL, 4, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(18, 25, 'Category', 'inventory-master-category', NULL, 3, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(45, 25, 'Color', 'inventory-master-color', NULL, 11, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(44, 25, 'Color Group', 'inventory-master-colorgroup', NULL, 10, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(20, 25, 'Group', 'inventory-master-group', NULL, 5, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(49, 47, 'Price Type', 'inventory-master-pricemaster-pricetype', NULL, 1, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(51, 47, 'Purchase Price', 'inventory-master-pricemaster-purchaseprice', NULL, 3, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(50, 47, 'Sales Price', 'inventory-master-pricemaster-salesprice', NULL, 2, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(16, 25, 'Product', 'inventory-master-product', NULL, 1, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(43, 25, 'Size', 'inventory-master-size', NULL, 9, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(42, 25, 'Size Group', 'inventory-master-sizegroup', NULL, 8, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(21, 25, 'Sub Group', 'inventory-master-subgroup', NULL, 6, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(17, 25, 'Type', 'inventory-master-type', NULL, 2, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(41, 25, 'Unit of Measure (UoM)', 'inventory-master-uom', NULL, 7, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(53, 48, 'Rack', 'inventory-master-warehousemaster-rack', NULL, 3, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(52, 48, 'Warehouse', 'inventory-master-warehousemaster-warehouse', NULL, 2, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(54, 48, 'Warehouse Type', 'inventory-master-warehousemaster-warehousetype', NULL, 1, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(13, 3, 'Menu', 'user-management-menu', NULL, 1, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(14, 3, 'Role & Permission', 'user-management-roles', NULL, 2, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(15, 3, 'User', 'user-management-users', NULL, 3, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(2, NULL, 'Company Management', '#', 'ri-building-line', 2, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(3, NULL, 'User Management', '#', 'ri-user-settings-line', 3, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(4, NULL, 'Inventory', '#', 'ri-box-3-line', 4, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(5, NULL, 'Purchasing', '#', 'ri-shopping-bag-4-line', 5, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(6, NULL, 'Sales', '#', 'ri-line-chart-line', 6, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(7, NULL, 'Finance', '#', 'ri-wallet-3-line', 8, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(8, NULL, 'Production', '#', 'ri-settings-3-line', 11, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(47, 25, 'Price Master', '#', NULL, 13, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(48, 25, 'Warehouse Master', '#', NULL, 14, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(25, 4, 'Master', '#', NULL, 1, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(26, 5, 'Master', '#', NULL, 1, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(27, 6, 'Master', '#', NULL, 1, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(28, 7, 'Master', '#', NULL, 1, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(29, 8, 'Master', '#', NULL, 1, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(30, 22, 'Master', '#', NULL, 1, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(31, 23, 'Master', '#', NULL, 1, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(32, 24, 'Master', '#', NULL, 1, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(33, 4, 'Transaction', '#', NULL, 2, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(34, 5, 'Transaction', '#', NULL, 2, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(35, 6, 'Transaction', '#', NULL, 2, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(36, 7, 'Transaction', '#', NULL, 2, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(37, 8, 'Transaction', '#', NULL, 2, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(38, 22, 'Transaction', '#', NULL, 2, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(39, 23, 'Transaction', '#', NULL, 2, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(40, 24, 'Transaction', '#', NULL, 2, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(22, NULL, 'HRIS', '#', 'ri-pass-valid-line', 9, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(23, NULL, 'Point Of Sale', '#', 'ri-price-tag-3-line', 7, true, NULL, NULL, NULL, NULL);
            INSERT INTO public.menus
            (id, parent_id, name, route, icon, seq_id, is_active, created_at, updated_at, deleted_at, deleted_by)
            VALUES(24, NULL, 'Fixed Asset', '#', 'ri-community-line', 10, true, NULL, NULL, NULL, NULL);
        ");

        DB::unprepared("

            CREATE OR REPLACE FUNCTION public.fn_breadcrumb(p_route_name TEXT)
            RETURNS TABLE (
                id BIGINT, 
                name VARCHAR, 
                route VARCHAR 
            )
            LANGUAGE plpgsql
            AS $$
            BEGIN
                RETURN QUERY
                WITH RECURSIVE breadcrumb_path AS (
                 
                    SELECT
                        m.id,
                        m.name,
                        m.route,
                        m.parent_id,
                        1 AS depth_level
                    FROM
                        public.menus AS m
                    WHERE
                        m.route = p_route_name AND m.is_active = TRUE

                    UNION ALL

                    -- Recursive member: Cari parent dari menu yang sudah ditemukan
                    SELECT
                        m.id,
                        m.name,
                        m.route,
                        m.parent_id,
                        bp.depth_level + 1 AS depth_level
                    FROM
                        public.menus AS m
                    JOIN
                        breadcrumb_path AS bp ON m.id = bp.parent_id
                    WHERE
                        m.is_active = TRUE
                )
                SELECT
                    bp.id,
                    bp.name,
                    bp.route
                FROM
                    breadcrumb_path AS bp
                ORDER BY
                    bp.depth_level DESC;
            END;
            $$;
        ");
    }

    public function createRolePermission(){
        DB::unprepared("
            INSERT INTO public.roles
            (id, company_id, role_name, is_active, created_at, updated_at, created_by, updated_by, deleted_at, deleted_by)
            VALUES(1, 1, 'super admin', true, '2025-07-15 14:06:03.000', '2025-07-15 14:06:03.000', 1, NULL, NULL, NULL);
            INSERT INTO public.roles
            (id, company_id, role_name, is_active, created_at, updated_at, created_by, updated_by, deleted_at, deleted_by)
            VALUES(2, 1, 'admin', true, '2025-07-16 00:07:08.000', '2025-07-16 00:07:08.000', 3, NULL, NULL, NULL);

            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(1, 1, 1, 1, 1, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(2, 1, 1, 2, 2, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(3, 1, 1, 9, 3, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(4, 1, 1, 10, 4, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(5, 1, 1, 11, 5, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(6, 1, 1, 12, 6, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(8, 1, 1, 13, 8, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(9, 1, 1, 14, 9, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(10, 1, 1, 15, 10, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(11, 1, 1, 4, 11, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(12, 1, 1, 25, 12, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(13, 1, 1, 16, 13, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(14, 1, 1, 17, 14, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(15, 1, 1, 18, 15, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(16, 1, 1, 19, 16, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(17, 1, 1, 20, 17, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(18, 1, 1, 21, 18, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(19, 1, 1, 41, 19, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(20, 1, 1, 42, 20, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(21, 1, 1, 43, 21, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(22, 1, 1, 44, 22, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(23, 1, 1, 45, 23, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(24, 1, 1, 46, 24, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(25, 1, 1, 47, 25, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(26, 1, 1, 49, 26, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(27, 1, 1, 50, 27, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(28, 1, 1, 51, 28, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(29, 1, 1, 48, 29, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(30, 1, 1, 54, 30, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(31, 1, 1, 52, 31, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(32, 1, 1, 53, 32, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(33, 1, 1, 33, 33, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(34, 1, 1, 5, 34, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(35, 1, 1, 26, 35, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(36, 1, 1, 34, 36, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(37, 1, 1, 6, 37, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(38, 1, 1, 27, 38, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(39, 1, 1, 35, 39, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(40, 1, 1, 23, 40, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(41, 1, 1, 31, 41, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(42, 1, 1, 39, 42, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(43, 1, 1, 7, 43, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(44, 1, 1, 28, 44, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(45, 1, 1, 36, 45, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(46, 1, 1, 22, 46, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(47, 1, 1, 30, 47, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(48, 1, 1, 38, 48, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(49, 1, 1, 24, 49, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(50, 1, 1, 32, 50, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(51, 1, 1, 40, 51, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(52, 1, 1, 8, 52, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(53, 1, 1, 29, 53, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(54, 1, 1, 37, 54, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(7, 1, 1, 3, 7, true, true, true, true, true, true, true, '2025-07-15 14:06:03.000', NULL, 1, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(55, 1, 2, 1, 1, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(56, 1, 2, 2, 2, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(57, 1, 2, 9, 3, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(58, 1, 2, 10, 4, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(59, 1, 2, 11, 5, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(60, 1, 2, 12, 6, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(61, 1, 2, 3, 7, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(62, 1, 2, 13, 8, false, false, false, false, false, false, false, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(63, 1, 2, 14, 9, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(64, 1, 2, 15, 10, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(65, 1, 2, 4, 11, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(66, 1, 2, 25, 12, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(67, 1, 2, 16, 13, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(68, 1, 2, 17, 14, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(69, 1, 2, 18, 15, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(70, 1, 2, 19, 16, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(71, 1, 2, 20, 17, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(72, 1, 2, 21, 18, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(73, 1, 2, 41, 19, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(74, 1, 2, 42, 20, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(75, 1, 2, 43, 21, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(76, 1, 2, 44, 22, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(77, 1, 2, 45, 23, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(78, 1, 2, 46, 24, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(79, 1, 2, 47, 25, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(80, 1, 2, 49, 26, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(81, 1, 2, 50, 27, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(82, 1, 2, 51, 28, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(83, 1, 2, 48, 29, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(84, 1, 2, 54, 30, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(85, 1, 2, 52, 31, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(86, 1, 2, 53, 32, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(87, 1, 2, 33, 33, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(88, 1, 2, 5, 34, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(89, 1, 2, 26, 35, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(90, 1, 2, 34, 36, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(91, 1, 2, 6, 37, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(92, 1, 2, 27, 38, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(93, 1, 2, 35, 39, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(94, 1, 2, 23, 40, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(95, 1, 2, 31, 41, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(96, 1, 2, 39, 42, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(97, 1, 2, 7, 43, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(98, 1, 2, 28, 44, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(99, 1, 2, 36, 45, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(100, 1, 2, 22, 46, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(101, 1, 2, 30, 47, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(102, 1, 2, 38, 48, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(103, 1, 2, 24, 49, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(104, 1, 2, 32, 50, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(105, 1, 2, 40, 51, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(106, 1, 2, 8, 52, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(107, 1, 2, 29, 53, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);
            INSERT INTO public.permissions
            (id, company_id, role_id, menu_id, seq_id, can_create, can_update, can_delete, can_view, can_print, can_open, can_confirm, created_at, updated_at, created_by, updated_by)
            VALUES(108, 1, 2, 37, 54, true, true, true, true, true, true, true, '2025-07-16 00:07:08.000', NULL, 3, NULL);

        ");

        DB::unprepared('
            CREATE OR REPLACE FUNCTION public.fn_permission_menu(p_role_id integer)
            RETURNS TABLE(id bigint, name character varying, route character varying, icon character varying, parent_id bigint, level integer)
            LANGUAGE plpgsql
            AS $function$
            BEGIN
                RETURN QUERY
                WITH RECURSIVE menu_tree AS (
                    SELECT
                        m.id,
                        m.name,
                        m.route,
                        m.icon,
                        m.parent_id,
                        m.seq_id,
                        m.is_active,
                        1 AS level
                    FROM
                        menus m
                    WHERE
                        m.parent_id IS NULL AND m.is_active = TRUE

                    UNION ALL

                    SELECT
                        m.id,
                        m.name,
                        m.route,
                        m.icon,
                        m.parent_id,
                        m.seq_id,
                        m.is_active,
                        mt.level + 1 AS level
                    FROM
                        menus m
                    JOIN
                        menu_tree mt ON m.parent_id = mt.id
                    WHERE
                        m.is_active = TRUE
                )
                SELECT
                    mt_outer.id,
                    mt_outer.name,
                    mt_outer.route,
                    mt_outer.icon,
                    mt_outer.parent_id,
                    mt_outer.level
                FROM
                    menu_tree mt_outer
                WHERE
                    EXISTS (
                        SELECT 1
                        FROM
                            roles r
                        JOIN
                            permissions p ON p.role_id = r.id
                        WHERE
                            p.menu_id = mt_outer.id AND
                            r.is_active = TRUE AND
                            (
                                p.can_create = TRUE OR
                                p.can_update = TRUE OR
                                p.can_delete = TRUE OR
                                p.can_view = TRUE OR
                                p.can_print = TRUE OR
                                p.can_open = TRUE OR
                                p.can_confirm = TRUE
                            ) AND p.role_id = p_role_id
                    )
                ORDER BY
                    level,
                    parent_id NULLS FIRST,
                    seq_id;
            END;
            $function$
            ;
        ');

    }







}


