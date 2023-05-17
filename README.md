# connexion-steam-php
Site web permettant la connexion via un compte steam et récupération de certaines données via les API steam tels que les ami(e)s, les jeux etc..

## Comment le mettre en place

### Installation

Il suffit de télécharger le dossier, le mettre en place sur un serveur web supportant PHP.

### Configuration

Vous n'avez qu'à changer les variables $steam_api_key dans les fichiers suivants :
- openId/process-openId.php -> ligne 48
- liste_amis.php            -> ligne 8
- liste_jeux.php            -> ligne 8
