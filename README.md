# 🎬 App Movie Choice

Une application web Symfony 7.1.5 permettant de proposer **aléatoirement des films** en fonction de **filtres personnalisés** ou **sans filtre** du tout. Les données sont récupérées depuis l'API [TMDB](https://developer.themoviedb.org/reference/discover-movie).

---

## 🚀 Fonctionnalités principales

- 🎲 Propose un film au hasard selon des critères définis (ou pas du tout)
- 🔍 Filtrage précis via formulaire : langue, genres, notes, certifications, etc.
- 🧠 Affinage des résultats via un handler évolutif (`MovieRefinerHandler`)
- 🎥 Détails enrichis pour chaque film :
  - Casting principal
  - Réalisateur
  - Bandes-annonces
  - Plateformes de visionnage (VOD)
  - Images, avis, vidéos, etc.
- ⚙️ Backend propulsé par Symfony +
