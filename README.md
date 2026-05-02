# AP-Corse — Documentation GSB

> Projet réalisé dans le cadre de l'**AP SIO 2** — Région Corse — 2025/2026
>
> **Matthieu Doolaeghe · Wassil Henni · Lucas Deudon**

---

## 📋 Présentation

Ce dépôt regroupe trois applications interconnectées autour d'un système de gestion RH pour le réseau **GSB (Groupement de Santé de Corse)**. Chaque mission correspond à une application distincte, toutes reliées à la même base de données MySQL.

---

## 🗂️ Missions

### Mission 1 — [GSBCongés](./GSBCongés)
> Application Desktop **C# / Windows Forms / Dapper**

Gestion des demandes de congé des praticiens.

- Authentification par email + mot de passe (routage selon le rôle)
- Interface **praticien** : sélection des dates, contrôle du solde restant, soumission
- Interface **RH** : DataGridView filtrable (En attente / Accepté / Refusé), acceptation et refus via transaction SQL

**Stack :** C# · .NET · WinForms · Dapper · MySQL

---

### Mission 2 — [GSBSalaires](./GSBSalaires)
> Application Web **Laravel / PHP / Blade / Tailwind CSS**

Système RH central avec gestion des praticiens et de la grille salariale.

- Authentification par session (SHA-256 + HMAC) via middleware dédié
- Liste des praticiens avec filtres avancés, tri et pagination
- Grille salariale automatisée via trigger SQL (ancienneté → échelon → salaire)
- Page de statistiques : total praticiens, salaire moyen, masse salariale

**Stack :** PHP · Laravel · MySQL · Blade · Tailwind CSS

---

### Mission 3 — [GSBNotes](./GSBNotes)
> Application Mobile **Flutter / Dart** — multi-plateforme

Consultation et notation des praticiens du réseau GSB.

- Liste des praticiens avec recherche et tri en temps réel
- Fiche détaillée avec notes clients et experts
- Soumission de nouvelles évaluations (commentaire + score)
- Authentification JWT via l'API GSBSalaires

**Stack :** Flutter · Dart · JWT · API REST

---

## 🌐 Infrastructure réseau

| Rôle | Adresse IPv4 |
|------|-------------|
| Serveur Web (Laravel) | `172.23.80.1` |
| Serveur BDD (MySQL) | `172.23.80.2` |
| Serveur de Production | `172.23.80.11` |
| Poste développeur 1 | `172.23.80.9` |
| Poste développeur 2 | `172.23.80.10` |
| Poste développeur 3 | `172.23.80.12` |

---

## 🔗 Schéma d'intégration

```
┌─────────────────────┐        ┌──────────────────────────┐
│   GSBCongés (C#)    │        │    GSBNotes (Flutter)    │
│   Desktop Windows   │        │  Mobile / Multi-platform │
└────────┬────────────┘        └────────────┬─────────────┘
         │ SQL direct                        │ HTTP REST + JWT
         │                                   │
         ▼                                   ▼
┌─────────────────────────────────────────────────────────┐
│              MySQL — 172.23.80.2 — BDD gsb              │
│                                                         │
│     utilisateurs · conges · praticien · grille          │
│     salariale · ville · departement · type_praticien    │
└────────────────────────────┬────────────────────────────┘
                             │ Eloquent ORM
                             ▼
                  ┌───────────────────────┐
                  │  GSBSalaires (Laravel) │
                  │  172.23.80.1          │
                  │  Web UI + API REST    │
                  └───────────────────────┘
```

---

## 📊 État d'avancement

| Mission | Application | Statut |
|---------|-------------|--------|
| Mission 0 | Infrastructure réseau | ✅ Terminé |
| Mission 1 | GSBCongés (C#) | ✅ Terminé |
| Mission 2 | GSBSalaires (Laravel) | ✅ Terminé |
| Mission 3 | GSBNotes (Flutter) | ✅ Terminé |

---

*Copyright © 2025 · AP-Corse · Matthieu Doolaeghe, Wassil Henni & Lucas Deudon*
