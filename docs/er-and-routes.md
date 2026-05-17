# ER 図・テーブル案・URL 設計（みんなの声辞典 / Survivor+）

`document.md` の構想に基づくグリーンフィールド向けの具体案。実装時は Laravel の命名・マイグレーションに合わせて調整する。

---

## 1. ER 図（概念モデル）

```mermaid
erDiagram
    users ||--o{ posts : writes
    users ||--o{ social_accounts : has
    users ||--o{ post_admin_actions : performs

    posts ||--o{ post_tag : tagged
    tags  ||--o{ post_tag : ""

    columns ||--o{ column_tag : ""
    tags    ||--o{ column_tag : ""

    learn_sections ||--o{ columns : contains

    users {
        bigint id PK
        string email UK
        string nickname
        string password_hash "nullable google-only"
        date birth_date
        date diagnosed_at
        json treatment_types "手術等の選択値"
        boolean privacy_consented_at
        boolean is_admin
        timestamps
    }

    social_accounts {
        bigint id PK
        bigint user_id FK
        string provider "google"
        string provider_user_id
        timestamps
    }

    posts {
        bigint id PK
        bigint user_id FK
        string slug UK "公開URL用"
        text body_original "ユーザー原文"
        text body_published "公開本文（編集・伏せ字後）nullable"
        text summary "管理者要約 nullable"
        enum status "draft pending rejected published hidden"
        text rejection_reason "nullable"
        bigint reviewed_by FK "nullable"
        timestamp reviewed_at
        timestamp published_at
        timestamps
    }

    post_tag {
        bigint post_id FK
        bigint tag_id FK
    }

    tags {
        bigint id PK
        string slug UK
        string name
        enum tag_kind "free worry age_band situation column_link learn_filter"
        bigint tag_group_id FK "nullable グループ表示用"
        int sort_order
        timestamps
    }

    tag_groups {
        bigint id PK
        string slug "worry age situation"
        string name
        int sort_order
    }

    tags }o--|| tag_groups : optional_group

    learn_sections {
        bigint id PK
        string slug UK
        string title "運動について等"
        int sort_order
        timestamps
    }

    columns {
        bigint id PK
        bigint learn_section_id FK
        string slug UK
        string title
        longtext body
        boolean is_published
        int sort_order
        timestamps
    }

    column_tag {
        bigint column_id FK
        bigint tag_id FK
    }

    post_admin_actions {
        bigint id PK
        bigint post_id FK
        bigint admin_user_id FK
        string action "approve reject edit_note"
        text note
        timestamps
    }
```

### 設計判断メモ

| 判断                                    | 理由                                                                                                         |
| --------------------------------------- | ------------------------------------------------------------------------------------------------------------ |
| `body_original` / `body_published` 分離 | 監査・再投稿と「公開文言」の責務を分ける（編集・伏せ字に対応）                                               |
| `tags.tag_kind` + `tag_groups`          | 「悩み／年齢／状況」ボタンと自由タグを同一 `tags` テーブルに載せつつ、画面別ソート・初期シードをしやすくする |
| `posts.slug`                            | 記事詳細の RESTful URL に使う                                                                                |
| `social_accounts` 別表                  | Google 以外のプロバイダを増やしやすい                                                                        |
| `learn_sections` → `columns`            | 「学んで安心」の階層（運動・食事・副作用など）を表す                                                         |
| `post_admin_actions`                    | 任意。監査ログが不要なら最初は省略し `posts.reviewed_*` のみでも可                                           |

### インデックス案

- `posts(status, published_at)` — 管理の未公開一覧・公開の新着
- `posts` の全文検索は MySQL `FULLTEXT(body_published)` またはアプリ側 LIKE（将来は専用検索エンジンも可）
- `post_tag(tag_id, post_id)` — タグ別一覧

---

## 2. テーブル一覧（カラム粒度）

### `users`

