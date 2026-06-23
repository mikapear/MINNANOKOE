# MINNANOKOE（Survivor+）

がん経験者の声をタグ付きで共有・検索する Laravel + MySQL の Web アプリです。要件は [document.md](document.md)、DB/URL 設計は [docs/er-and-routes.md](docs/er-and-routes.md) を参照してください。

## 環境

- PHP 8.3+、Composer、Node.js（Vite 用）
- データベース: **MySQL**（本番は lolipop 想定）
- ローカル推奨: [Laravel Sail](https://laravel.com/docs/sail) または MySQL コンテナ

### クイックスタート（ホストの PHP + MySQL 例）

```bash
cp .env.example .env
php artisan key:generate
# .env の DB_* を環境に合わせる
php artisan migrate --seed
npm install && npm run build
php artisan serve
```

### 管理者（シード）

[DatabaseSeeder](database/seeders/DatabaseSeeder.php) で管理者を作成します。`.env` で上書き可能です。

- `ADMIN_SEED_EMAIL`（デフォルト: `admin@minnanokoe.test`）
- `ADMIN_SEED_PASSWORD`（デフォルト: `password`）

### Google ログイン

`.env` に `GOOGLE_CLIENT_ID` / `GOOGLE_CLIENT_SECRET` / `GOOGLE_REDIRECT_URI`（例: `http://localhost/auth/google/callback`）を設定すると、ログイン画面に「Google でログイン」が表示されます。

## テスト

```bash
php artisan test
```

PHPUnit は `phpunit.xml` で SQLite（メモリ）を使うようになっています。

## 本番（lolipop）

[docs/DEPLOY_LOLIPOP.md](docs/DEPLOY_LOLIPOP.md) を参照してください。
