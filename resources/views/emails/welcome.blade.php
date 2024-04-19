<x-markdown>
# Bienvenue {{$user->display_name}} !

Votre compte utilisateur a été activé par un administrateur.

Vous pouvez désormais vous connecter à <a href="{{route(config('skeletor.page_par_defaut'))}}">{{config('app.name')}}</a>

*Rappels:* 
- Si vous êtes à terre (avec une station Intradef normale), le *login auto* vous permet d'être reconnu automatiquement par l'application 
sans avoir à re-rentrer votre mot de passe.
- Si vous êtes à bord d'un bâtiment de surface, le *login auto* vous conduira sur une page vous demandant de saisir votre login et mot de
passe DR-CPT. Il s'agit des informations vous permettant d'accéder à divers services communs d'Intradef notamment la messagerie Intradef.
- Si vous rencontrez des difficultés pour retrouver ces informations, adressez-vous à votre correspondant d'annuaire local, et en dernier
recours, adressez un mail à l'équipe FFAST qui s'efforcera de vous aider.

### Documentation
La documentation de l'application est disponible sur toutes les pages grace au lien "Aide" dans le menu déroulant à votre nom.

### Première chose à faire
Nous vous conseillons de définir un mot de passe local après votre première connexion dans le menu déroulant à votre nom. Retrouvez la documentation consacrée aux méthodes de connexion dans l'aide sur la page "Connexion".

### Obtenir de l'aide
Si la documentation ne vous permet pas de trouver les réponses à vos questions, n'hésitez pas à le signaler avec le bouton jaune situé en haut de chaque page. 
L'équipe projet s'efforcera de venir à votre rescousse.

Sinon, il y a aussi le mail:
<a href="mailto:ffast.notification.tec@intradef.gouv.fr">ffast.notification.tec@intradef.gouv.fr</a>

Maintenant, à vous de jouer ! Pardon travailler.&#128521;<br>
L'équipe projet.
</x-markdown>