-- 1. Сначала добавим категории (если их еще нет)
INSERT INTO categories (name, slug)
VALUES 
    ('Электроника', 'electronics'),
    ('Одежда', 'clothing'),
    ('Книги', 'books'),
    ('Дом и сад', 'home-garden'),
    ('Спорт', 'sports')
ON CONFLICT (slug) DO NOTHING;

-- 2. Генерируем 1000 товаров
-- Используем generate_series от 1 до 1000
INSERT INTO products (category_id, name, slug, description, price, stock_quantity)
SELECT 
    -- Случайная категория от 1 до 5 (используем подзапрос, чтобы взять реальные ID)
    (SELECT id FROM categories ORDER BY random() LIMIT 1),
    'Товар #' || i,
    'product-' || i,
    'Описание для товара номер ' || i || '. Это тестовые данные для стресс-теста.',
    -- Случайная цена от 10.00 до 1000.00
    round((random() * 990 + 10)::numeric, 2),
    -- Случайное количество от 0 до 500
    floor(random() * 500)::int
FROM generate_series(1, 1000) AS s(i);