| カラム               | 型                    | 備考                                                     |
| -------------------- | --------------------- | -------------------------------------------------------- |
| id                   | bigint PK             |                                                          |
| email                | string unique         |                                                          |
| email_verified_at    | timestamp nullable    | Laravel 標準                                             |
| password             | string nullable       | Google のみのユーザーは null                             |
| nickname             | string                | 表示名（匿名）                                           |
| birth_date           | date                  | 登録要件                                                 |
| diagnosed_at         | date                  | ドキュメント「診断された日の生年月」→ 日付で統一しやすい |
| treatment_types      | json                  | `["surgery","chemo",...]` など                           |
| privacy_consented_at | timestamp             | 同意必須                                                 |
| is_admin             | boolean default false | または `role` enum                                       |
| remember_token       | string nullable       |                                                          |

### `social_accounts`

| カラム           | 型        | 備考                   |
| ---------------- | --------- | ---------------------- |
| id               | bigint PK |                        |
| user_id          | bigint FK |                        |
| provider         | string    | `google`               |
| provider_user_id | string    | provider 単位で unique |

### `posts`

| カラム           | 型                            | 備考                                                   |
| ---------------- | ----------------------------- | ------------------------------------------------------ |
| id               | bigint PK                     |                                                        |
| user_id          | bigint FK                     |                                                        |
| slug             | string unique                 | 公開時に確定でも可                                     |
| body_original    | text                          | 投稿時                                                 |
| body_published   | text nullable                 | 承認後の本文                                           |
| summary          | text nullable                 | 管理者要約                                             |
| status           | enum/string                   | `draft` `pending` `rejected` `published` `hidden` など |
| rejection_reason | text nullable                 |                                                        |
| reviewed_by      | bigint FK nullable → users.id |                                                        |
| reviewed_at      | timestamp nullable            |                                                        |
| published_at     | timestamp nullable            | 新着順                                                 |

### `tag_groups`

| カラム     | 型            | 備考                        |
| ---------- | ------------- | --------------------------- |
| id         | bigint PK     |                             |
| slug       | string unique | `worry`, `age`, `situation` |
| name       | string        | 表示名                      |
| sort_order | int           |                             |

### `tags`

| カラム       | 型                 | 備考                         |
| ------------ | ------------------ | ---------------------------- |
| id           | bigint PK          |                              |
| slug         | string unique      |                              |
| name         | string             |                              |
| tag_kind     | string             | 検索・シード・画面の出し分け |
| tag_group_id | bigint FK nullable | 悩み／年齢／状況のボタン配下 |
| sort_order   | int                |                              |

### `post_tag`（中間）

| カラム  | 型        | 備考    |
| ------- | --------- | ------- |
| post_id | bigint FK |         |
| tag_id  | bigint FK | 複合 PK |

### `learn_sections`

| カラム     | 型            | 備考 |
| ---------- | ------------- | ---- |
| id         | bigint PK     |      |
| slug       | string unique |      |
| title      | string        |      |
| sort_order | int           |      |

### `columns`

| カラム           | 型            | 備考 |
| ---------------- | ------------- | ---- |
| id               | bigint PK     |      |
| learn_section_id | bigint FK     |      |
| slug             | string unique |      |
| title            | string        |      |
| body             | longtext      |      |
| is_published     | boolean       |      |
| sort_order       | int           |      |

### `column_tag`（中間）

コラムに紐づくタグ → 記事一覧のキー（ドキュメントの「コラムのタグと紐づいた記事」）。

| カラム    | 型        | 備考    |
| --------- | --------- | ------- |
| column_id | bigint FK |         |
| tag_id    | bigint FK | 複合 PK |

### `post_admin_actions`（任意）

| カラム        | 型            | 備考                                |
| ------------- | ------------- | ----------------------------------- |
| id            | bigint PK     |                                     |
| post_id       | bigint FK     |                                     |
| admin_user_id | bigint FK     |                                     |
| action        | string        | `approve` `reject` `edit_note` など |
| note          | text nullable |                                     |
| timestamps    |               |                                     |

---

## 3. 投稿 `status` 遷移

```
draft（任意） → pending（投稿） → published（承認）
                    ↓
              rejected（掲載見送り） → ユーザー編集 → pending（再投稿）
published → hidden（管理側で非公開）
```

---

## 4. ルート一覧（URL 設計）

プレフィックスは **`/` がユーザー公開**、**`/admin` が管理者**、認証は Laravel 慣例とする。

### 公開（未ログイン可）

