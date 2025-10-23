DO $$
DECLARE
  start_id integer;
  day_num integer;
BEGIN
  SELECT COALESCE(MAX(id), 0) + 1 INTO start_id FROM public.users;
  
  FOR i IN start_id..start_id+49 LOOP
    day_num := ((i - start_id) % 28) + 1;  -- Pastikan tanggal 1..28
    
    INSERT INTO public.users
    (id, "name", email, email_verified_at, "password", remember_token, created_at, updated_at)
    VALUES (
      i,
      'Test User ' || i,
      'user' || i || '@example.com',
      ('2025-05-' || LPAD(day_num::text, 2, '0') || ' 01:03:04')::timestamp,
      '$2y$12$jlW3wPYGpvj2t57GjGtdbuQriF.UN8woc9Q7gXnqfE.qko8YEWuom',
      'Token' || i,
      ('2025-05-' || LPAD(day_num::text, 2, '0') || ' 01:03:04')::timestamp,
      ('2025-05-' || LPAD(day_num::text, 2, '0') || ' 01:03:04')::timestamp
    );
  END LOOP;
END $$;