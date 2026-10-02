# Contributing to Reyhan Commerce Installer (`reyhan-commerce/installer`)

Thank you for contributing to the CLI installer for **Reyhan Commerce**!

---

## 🏛️ Development Guidelines

1. **Strict Types**: `declare(strict_types=1);` is required in every PHP file.
2. **Prompts & Console**: New commands must extend `Symfony\Component\Console\Command\Command` and use `Laravel\Prompts` for clean terminal interaction.
3. **Template Preservation**: Keep `template/` clean, minimal, and aligned with `reyhan-commerce/reyhan`.
4. **All Documentation in English**: Write all documentation, commit messages, and comments in English.

---

## 🛠️ Testing Locally

```bash
# Clone the repository
git clone https://github.com/reyhan-commerce/installer.git
cd installer

# Install local dependencies
composer install

# Run the local binary
php bin/reyhan --version
```

---

## 🌿 Pull Requests

1. Fork the repo and create a feature branch (`git checkout -b feature/interactive-flag`).
2. Commit your changes with clear messages.
3. Push to your fork and submit a PR against `main`.
4. Ensure all GitHub Actions CI checks pass.
