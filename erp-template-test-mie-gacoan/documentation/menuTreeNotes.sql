INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(6, NULL, 'Sales', NULL, 'ri-line-chart-line', 6, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(9, 2, 'Company', 'company-management-company', NULL, 1, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(10, 2, 'Department', 'company-management-department', NULL, 2, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(11, 2, 'Position', 'company-management-position', NULL, 3, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(12, 2, 'Level', 'company-management-level', NULL, 4, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(13, 3, 'Menu', 'user-management-menu', NULL, 1, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(14, 3, 'Role & Permission', 'user-management-roles', NULL, 2, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(15, 3, 'User', 'user-management-users', NULL, 3, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(16, 4, 'Product', 'inventory-master-product', NULL, 1, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(17, 4, 'Type', 'inventory-master-type', NULL, 2, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(18, 4, 'Category', 'inventory-master-category', NULL, 3, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(19, 4, 'Brand', 'inventory-master-brand', NULL, 4, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(20, 4, 'Group', 'inventory-master-group', NULL, 5, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(21, 4, 'Sub Group', 'inventory-master-subgroup', NULL, 6, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(1, NULL, 'Dashboard', 'home', 'ri-home-smile-line', 1, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(2, NULL, 'Company Management', NULL, 'ri-building-line', 2, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(7, NULL, 'Finance', NULL, 'ri-wallet-3-line', 8, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(22, NULL, 'HRIS', NULL, 'ri-pass-valid-line', 9, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(5, NULL, 'Purchasing', NULL, 'ri-shopping-bag-4-line', 5, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(24, NULL, 'Fixed Asset', NULL, 'ri-community-line', 10, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(23, NULL, 'Point Of Sale', NULL, 'ri-price-tag-3-line', 7, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(8, NULL, 'Production', NULL, 'ri-settings-3-line', 11, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(3, NULL, 'User Management', NULL, 'ri-user-settings-line', 3, true, NULL, NULL);
INSERT INTO public.menus
(id, parent_id, "name", route, icon, seq_id, is_active, created_at, updated_at)
VALUES(4, NULL, 'Inventory', NULL, 'ri-box-3-line', 4, true, NULL, NULL);



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