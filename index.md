---
icon: lucide/rocket
---

# Accueil

## Introduction

Ceci est la documentation officielle des missions **AP SIO 2** pour la région Corse — année scolaire **2025-2026**.

Réalisée par **Matthieu Doolaeghe**, **Wassil Henni** et **Lucas Deudon**.

Ce projet comprend trois applications interconnectées autour d'un système de gestion RH pour le réseau **GSB (Groupement de Santé de Corse)**. Ces applications partagent la même base de données MySQL et le même domaine métier : la gestion des praticiens de santé.

---

## Infrastructure réseau (Mission 0)

Mise en place d'une infrastructure réseau simple. Tableau récapitulatif des rôles et adresses IP :

| Rôle | Adresse IPv4 |
|---------|--------------|
| Serveur Web (Laravel) | 172.23.80.1 |
| Serveur BDD (MySQL) | 172.23.80.2 |
| Serveur de Production | 172.23.80.11 |
| Poste développeur 1 | 172.23.80.9 |
| Poste développeur 2 | 172.23.80.10 |
| Poste développeur 3 | 172.23.80.12 |

---

## Vue d'ensemble des missions

### Mission 1 — GSBCongés (Application Desktop C#)

Application **Windows Forms (.NET / Dapper)** permettant la gestion des demandes de congé :
- Authentification par **email + mot de passe** avec routage selon le rôle (`praticien` ou RH)
- Les praticiens soumettent des demandes de congé avec sélection des dates et contrôle du solde restant
- Le RH consulte toutes les demandes via un **DataGridView** filtrable (En attente / Accepté / Refusé)
- Acceptation et refus des congés via **transactions SQL** Dapper
- Le RH peut également accéder à l'interface praticien pour poser ses propres congés

[Voir la documentation complète →](mission1.md)

---

### Mission 2 — GSBSalaires (Application Web Laravel)

Application web **Laravel / PHP** servant de système RH central :
- Interface web **Blade + Tailwind CSS** pour le service RH
- Authentification par **session** (SHA-256 + HMAC) via un middleware dédié
- Gestion des praticiens : informations, filtres avancés, tri, pagination
- Grille salariale avec **trigger SQL** (ancienneté → échelon → salaire)
- Page de statistiques : total praticiens, salaire moyen, masse salariale, répartition par type et échelon

[Voir la documentation complète →](mission2.md)

---

### Mission 3 — GSBNotes (Application Mobile Flutter)

Application **Flutter / Dart** multi-plateforme (Android, iOS, Windows…), tout le code dans un seul fichier <code>main.dart</code> :
- Annuaire des praticiens avec **recherche locale** (nom ou type) et **tri API** (nom / note expert / note client)
- Tuiles avec badge de type coloré selon le type de praticien, notes expert et client inline, note globale sur 5
- Page de détail : SliverAppBar défilant, cartes de score avec étoiles, onglets Experts / Clients
- Gestion des états : chargement, erreur réseau avec bouton Réessayer, pull-to-refresh

[Voir la documentation complète →](mission3.md)

---

## Schéma d'intégration

```
┌─────────────────────┐        ┌──────────────────────────┐
│   GSBCongés (C#)     │        │     GSBNotes (Flutter)    │
│   Desktop Windows   │        │  Mobile / Multi-platform │
└────────┬────────────┘        └────────────┬─────────────┘
         │ SQL direct                        │ HTTP REST + JWT
         │                                   │
         ▼                                   ▼
┌─────────────────────────────────────────────────────────┐
│              MySQL — 172.23.80.2 — BDD gsb              │
│                                                         │
│  praticien · congé · connexion · note · notification    │
│  echelon · ville · expert · etat · etat_lecture         │
└────────────────────────────┬────────────────────────────┘
                             │ Eloquent ORM
                             ▼
                  ┌─────────────────────┐
                  │    GSBSalaires (Laravel)  │
                  │    172.23.80.1      │
                  │  API REST + Web UI  │
                  └─────────────────────┘
```

---

✍️ *Projet réalisé dans le cadre de l'AP-Corse.*
***Matthieu Doolaeghe, Wassil Henni & Lucas Deudon***
