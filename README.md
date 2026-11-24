# Skyweb.az

> **Digital ecosystem for a modern business** — Web/WAP platforms, SMM & analytics,
> mini-games, smart CV & autobiography builder and the SkyBot assistant.
>
> **Цифровая экосистема для современного бизнеса** — Web/WAP-платформы, SMM и аналитика,
> мини-игры, конструктор CV и автобиографии, а также ассистент SkyBot.

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)
![MariaDB](https://img.shields.io/badge/MariaDB-10.4-003545?logo=mariadb&logoColor=white)
![Apache](https://img.shields.io/badge/Apache-2.4-D22128?logo=apache&logoColor=white)
![Languages](https://img.shields.io/badge/i18n-AZ%20%7C%20EN%20%7C%20RU%20%7C%20TR-00E5FF)

---

## 📌 О проекте

**Skyweb.az** — это единая PHP-платформа, объединяющая несколько продуктов и демонстрационных
направлений:

| Направление | Что внутри |
|---|---|
| 🌐 **Web / WAP** | Адаптивный корпортивный сайт, 11 интерактивных демо-витрин (e-commerce, кафе, аптека, фитнес, образование, недвижимость и др.), PWA/Service Worker |
| 📢 **SMM и аналитика** | Модуль аналитики с графиками, контент-блоки для Social Media Marketing, управление партнёрскими брендами через админку |
| 🎮 **Мини-игры** | Игровой модуль с результатами и локальным хранением состояния |
| 📄 **CV и автобиография** | ATS-ориентированный конструктор резюме, генератор официальной автобиографии, сохранение, экспорт HTML/TXT/PDF и печать |
| 🤖 **SkyBot** | Ассистент с локальной базой знаний, многоязычными ответами и панелью управления |

Интерфейс полностью локализован на **азербайджанский, английский, русский и турецкий** языки.
Переключение синхронизируется между SSR (`?lang=`), cookie, сессией и `localStorage`.

---

## 🧰 Стек технологий

- **PHP 8.2** (CLI + Apache module), процедурный стиль, PDO
- **MariaDB 10.4** / MySQL — пользовательские аккаунты, сброс пароля, заказы
- **Apache 2.4** (XAMPP), `mod_rewrite`, `.htaccess`-защита `data/` и `uploads/`
- **JavaScript (ES6+)** — `SkyI18n`, Service Worker, canvas-графики, MediaPipe Tasks Vision (локально)
- **CSS** — адаптивная вёрстка 320–1920 px, 10 цветовых тем demos
- Хранение состояния: файловые JSON-хранилища в `data/` + `localStorage` в браузере

---

## 📂 Структура репозитория

```text
.
├── admin/                  # Админ-панель (логин, бренды, настройки)
├── api/                    # Публичные API (CV, контактная форма)
├── assets/                 # CSS, JS, шрифты
├── auth/                   # Регистрация, вход, восстановление пароля
├── config/                 # Конфигурация приложения
│   ├── config.php          # Глобальные константы, сессия, i18n
│   ├── database.php        # PDO-подключение (читает секреты)
│   ├── secrets.example.php # ШАБЛОН секретов (безопасен для GitHub)
│   └── secrets.php         # РЕАЛЬНЫЕ секреты — НЕ в Git (создайте сами)
├── data/                   # Runtime JSON + .htaccess (закрыт от веба)
├── database/               # schema.sql и setup_db.php
├── lang/                   # az.php / en.php / ru.php / tr.php
├── modules/                # cv-builder, games, analytics, web-demos
├── skybot/                 # Чат-ассистент и его админка
├── uploads/                # Пользовательские загрузки (не публикуются)
├── index.php               # Главная страница
└── README.md
```

---

## 🚀 Локальный запуск (XAMPP / PHP / MySQL)

1. **Установите** XAMPP с PHP 8.2+, Apache 2.4 и MariaDB 10.4+.
2. **Склонируйте** репозиторий в папку `htdocs/sky` (например `C:\xampp\htdocs\sky`).
3. **Создайте локальный конфиг секретов** — это обязательный шаг:

   ```powershell
   copy config\secrets.example.php config\secrets.php
   ```

   Затем откройте `config/secrets.php` и заполните:
   - `SKY_SECRET_DB_*` — хост, порт, имя БД, пользователь и пароль MySQL;
   - `SKY_SECRET_ADMIN_USER` / `SKY_SECRET_ADMIN_HASH` — логин и bcrypt-хэш администратора;
   - `SKY_SECRET_BEAUTY_PANEL_PASSWORD`, `SKY_SECRET_SKYBOT_ADMIN_PASSWORD` — пароли панелей;
   - `SKY_SECRET_CV_SALT` — случайная соль для гостевых папок CV;
   - `SKY_SECRET_PHP_CANDIDATES` / `SKY_SECRET_FFMPEG_CANDIDATES` — локальные пути к PHP/ffmpeg (можно оставить пустыми).

   Сгенерировать bcrypt-хэш можно так:

   ```powershell
   php -r "echo password_hash('YOUR_PASSWORD', PASSWORD_DEFAULT);"
   ```

4. **Создайте базу данных**:

   ```powershell
   php database\setup_db.php
   # затем импортируйте структуру:
   mysql -u root -p skyweb_db < database\schema.sql
   ```

5. **Запустите** Apache и MariaDB через панель XAMPP.
6. **Откройте** в браузере:
   - сайт — `http://localhost/sky/`
   - админ-панель — `http://localhost/sky/admin/`
   - демо-панель Sky Beauty — `http://localhost/sky/modules/web-demos/beauty-panel.php`
   - панель SkyBot — `http://localhost/sky/skybot/admin.php`

> ⚠️ После клонирования `config/secrets.php` отсутствует намеренно — скопируйте шаблон.
> Файл добавлен в `.gitignore` и никогда не должен попадать в репозиторий.

---

## 🔒 Безопасность

- Реальные пароли и локальные пути живут **только** в `config/secrets.php` (в `.gitignore`).
- `config/secrets.example.php` содержит пустые значения-заглушки и можно публиковать.
- `data/.htaccess` запрещает прямой доступ к runtime JSON, `uploads/.htaccess` — к загрузкам.
- Перед публикацией замените все пароли по умолчанию и сгенерируйте новые хэши.
- Диагностические скрипты (`phpinfo.php`, `opcache_*.php`, `scratch/`) в репозиторий не входят.

---

## 🧪 Разработка

Переключение языка: `?lang=az|en|ru|tr` на любой странице. Изменения CSS/JS подхватываются с
`?v=timestamp`, поэтому после правок используйте **Ctrl+F5**. Локальные регрессионные скрипты
находятся в `scratch/` (исключены из публикации).

---

**Made for Skyweb.az** · PHP 8.2 · MariaDB · 4 языка
