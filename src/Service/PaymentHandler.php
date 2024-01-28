<?php

namespace App\Service;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\StripeClient;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

use App\Entity\Utilisateur;

class PaymentHandler implements PaymentHandlerInterface
{

    public function __construct(
        //Injection du paramètre dossier_photo_profil
        #[Autowire('%STRIPE_SECRET%')] private string $apiKey,
        #[Autowire('%PREMIUM_PRICE%')] private string $premiumPrice,
        #[Autowire('%SIGNATURE_SECRET%')] private string $secretSignature,
        private RouterInterface $router,
        private UtilisateurRepository $utilisateurRepository,
        private EntityManagerInterface $entityManager

    ){}

    //Génère et renvoie un lien vers Stripe afin de finaliser l'achat du statut Premium pour l'utilisateur passé en paramètre.
    public function getPremiumCheckoutUrlFor(Utilisateur $utilisateur)  : string
    {

        $paymentData = [
            'mode' => 'payment',
            'payment_intent_data' => ['capture_method' => 'manual', 'receipt_email' => $utilisateur->getAdresseEmail()],
            'customer_email' => $utilisateur->getAdresseEmail(),
            'success_url' => $this->router->generate('premiumCheckoutConfirm', [],UrlGeneratorInterface::ABSOLUTE_URL) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $this->router->generate('premiumInfos',[], UrlGeneratorInterface::ABSOLUTE_URL),
            "metadata" => ["user_id" => $utilisateur->getId()],
            "line_items" => [
                [
                    "price_data" => [
                        "currency" => "eur",
                        "product_data" => ["name" => "MolecuLearn Premium"],
                        "unit_amount" => $this->premiumPrice
                    ],
                    "quantity" => 1

                ]
            ]
        ];
        //Stripe::setApiKey($this->apiKey);
        $stripe = new StripeClient($this->apiKey);
        $stripeSession = $stripe->checkout->sessions->create($paymentData);
        //$stripeSession = Session::create($paymentData);
        $url = $stripeSession->url;
        return $url;

    }

    public function handlePaymentPremium($session) : void {
        $metadata = $session["metadata"];
        if(!isset($metadata["user_id"])) {
            throw new \Exception("dataExemple manquant...");
        }
        $id = $metadata["user_id"];
        $utilisateur = $this->utilisateurRepository->find($id);

        $paymentIntent = $session["payment_intent"];
        $stripe = new StripeClient($this->apiKey);
        $paymentCapture = $stripe->paymentIntents->capture($paymentIntent, []);
        if($paymentCapture==null || $paymentCapture["status"] != "succeeded") {
            $stripe->paymentIntents->cancel($paymentIntent);
            throw new \Exception("Le paiement n'a pas pu être complété...");
        }


        $utilisateur->setPremium(true);
        $this->entityManager->persist($utilisateur);
        $this->entityManager->flush();
    }

    public function checkPaymentStatus($sessionId) : bool {
        $stripe = new StripeClient($this->apiKey);
        $session = $stripe->checkout->sessions->retrieve($sessionId);
        $paymentIntentId = $session->payment_intent;
        $paymentIntent = $stripe->paymentIntents->retrieve($paymentIntentId);
        $status = $paymentIntent->status;
        $capture= false;
        if($status == "succeeded"){
            $capture=true;
        }

        return $capture;

    }

}