schema "public" {
}

table "warehouses" {
  schema = schema.public
  column "id" {
    null = false
    type = bigserial
  }
  column "name" {
    null = false
    type = varchar(255)
  }
  primary_key {
    columns = [column.id]
  }
}

table "categories" {
  schema = schema.public
  column "id" {
    null = false
    type = bigserial
  }
  column "name" {
    null = false
    type = varchar(255)
  }
  column "slug" {
    null = false
    type = varchar(255)
  }
  primary_key {
    columns = [column.id]
  }
  index "idx_categories_slug" {
    unique = true
    columns = [column.slug]
  }
}

table "products" {
  schema = schema.public
  column "id" {
    null = false
    type = bigserial
  }
  column "category_id" {
    null = false
    type = bigint
  }
  column "warehouse_id" {  # <--- ДОБАВИЛИ ЭТУ СТРОКУ
    null = false
    type = bigint
  }
  column "name" {
    null = false
    type = varchar(255)
  }
  column "slug" {
    null = false
    type = varchar(255)
  }
  column "description" {
    null = true
    type = text
  }
  column "price" {
    null = false
    type = numeric(10, 2)
  }
  column "stock_quantity" {
    null = false
    type = integer
    default = 0
  }
  column "created_at" {
    null = false
    type = timestamptz
    default = sql("CURRENT_TIMESTAMP")
  }
  column "updated_at" {
    null = false
    type = timestamptz
    default = sql("CURRENT_TIMESTAMP")
  }

  primary_key {
    columns = [column.id]
  }
  foreign_key "fk_products_category" {
    columns     = [column.category_id]
    ref_columns = [table.categories.column.id]
    on_delete   = RESTRICT
  }
  foreign_key "fk_products_warehouse" { # <--- ДОБАВИЛИ СВЯЗЬ
    columns     = [column.warehouse_id]
    ref_columns = [table.warehouses.column.id]
    on_delete   = RESTRICT
  }
  index "idx_products_slug" {
    unique = true
    columns = [column.slug]
  }
  index "idx_products_category_id" {
    columns = [column.category_id]
  }
  index "idx_products_price" {
    columns = [column.price]
  }
}