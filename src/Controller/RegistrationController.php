<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();
            
            // 🔥 Récupération correcte de l'email
            $email = $user->getEmail(); 

            // Hachage du mot de passe avant l'enregistrement
            $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);

            // Vérification des identifiants pour donner le rôle admin
            $isAdmin = $this->checkIfAdmin($email, $hashedPassword);

            if ($isAdmin) {
                $user->setRoles(['ROLE_ADMIN']);
            } else {
                $user->setRoles(['ROLE_USER']);
            }

            // Enregistrement de l'utilisateur en base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // Connexion automatique de l'utilisateur
            return $security->login($user, 'form_login', 'main');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    /**
     * Vérifie si l'utilisateur doit devenir administrateur
     */
    private function checkIfAdmin(string $email, string $hashedPassword): bool
    {
        // Emails autorisés à devenir admin
        $adminEmails = ['admin@rolluniverse.com'];

        // 🔥 Hachage du mot de passe admin défini en dur (pour comparaison)
        $adminPasswordHash = password_hash('ROUlilk', PASSWORD_BCRYPT);

        // Vérifie que l'email est dans la liste des admins ET que le mot de passe est correct
        if (in_array($email, $adminEmails, true) && password_verify('ROUlilk', $hashedPassword)) {
            return true;
        }

        return false;
    }
}
