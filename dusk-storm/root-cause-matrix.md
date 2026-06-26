# STORM: Root Cause Matrix (Системные факторы)

## Категория: Chrome/WebDriver configuration

| Признак | Как проверить | Статус | Влияние |
|---------|---------------|--------|---------|
| `--no-sandbox` отсутствует в ChromeOptions | Options.php строка 46-49 | ✅ **Добавлен** (commit 4b87ec805) | Исправлено |
| `--disable-dev-shm-usage` отсутствует | Options.php строка 46-49 | ✅ **Добавлен** (commit 4b87ec805) | Исправлено |

## Категория: CI Workflow

| Признак | Как проверить | Статус | Влияние |
|---------|---------------|--------|---------|
| Vite/NPM build выполнен | `.github/workflows/phpunit.yml` | ✅ **Добавлен** | **ВЫСОКОЕ** — JS-бандлы свежие |
| Readiness check сервера | workflow | 🔴 **Нет** | **СРЕДНЕЕ** — Нет гарантии, что сервер отвечает |
| Screenshots загружаются | artifact ID 7894057637 | 🟡 **Малый размер** | **СРЕДНЕЕ** |
| Console-логи сохраняются | workflow | ✅ **Есть** | — |
| Asset publishing в testbench | `vendor/bin/testbench-dusk orchid:publish` | ✅ **Добавлен** | **КРИТИЧЕСКОЕ** — Assets в `/vendor/orchid/` |

## Категория: Asset Loading (SRI / Vite)

| Признак | Как проверить | Статус | Влияние |
|---------|---------------|--------|---------|
| SRI integrity hash совпадает с файлом | Browser console | 🔴 **Не совпадал** | **КРИТИЧЕСКОЕ** — JS блокируется браузером |
| Vite build output vs Orchid::vite() path | vite.config.js vs ManagesResources.php | 🟡 **Разные пути** | **ВЫСОКОЕ** — Без publish assets недоступны |
| Asset publishing в CI | workflow | 🔴 **Отсутствовал** | **ВЫСОКОЕ** — В CI тесты не находят JS/CSS |

## Категория: Окружение/Envs

| Признак | Как проверить | Статус | Влияние |
|---------|---------------|--------|---------|
| APP_KEY — base64? | phpunit.xml | ✅ **base64** (f38d15102) | Исправлено |
| APP_URL совпадает с портом | phpunit.xml vs DuskServer | ✅ **Совпадает** | **НЕТ** |
| SESSION_DRIVER=file | phpunit.xml | 🟡 Файловый | **НИЗКОЕ** |

## Категория: PHP 8.5 совместимость

| Признак | Как проверить | Статус | Влияние |
|---------|---------------|--------|---------|
| `array_push()` с named parameters | MessageBag.php:246 | 🔴 **Ошибка в PHP 8.5** | **КРИТИЧЕСКОЕ** — 500 error на PHP 8.5 |

## Сводная матрица

| Категория | Кол-во проблем | Max приоритет |
|-----------|---------------|---------------|
| Chrome/WebDriver | 2 | ✅ S1 (исправлено) |
| CI Workflow | 2 | ✅ S1 (исправлено) |
| Asset Loading (SRI/Vite) | 3 | 🔴 S1 (исправлено) |
| Окружение/Envs | 1 | ✅ S2 (исправлено) |
| PHP 8.5 совместимость | 1 | 🟡 S2 (требуется фикс в Laravel) |
