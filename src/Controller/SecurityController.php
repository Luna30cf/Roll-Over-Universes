<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        // Vérification si l'utilisateur doit être admin après soumission du formulaire de login
        if ($lastUsername === 'admin@rolluniverse.com' && !$error) {
            // Récupérer l'utilisateur actuellement authentifié
            $user = $this->security->getUser();
            
            // Si l'utilisateur est admin, on lui attribue le rôle 'ROLE_ADMIN'
            if ($user) {
                // On vérifie si le mot de passe est correct (ici, tu compares manuellement, mais normalement, Symfony s'en occupe)
                $password = 'ROUlilk';
                if (password_verify($password, $user->getPassword())) { // Comparer les mots de passe hachés
                    // Ajouter le rôle admin si l'email et le mot de passe sont corrects
                    $user->setRoles(['ROLE_ADMIN']);
                    $this->getDoctrine()->getManager()->persist($user);
                    $this->getDoctrine()->getManager()->flush();
                }
            }
            return $this->redirectToRoute('homepage');
        }

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
}
