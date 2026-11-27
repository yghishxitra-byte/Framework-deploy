-- Очищаем старые данные
TRUNCATE products, categories RESTART IDENTITY CASCADE;

-- Новые категории (Автозапчасти)
INSERT INTO categories (name, slug) VALUES 
('Двигатель', 'engine'), ('Тормозная система', 'brakes'), 
('Подвеска', 'suspension'), ('Электрика', 'electric');

-- Склады
INSERT INTO warehouses (name) VALUES 
('Склад Москва'), ('Склад Питер'), ('Склад Новосибирск'), ('Склад Екатеринбург');

-- Генерируем 1000 реалистичных товаров
INSERT INTO products (category_id, warehouse_id, name, slug, description, price, stock_quantity)
SELECT 
    (SELECT id FROM categories ORDER BY random() LIMIT 1),
    (SELECT id FROM warehouses ORDER BY random() LIMIT 1),
    'Запчасть ' || i,
    'part-' || i,
    'Высококачественная автозапчасть для вашего автомобиля.',
    round((random() * 15000 + 500)::numeric, 2),
    -- Рандом от 0 до 100. Если 0 - на фронте покажем "Нет в наличии"
    floor(random() * 101)::int 
FROM generate_series(1, 1000) AS s(i);