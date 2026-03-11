# 🐳 Multi-Version PHP Docker Environment (Legacy & Modern)

![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)
![Nginx](https://img.shields.io/badge/nginx-%23009639.svg?style=for-the-badge&logo=nginx&logoColor=white)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![Redis](https://img.shields.io/badge/redis-%23DD0031.svg?style=for-the-badge&logo=redis&logoColor=white)

> An agile development environment, orchestrated to support the peaceful coexistence of *legacy* and modern systems on the same host machine — conflict-free.

---

## 🎯 The Problem

Many engineering teams deal with complex ecosystems where modern microservices and *legacy* monoliths need to run simultaneously. Running multiple PHP versions (such as 5.6 and 7.0) natively on the same development machine leads to:

- ⚡ Port conflicts
- 🔀 Environment variable collisions
- 💥 Library compatibility errors

On top of that, recreating *legacy* environments often runs into **discontinued Linux repositories** (Debian Archive) and **expired GPG keys**, slowing down the onboarding of new developers.

---

## 💡 The Solution

This repository provides a **100% containerized** local infrastructure (*Zero Touch Provisioning*). The architecture orchestrates:

- Independent **PHP-FPM** containers, fully isolated per version
- An **Nginx** instance acting as a *reverse proxy*
- **Shared cache services** (Redis and Memcached)

### ✨ Key Features

| Feature | Description |
|---|---|
| 🐘 **Multiple PHP Versions** | PHP 5.6 and PHP 7.0 running side by side |
| 🏗️ **Legacy Engineering** | Docker images refactored to use `archive.debian.org`, with advanced workarounds for expired GPG keys and dependency hell (Zlib) on Debian Jessie/Stretch |
| 🔀 **Smart Routing** | Nginx configured with *Virtual Hosts* to route local domains (`.test`) to the corresponding PHP container |
| ⚡ **Integrated Cache** | Redis and Memcached compiled via PECL with pinned versions to ensure compatibility with each PHP engine |
| 🔒 **Configuration Isolation** | `.env` file to avoid hardcoding ports and directory paths |

---

## 📁 Project Structure

```
docker-php-multiversion/
│
├── docker/
│   ├── nginx/
│   │   └── default.conf        # Virtual Hosts config (reverse proxy routing)
│   ├── php56/
│   │   ├── Dockerfile          # PHP 5.6 image (Debian Jessie + legacy fixes)
│   │   └── php.ini             # PHP 5.6 runtime configuration
│   └── php70/
│       ├── Dockerfile          # PHP 7.0 image (Debian Stretch + legacy fixes)
│       └── php.ini             # PHP 7.0 runtime configuration
│
├── src/
│   ├── app-legacy/
│   │   └── public/
│   │       └── index.php       # Entry point for the legacy application
│   └── app-modern/
│       └── public/
│           └── index.php       # Entry point for the modern application
│
├── .gitignore
├── .env.example                # Environment variables template
├── docker-compose.yml          # Service orchestration definition
└── README.md
```

---

## 🚀 Getting Started

### 1. Prerequisites

- [Docker](https://docs.docker.com/get-docker/) installed
- [Docker Compose](https://docs.docker.com/compose/install/) installed

### 2. Environment Setup

Clone the repository and create your environment variables file:

```bash
git clone https://github.com/YOUR-USERNAME/docker-php-multiversion.git
cd docker-php-multiversion
cp .env.example .env
```

> Open the `.env` file and set the path where your projects live on your local machine (`PROJECTS_ROOT_PATH`).

### 3. Local DNS Configuration

So that Nginx can capture incoming requests, add the test domains to your operating system's hosts file:

- **Linux/macOS:** `/etc/hosts`
- **Windows:** `C:\Windows\System32\drivers\etc\hosts`

```
127.0.0.1    app-legacy.test app-modern.test
```

### 4. Start the Infrastructure

From the project root, run the build and start command:

```bash
docker compose up -d --build
```

> Docker will optimally build the images (internally fixing the legacy Debian repositories) and bring all services up.

### 5. Validation

Open your browser and navigate to:

| URL | Service |
|---|---|
| [http://app-legacy.test](http://app-legacy.test) | Routed to **PHP 5.6** |
| [http://app-modern.test](http://app-modern.test) | Routed to **PHP 7.0** |
