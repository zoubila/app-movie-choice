# 🎬 App Movie Choice

> 🇫🇷 Application Symfony pour suggérer des films aléatoires filtrés ou non  
> 🇬🇧 Symfony app that randomly suggests movies, with or without filters

---

## 📖 Sommaire | Table of Contents

- [🇫🇷 Français](#-français)
  - [Fonctionnalités](#fonctionnalités)
  - [Stack technique](#stack-technique)
  - [Installation](#installation)
  - [Configuration](#configuration)
  - [Accès](#accès)
  - [Commandes utiles](#commandes-utiles)
  - [Structure du projet](#structure-du-projet)
  - [Logique API TMDB](#logique-api-tmdb)
  - [Roadmap](#roadmap)
  - [Auteur](#auteur)
- [🇬🇧 English](#-english)
  - [Features](#features)
  - [Tech Stack](#tech-stack)
  - [Installation](#installation-1)
  - [Configuration](#configuration-1)
  - [Access](#access)
  - [Useful Commands](#useful-commands)
  - [Project Structure](#project-structure)
  - [TMDB Logic](#tmdb-logic)
  - [Roadmap](#roadmap-1)
  - [Author](#author)

---

## 🇫🇷 Français

### ✅ Fonctionnalités

- 🎲 Propose des films au hasard selon des filtres ou sans filtre
- 🎛️ Formulaire de sélection avancé : langue, genres, notes, années...
- 🎥 Détails enrichis : casting, réalisateur, bande-annonce, VOD
- 🔌 Connexion à l'API TMDB
- 🖼️ Interface moderne avec Bootstrap + Webpack Encore

---

### 🛠 Stack technique

- Symfony 7.1.5 / PHP 8.3
- Docker (Apache + PHP + MySQL)
- Webpack Encore (Sass, JS, Babel)
- Bootstrap 5.3.3 / Icons
- API TMDB via Guzzle
- Doctrine ORM / Twig

---

### 📦 Installation

```bash
git clone https://github.com/zoubila/app-movie-choice.git
cd app-movie-choice

docker compose up -d --build
docker compose exec web composer install
docker compose exec web npm install
docker compose exec web npm run build
