# lolipop へのデプロイ手引き

共有レンタルサーバー上での一般的な手順です。契約プラン・パネルによって細部は異なるため、lolipop の最新マニュアルもあわせて確認してください。

## 1. 前提確認

- PHP バージョンが Laravel 要件（本プロジェクトは **PHP 8.3+**）を満たすこと。
- MySQL が利用できること。
- **公開ディレクトリ** を Laravel の `public` に向けられること（ドキュメントルートを `public` に設定、または `public` 内にエントリポイントを置く）。

## 2. アップロード

Git が使える場合はサーバー上で `git clone` → `composer install --no-dev --optimize-autoloader` を推奨します。FTP の場合はプロジェクト一式をアップロードし、`vendor` はサーバー上で `composer install` した方が確実です。

## 3. 環境変数（`.env`）

本番用に `.env` を作成または編集します。

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://あなたのドメイン`
- `DB_*` を lolipop の MySQL 情報に合わせる。
- メール（パスワードリセット等を使う場合）: `MAIL_*`
- Google OAuth 利用時: `GOOGLE_CLIENT_ID` / `GOOGLE_CLIENT_SECRET` / `GOOGLE_REDIRECT_URI`（例: `https://あなたのドメイン/auth/google/callback` を Google Cloud Console に登録）

```bash
php artisan key:generate
php artisan migrate --force
```

シーダーは本番では **管理者のみ** など最小限にするか、初回のみ実行してから削除してください。

## 4. 最適化

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

フロントはローカルまたは CI で `npm ci && npm run build` し、`public/build` をデプロイに含めます。

## 5. キュー・スケジューラ

メールやキューを `database` ドライバで使う場合、共有サーバーでは **cron** で `php artisan schedule:run` を定期実行する構成が一般的です。常駐ワーカーが使えないプランでは、まずはメールを同期送信（`QUEUE_CONNECTION=sync`）にして動作確認する方法もあります。

## 6. HTTPS

証明書（Let's Encrypt 等）を有効にし、`APP_URL` を `https://` に揃えます。

## 7. バックアップ

MySQL のダンプ（phpMyAdmin や `mysqldump`）と、`storage/app` にユーザー生成ファイルを置く場合はそのディレクトリのバックアップ方針を決めてください。
