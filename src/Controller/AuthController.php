<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController extends AbstractController
{

    public function register(Request $request, UserPasswordEncoderInterface $encoder, UserRepository $repository)
    {
        $em = $this->getDoctrine()->getManager();
        $body = json_decode($request->getContent());
        if(!isset($body->email) || !isset($body->password) || !filter_var($body->email, FILTER_VALIDATE_EMAIL)) {
            return $this->json(['error' => 'wrong_data', 'message' => 'Email et password requis']);
        } else if($repository->findBy(['email' => $body->email])) {
            return $this->json([
                'error' => 'already_exists',
                'message' => 'Cette adresse mail est déjà utilisée'
            ]);
        } else {
            $username = $body->email;
            $password = $body->password;

            $user = new User();
            $user->setEmail($username);
            $user->setPassword($password);
            $user->setFirstName($body->firstname ?? '');
            $user->setLastName($body->lastname ?? '');
            $user->setPassword($encoder->encodePassword($user, $password));
            $em->persist($user);
            $em->flush();
        }

        return $this->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function me() {
        return $this->json($this->getUser());

    }
}