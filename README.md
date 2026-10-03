<div align="center">

<img src="art/banner.png" alt="Reyhan Commerce Installer" width="780" style="max-width: 100%; border-radius: 12px; margin-bottom: 24px;" />

# 🌿 Reyhan Commerce Installer (`reyhan-commerce/installer`)

### The Official CLI Scaffolding Tool for Reyhan Commerce Framework
**Quickly scaffold production-ready headless e-commerce stores with interactive Laravel Prompts**

[![License: MIT](https://img.shields.io/badge/License-MIT-emerald.svg)](LICENSE)
[![Latest Version](https://img.shields.io/packagist/v/reyhan-commerce/installer.svg?style=flat-square)](https://packagist.org/packages/reyhan-commerce/installer)
[![Documentation](https://img.shields.io/badge/Docs-Live%20Website-10b981.svg)](https://reyhan-commerce.github.io/docs/)

</div>

---

## 🚀 Installation

Install the Reyhan CLI installer globally via Composer:

```bash
composer global require reyhan-commerce/installer
```

Ensure your Composer global `bin` directory is in your system's `$PATH`:
- **Linux / macOS**: `~/.config/composer/vendor/bin` or `~/.composer/vendor/bin`
- **Windows**: `%USERPROFILE%\AppData\Roaming\Composer\vendor\bin`

Verify installation:
```bash
reyhan --version
```

---

## 🛠️ Scaffolding a New Store

To scaffold a new Reyhan headless commerce application, execute:

```bash
reyhan new my-store
```

The interactive terminal wizard powered by **Laravel Prompts** will guide you through:
1. **Database Engine**: Choose between **PostgreSQL 17+** (recommended for native JSONB & trigram indexing), MySQL 8.0+, or SQLite.
2. **Catalog Seeding**: Optionally seed the comprehensive Iranian commerce demo catalog (provinces, cities, categories, products, inventory variants).
3. **Environment Setup**: Automatically configures `.env`, generates application keys, installs composer dependencies, and executes database migrations.

---

## 🤖 Non-Interactive / CI/CD Automation

You can skip interactive questions in CI pipelines, Docker builds, or scripted deployments:

```bash
# Provision with PostgreSQL and seed demo catalog non-interactively
reyhan new my-store --pgsql --seed --no-interaction

# Provision for rapid local testing with SQLite
reyhan new test-store --sqlite --seed --no-interaction

# Overwrite existing folder
reyhan new my-store --pgsql --force
```

### Supported CLI Flags

| Flag | Description |
| :--- | :--- |
| `--pgsql` | Configure PostgreSQL as the primary database engine |
| `--mysql` | Configure MySQL / MariaDB as the primary database engine |
| `--sqlite` | Configure SQLite for rapid local prototyping |
| `--seed` | Automatically run migrations and seed demo data |
| `-f, --force` | Overwrite destination directory if it already exists |
| `--no-interaction` | Bypass all interactive prompts with default values |

---

## ⚡ Direct Composer Alternative

If you prefer not to install global binaries, you can create a new store directly using Composer:

```bash
composer create-project reyhan-commerce/reyhan my-store
```

---

## 📚 Ecosystem Repositories

| Repository | Purpose | Packagist / Link |
| :--- | :--- | :--- |
| **`reyhan-commerce/installer`** | Composer Global CLI Scaffolder | [`reyhan-commerce/installer`](https://packagist.org/packages/reyhan-commerce/installer) |
| **`reyhan-commerce/core`** | Framework Core Library | [`reyhan-commerce/core`](https://packagist.org/packages/reyhan-commerce/core) |
| **`reyhan-commerce/reyhan`** | Starter Application Skeleton | [`reyhan-commerce/reyhan`](https://packagist.org/packages/reyhan-commerce/reyhan) |
| **`reyhan-commerce/storefront-nuxt`** | Nuxt 4 Commercial Storefront | [GitHub Repository](https://github.com/reyhan-commerce/storefront-nuxt) |
| **`reyhan-commerce/docs`** | Official VitePress Docs Site | [Live Documentation](https://reyhan-commerce.github.io/docs/) |

---

## 🤝 Contributing

Contributions are welcome! Please see [CONTRIBUTING.md](CONTRIBUTING.md) and [AGENTS.md](AGENTS.md) for architecture guidelines.

---

## 📄 License

Reyhan Commerce Installer is open-sourced software licensed under the [MIT license](LICENSE).
