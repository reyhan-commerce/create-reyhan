# Reyhan Commerce Installer

The official Composer CLI installer for **Reyhan Commerce** — the sovereign, full-stack headless e-commerce framework for Iran.

---

## 🚀 Installation

Install the Reyhan CLI globally via Composer:

```bash
composer global require reyhan-commerce/installer
```

Ensure your global Composer `bin` directory is in your system's `$PATH`:
- **macOS / Linux**: `~/.config/composer/vendor/bin` or `~/.composer/vendor/bin`
- **Windows**: `%USERPROFILE%\AppData\Roaming\Composer\vendor\bin`

---

## 🛠️ Creating a New Project

To scaffold a new Reyhan headless commerce application, run:

```bash
reyhan new my-store
```

The interactive wizard powered by **Laravel Prompts** will guide you through:
1. Selecting your primary database engine (**PostgreSQL 17+** recommended, MySQL, SQLite).
2. Choosing whether to seed the initial Iranian commerce demo catalog (provinces, cities, cosmetics/fashion categories, sample products).
3. Automatic environment provisioning, application key generation, and database migrations.

### Non-Interactive / Automation Flags

You can bypass interactive prompts in CI/CD pipelines or automated provisioning:

```bash
# Provision with PostgreSQL and automatic demo catalog seed
reyhan new my-store --pgsql --seed --no-interaction

# Provision with SQLite for local rapid prototyping
reyhan new test-store --sqlite --seed --no-interaction
```

---

## ⚡ Direct Composer Create-Project

If you prefer not to install the global CLI, you can create a new Reyhan project directly via Composer:

```bash
composer create-project reyhan-commerce/reyhan my-store
```

---

## 📖 Documentation

For full guides and architecture specifications, visit the [Reyhan Commerce Documentation Portal](https://reyhan.io/docs).

---

## 📄 License

Reyhan Commerce Installer is open-sourced software licensed under the [MIT license](LICENSE).
