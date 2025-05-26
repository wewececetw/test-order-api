<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

# 訂單匯總與一致性檢查 API 專案說明

## 1. 動態訂單匯總 API

- **Endpoint**: `/orders/summary`
- **方法**: `GET`
- **參數**:
  - `start_date` (必填, 格式: YYYY-MM-DD)
  - `end_date` (必填, 格式: YYYY-MM-DD)
  - `category` (選填, 產品類別)
- **回傳格式**：
  - 成功：
    ```json
    [
      {
        "category": "水果",
        "total_quantity": 15,
        "total_amount": 200
      },
      ...
    ]
    ```
  - 查無資料：
    ```json
    { "message": "查無資料" }
    ```
  - 日期格式錯誤：
    ```json
    { "error": "日期格式錯誤" }
    ```

- **功能說明**：
  - 依據輸入的時間區間與類別，回傳該期間內所有訂單的類別匯總（數量與金額）。
  - 會記錄每次查詢的參數與結果筆數於日誌。
  - 若日期格式錯誤或查無資料會有友善訊息。

## 2. 訂單資料一致性檢查 API

- **Endpoint**: `/orders/consistency-check`
- **方法**: `GET`
- **回傳格式**：
  ```json
  {
    "errors": [
      "訂單 3 金額不符，明細總和 0，訂單金額 0",
      "訂單 4 項目 4 價格為負",
      "訂單 5 無明細項目"
    ],
    "status": "有異常"
  }
  ```
- **功能說明**：
  - 檢查每筆訂單明細金額總和是否等於訂單金額。
  - 檢查是否有負價格、空明細等異常。
  - 回傳所有異常訊息，若無異常則 status 為「通過」。

## 3. 測試資料（內建於程式中）
- Orders 與 OrderItems 皆以靜態陣列模擬，無需資料庫。
- 可直接呼叫 API 測試。

## 4. 高併發處理建議
- 可用快取（如 Redis）緩存熱門查詢結果。
- 部署時建議使用多進程伺服器（如 Nginx + PHP-FPM 多 worker）。
- 可加上 API Rate Limit（Laravel 內建 throttle middleware）。
- 若資料量大建議改用資料庫查詢與索引。

## 5. 如何整合一致性檢查
- 可於新增/修改訂單 API 時呼叫一致性檢查，若有異常則阻擋寫入。
- 可定期批次檢查所有訂單資料。

---

如需進一步擴充資料來源，請將靜態資料改為資料庫 Model 並執行 migration。
