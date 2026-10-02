# AI Coding Agent Directives — Reyhan Commerce Installer (`reyhan-commerce/installer`)

This document governs AI coding agents inspecting, maintaining, or modifying the `reyhan-commerce/installer` package.

---

## 🏛️ Invariants & Rules

1. **Strict Types Mandatory**:
   - Every PHP file must declare `declare(strict_types=1);` at the top.
   - All method arguments, return types, and class properties must have explicit type declarations.

2. **Symfony Console & Laravel Prompts**:
   - The CLI uses Symfony Console components (`Symfony\Component\Console\Command\Command`) combined with `Laravel\Prompts` for modern terminal UX.
   - Always support both interactive mode (prompts) and headless automation (`--no-interaction`, explicit flags like `--pgsql`, `--sqlite`, `--seed`, `--force`).

3. **Template Directory Sync**:
   - The scaffolding files reside in `template/`.
   - The template is a root-level Laravel application consuming `reyhan-commerce/core`.
   - Ensure the template remains in sync with the canonical `reyhan-commerce/reyhan` repository structure.
   - The installer must never create obsolete nested layouts like `backend/backend/`.

4. **English Only**:
   - All prompts, outputs, logs, code comments, and documentation must be written in English.

---

## 🛠️ Verification Commands

```bash
# Validate composer configuration
composer validate --strict

# Test CLI binary execution
php bin/reyhan --version
php bin/reyhan list
```
