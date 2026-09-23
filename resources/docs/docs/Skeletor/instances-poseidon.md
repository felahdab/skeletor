# Instances Poseidon

Skeletor maintient une liste des instances Poseidon découvertes grâce à RabbitMQ.

## Fonctionnement

1. L'application reçoit un message RabbitMQ avec la clé de routage `test.ping`.
2. Elle répond avec un message `test.pong` contenant la description du noeud :
   - son nom ;
   - la version de Skeletor ;
   - les modules installés et leurs versions.
3. Lorsqu'un message `test.pong` est reçu, l'instance est créée ou mise à jour dans la table `poseidoninstances`.
4. La date `last_seen` est mise à jour à chaque réponse reçue.

Une instance est considérée comme **active** si sa dernière réponse date de moins de 48 heures.

## Affichage

La ressource Filament **Instances Poseidon** affiche :

- le nom de l'instance ;
- son état actif ou inactif ;
- la date de sa dernière réponse ;
- les versions de Skeletor et de ses modules ;
- la description complète du noeud.

Les instances sont consultables uniquement. Elles ne peuvent pas être créées, modifiées ou supprimées depuis Filament.
