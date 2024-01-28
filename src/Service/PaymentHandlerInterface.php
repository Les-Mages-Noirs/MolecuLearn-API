<?php

namespace App\Service;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;

interface PaymentHandlerInterface
{
    public function getPremiumCheckoutUrlFor(Utilisateur $utilisateur): string;
    public function handlePaymentPremium($session);
    public function checkPaymentStatus($sessionId) : bool;
}