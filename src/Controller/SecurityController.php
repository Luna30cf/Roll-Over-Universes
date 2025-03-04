<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(Request $request, AuthenticationUtils $authenticationUtils, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Si un utilisateur est déjà connecté, redirection vers la page d'accueil
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        // Si la méthode est POST (l'utilisateur soumet le formulaire de connexion)
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            // Vérification des identifiants admin
            $userRepository = $entityManager->getRepository(User::class);
            $user = $userRepository->findOneBy(['email' => $email]);

            // Vérification si l'utilisateur existe et si le mot de passe est valide
            if ($user && $passwordHasher->isPasswordValid($user, $password)) {
                // Appel de la méthode pour vérifier les identifiants et définir le rôle
                $this->checkCredentialsAndSetRole($user, $email, $password, $passwordHasher, $entityManager);
                // Rediriger vers la page d'accueil après la connexion
                return $this->redirectToRoute('homepage');
            } else {
                $error = 'Identifiants incorrects';
            }
        }

        // Rendu du formulaire de connexion avec un message d'erreur si nécessaire
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Set default values
            $user->setBalance('0.00');
            $user->setPictureProfile('default.jpg');
            $user->setRoles(['ROLE_USER']);

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): void
    {
        // Le logout est géré automatiquement par Symfony
    }

    // Fonction qui vérifie l'email et le mot de passe et change le rôle en fonction des critères
    public function checkCredentialsAndSetRole(User $user, string $email, string $password, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): void
    {
        // Identifiants admin
        $adminEmail = 'admin@rolluniverse.com';
        $adminPassword = 'ROUlilk'; // Le mot de passe admin en clair

        // Hacher le mot de passe admin pour comparer
        $adminPasswordHash = $passwordHasher->hashPassword(new User(), $adminPassword);

        // Si l'email et le mot de passe correspondent à ceux d'un admin, attribuer le rôle ROLE_ADMIN
        if ($email === $adminEmail && $passwordHasher->isPasswordValid(new User(), $password)) {
            // Si l'utilisateur est admin, on met à jour son rôle
            $user->setRoles(['ROLE_ADMIN']);
            $entityManager->persist($user);
            $entityManager->flush();
        }
    }
}
