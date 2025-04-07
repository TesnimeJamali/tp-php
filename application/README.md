# Gestion des Étudiants et Sections

Ce projet permet de gérer les étudiants et les sections d'une faculté. Il comprend des fonctionnalités pour ajouter, modifier, supprimer et afficher les informations des étudiants et des sections. Il est également possible d'exporter les données des sections au format CSV, XLSX, ou PDF.

## Fonctionnalités

- **Gestion des étudiants** : Ajouter, modifier, supprimer et afficher les informations des étudiants (nom, prénom, date de naissance, section).
- **Gestion des sections** : Ajouter, modifier, supprimer et afficher les sections de la faculté.
- **Rôles utilisateurs** : Il y a deux types d'utilisateurs dans ce projet :
  - **Utilisateur normal** : Peut uniquement visualiser les informations des étudiants et des sections.
  - **Administrateur** : Dispose de permissions étendues et peut effectuer toutes les opérations CRUD (Créer, Lire, Mettre à jour, Supprimer) sur les étudiants et les sections.

## Prérequis

Avant de commencer, assurez-vous que vous avez installé les éléments suivants :

- **PHP** (version 7.4 ou plus récente)
- **MySQL** (version 5.7 ou plus récente)
- **Composer** pour installer les dépendances PHP
- **XAMPP** ou tout autre serveur local compatible avec PHP et MySQL

## Installation

### 1. Cloner le dépôt
Clonez ce projet en local :

```bash
git clone <url-du-dépôt>
cd <nom-du-dossier>
2. Configurer la base de données
Créez une base de données dans MySQL (par exemple : user_management).

Importez le fichier SQL qui se trouve dans le projet pour créer les tables nécessaires.

3. Configurer les informations de connexion à la base de données
Dans le fichier db.php, vous devrez configurer vos informations de connexion à la base de données MySQL.

Ouvrez db.php.

Modifiez les variables suivantes avec vos propres informations :

$host = 'localhost';       // Hôte de la base de données (souvent localhost)
$dbname = 'gestion_etudiants';  // Nom de votre base de données
$username = 'root';        // Votre nom d'utilisateur MySQL
$password = '';            // Votre mot de passe MySQL

4. Installer les dépendances PHP
Si vous utilisez Composer, exécutez la commande suivante pour installer les dépendances :

composer install
Cela installera les bibliothèques nécessaires à l'exécution du projet.

Utilisation
1. Accéder à l'application
L'application est accessible via le serveur local. Vous pouvez y accéder en ouvrant votre navigateur et en allant à http://localhost

2. Connexion et gestion des utilisateurs
Administrateurs : Connectez-vous en utilisant un compte administrateur pour avoir accès aux fonctionnalités CRUD.

Utilisateurs normaux : Ils peuvent uniquement visualiser les données et ne peuvent pas modifier les étudiants ou les sections.

Nouveau_Utilisateur créez un nouveau compte en cliquant le bouton S'inscrire

3. Exporter les données
Vous pouvez exporter les données des sections au format CSV, XLSX ou PDF en cliquant sur les boutons d'exportation dans l'interface utilisateur.

4. Gestion des étudiants et des sections
Ajouter un étudiant : Vous pouvez ajouter un étudiant en remplissant un formulaire avec son nom, sa date de naissance, sa section, et une image (facultatif).

Modifier un étudiant : Vous pouvez modifier les informations d'un étudiant existant.

Supprimer un étudiant : Vous pouvez supprimer un étudiant de la base de données.

Ajouter une section : Vous pouvez ajouter une nouvelle section dans la faculté.

Modifier une section : Vous pouvez modifier les informations d'une section existante.

Supprimer une section : Vous pouvez supprimer une section de la base de données.

Exportation des fichiers
Exporter en CSV : Vous pouvez exporter les données des sections au format CSV.

Exporter en XLSX : Vous pouvez également exporter les données en format Excel (XLSX).

Exporter en PDF : Vous avez la possibilité d'exporter les données au format PDF.

Aide et Support

Si vous rencontrez des problèmes, vérifiez d'abord que vous avez bien configuré votre base de données et que vous avez correctement installé les dépendances.

Si vous avez d'autres questions, n'hésitez pas à ouvrir une issue sur ce dépôt.

Contributeurs
[@TesnimeJamali](https://github.com/TesnimeJamali)
[@MariemOuertani](https://github.com/mariemouertani104)