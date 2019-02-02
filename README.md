# Conception de l'application. #


**Note concernant le Backend de gestion/API privé :**



Concernant la sécurité, deux approches ont été perçues, Corentin s'est occupé d'une identification vers le dossier webApps qui demande l'identification de la personne, les données sont analysés dans la base de données.
Du coté de Pierre, la sécurité passe par le serveur Apache2, à chaque fois que l'URL s'invite dans le dossier Admin, le serveur apache demande une authentification pour le controle d’accès. 
( login : admin, mdp : lol ) 

Concernant l'api privée, Pierre avait la même démarche mais avec une authentification de l'adresse IP des points de ventes. Ainsi il s'agissait juste de mettre les IP concernées pour l'accès aux données de l'api privée.

Pour le retard, nous tenons à nous excuser, nous n'avons pas prêté attention aux mails durant les vacances, Corentin et Guillaume n'étant pas disponible pour les vacances, le projet a subit du retard conséquent.