| メソッド | URL                                 | 画面・用途                                              |
| -------- | ----------------------------------- | ------------------------------------------------------- |
| GET      | `/`                                 | トップ                                                  |
| GET      | `/stories`                          | 物語を探す（検索・タグ・一覧のハブ）                    |
| GET      | `/stories/search`                   | キーワード検索結果（同一ページに `?q=` で統合しても可） |
| GET      | `/stories/by/worry`                 | 悩みで選ぶ（大項目一覧）                                |
| GET      | `/stories/by/worry/{slug}`          | 大項目別一覧                                            |
| GET      | `/stories/by/age`                   | 年齢で選ぶ                                              |
| GET      | `/stories/by/age/{slug}`            | 例: `30s`, `40s`                                        |
| GET      | `/stories/by/situation`             | 状況で選ぶ                                              |
| GET      | `/stories/by/situation/{slug}`      | 子育て・仕事・介護など                                  |
| GET      | `/stories/tags/{slug}`              | タグ絞り込み一覧                                        |
| GET      | `/stories/{slug}`                   | 記事詳細（公開済みのみ）                                |
| GET      | `/learn`                            | 学んで安心（セクション一覧）                            |
| GET      | `/learn/{sectionSlug}`              | セクション内コラム一覧                                  |
| GET      | `/learn/{sectionSlug}/{columnSlug}` | コラム本文＋関連記事                                    |

REST とブックマーク性を優先するなら上記のパス分割が扱いやすい。`/stories` にクエリだけ載せる簡略案もあり。

### 認証

| メソッド | URL                     | 用途                 |
| -------- | ----------------------- | -------------------- |
| GET      | `/register`             | ユーザー登録フォーム |
| POST     | `/register`             | 登録処理             |
| GET      | `/login`                | ログイン             |
| POST     | `/login`                |                      |
| POST     | `/logout`               | ログアウト           |
| GET      | `/auth/google/redirect` | Google OAuth 開始    |
| GET      | `/auth/google/callback` | Google コールバック  |

### ログイン必須（一般ユーザー）

| メソッド  | URL                   | 用途                       |
| --------- | --------------------- | -------------------------- |
| GET       | `/share`              | 物語のシェア（入力）       |
| POST      | `/share`              | 投稿送信 → `pending`       |
| GET       | `/me/posts`           | 自分の投稿一覧             |
| GET       | `/me/posts/{id}/edit` | 掲載見送り後の編集・再投稿 |
| PUT/PATCH | `/me/posts/{id}`      | 更新（再投稿フロー）       |

### 管理者（`auth` + `admin` ミドルウェア）

| メソッド  | URL                                       | 用途                                     |
| --------- | ----------------------------------------- | ---------------------------------------- |
| GET       | `/admin`                                  | ダッシュボード（任意）                   |
| GET       | `/admin/posts`                            | 未公開・全件フィルタ一覧                 |
| GET       | `/admin/posts/{id}`                       | 確認・編集フォーム                       |
| PUT/PATCH | `/admin/posts/{id}`                       | 本文・要約・伏せ字・タグ保存             |
| POST      | `/admin/posts/{id}/publish`               | 公開                                     |
| POST      | `/admin/posts/{id}/unpublish`             | 非公開／掲載停止                         |
| POST      | `/admin/posts/{id}/reject`                | 掲載見送り（理由必須）                   |
| GET       | `/admin/tags`                             | タグ管理（任意・初期はシードのみでも可） |
| CRUD      | `/admin/tags`, `/admin/tags/{id}`         | タグの追加・並び（必要なら）             |
| CRUD      | `/admin/learn/sections`, `/admin/columns` | コラム管理（必要に応じて）               |

### API（将来）

モバイルや別クライアント用は `/api/v1/...` を別途。Blade 中心の MVP では不要。

---

## 5. `document.md` との整合メモ

- UI 文言「物語を探す」「物語を読む」の表記ゆれは、ルートは `/stories` に一本化しラベルのみ揃えるとよい。
- アプリ名は表示で **みんなの声辞典** に統一（「みんなの声時点」は誤記の可能性）。

---

## 改訂履歴

| 日付       | 内容                                                      |
| ---------- | --------------------------------------------------------- |
| 2026-05-02 | 初版（ER・テーブル・ルートを `document.md` に基づき整理） |
