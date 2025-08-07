## 環境構築 nakanosaori-kadai-1

**Docker ビルド**

1. `git clone git@github.com:n-saori-code/nakanosaori-kadai-1.git`
2. DockerDesktop アプリを立ち上げる
3. `docker-compose up -d --build`

<build に失敗する場合>
docker-compose.yml に記入されている platform: linux/amd64 を削除してください。
記載場所：nginx、php、mysql、phpmyadmin
Dockerfile を以下に変更してください。
FROM --platform=linux/amd64 php:8.1-fpm を FROM php:8.1-fpm に変更。

**Laravel 環境構築**

1. `docker-compose exec php bash`
2. `composer install`
3. 「.env.example」ファイルを コピーして「.env」を作成し、DB の設定を変更

```text
DB_HOST=mysql
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

5. アプリケーションキーの作成

```bash
php artisan key:generate
```

6. マイグレーションの実行

```bash
php artisan migrate
```

7. シーディングの実行

```bash
php artisan db:seed
```

## ER 図

![ER図](.drawio.png)

## URL

- 開発環境：http://localhost
- phpMyAdmin:：http://localhost:8080
