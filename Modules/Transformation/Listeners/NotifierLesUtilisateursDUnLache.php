<?php

namespace Modules\Transformation\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Carbon;

use Modules\Transformation\Events\UnLivretDeTransformationAChangeEvent;
use App\Notifications\TitreMentionTexteNotification;
use App\Models\User;

class NotifierLesUtilisateursDUnLache
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UnLivretDeTransformationAChangeEvent $event): void
    {
        if ($event->data->action != "VALIDE_LACHE_FONCTION") {
            return;
        }

        $modifying_user = $event->data->modifying_user;
        $modified_user = $event->data->modified_user;

        $object = json_decode($event->data->details);

        $fonction = $object->fonction;
        $commentaire = $object->commentaire;

        $notification = (new TitreMentionTexteNotification())
            ->withTitre($modified_user->display_name . " est laché!")
            ->withMention(Carbon::now(new \DateTimeZone('Europe/Paris'))->toDateTimeString())
            ->withTexte("par " . $modifying_user->display_name . " dans la fonction: " . $fonction->fonction_libcourt);

        $recipients = collect();

        foreach (User::all() as $notified_user) {
            if ($notified_user->id == $modifying_user->id) {
                continue;
                # L'utilisateur qui a validé le lâché n'a pas besoin de recevoir une notification.
            }

            if ($notified_user->id == $modified_user->id) {
                continue;
                # L'utilisateur qui a été lâché peut être notifié, mais il lui faut une notification personnalisée: c'est plus classe.
            }

            if (in_array($fonction->id, $notified_user->settings()->get('transformation.notifications.pour_fonctions.liste_fonctions')))
                $recipients = $recipients->concat([$notified_user]);
        }

        Notification::send($recipients, $notification);

        # On envoie une notification personnalisée à l'utilisateur qui a été lâché.
        $personalized_notification = (new TitreMentionTexteNotification())
            ->withTitre("Vous êtes laché!")
            ->withMention(Carbon::now(new \DateTimeZone('Europe/Paris'))->toDateTimeString())
            ->withTexte($modifying_user->display_name . " a validé votre lâcher dans la fonction: " . $fonction->fonction_libcourt . ". Bravo !");
        Notification::send($modified_user, $personalized_notification);
    }
}
