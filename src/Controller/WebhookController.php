<?php
namespace App\Controller;

use App\Repository\UtilisateurRepository;
use App\Service\PaymentHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Webhook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebhookController extends AbstractController
{
    #[Route('/webhook/stripe', name: 'stripeWebhook', methods: ['POST'])]
    public function stripeWebhook(
        PaymentHandlerInterface $paymentHandler,
        #[Autowire('%SIGNATURE_SECRET%')] string $secretSignature,

    ): Response
    {
        $payload = @file_get_contents('php://input');

        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        try {
            /*
            On construit l'événement.
            On utilise $secretSignature qui contient la signature secrète récupérée plus tôt (dans le terminal)
            Si la signature n'est pas bonne (vérifié avec la signature de la requête et celle secrète), une exception est déclenchée.
            */
            $event = Webhook::constructEvent($payload, $sig_header, $secretSignature);

            /*
            On vérifie le type d'événement.
            Pour l'instant, nous ne traitons que l'événement checkout.session.completed qui est déclenché quand l'utilisateur valide le formulaire et le paiement est prêt à être capturé
            Si l'application vient à évoluer, on pourrait traiter d'autres événements
            */
            if ($event->type == 'checkout.session.completed') {
                /*
                $session contient les données du paiement.
                On pourra notamment accèder aux meta-données que nous avions initialement placé lors de la création du paiement
                */
                $session = $event->data->object;
                //On imagine que $service est un service contenant une méthode permettant de traiter la suite de la requête.
                $paymentHandler->handlePaymentPremium($session);
                //Si on arrive là, tout s'est bien passé, on renvoi un code de succès à Stripe.
                return new Response(null, 200);
            }
            else {
                //Si on arrive là, c'est qu'on ne gère pas l'événement déclenché, on renvoi alors un code d'erreur à Stripe.
                return new Response('Onne gère pas l evenement déclenché', 402);
            }
        } catch(\Exception $e) {
            /*
            Ici, la signature n'est pas vérifiée, ou une autre erreur est survenue pendant le traitement.
            On renvoi donc un code d'erreur à Stripe.
            */
            return new Response('Signature pas vérifié ou autres erreurs', 409);
        }

    }
}