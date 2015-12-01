<?php
namespace Acme\UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use FOS\UserBundle\Model\UserInterface;

/**
 * Class RegistrationController
 * @package Acme\UserBundle\Controller
 */
class RegistrationController extends BaseController
{
    public function registerAction() {
        $response = new Response();

        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

        $process = $formHandler->process($confirmationEnabled);
        if ($process) {
            $user = $form->getData();

            if ($confirmationEnabled) {
                $data = null;
                $code = 200;
            } else {
                $data = [
                    'token' => $this->container->get("lexik_jwt_authentication.jwt_manager")->create($user),
                    // TODO HYPERMEDIA
                ];
                $code = 201;
            }
        } else {
            $data = $this->container->get('form_serializer')->serializeFormErrors($form, true, true);
            $code = 400;
        }

        $response->setContent(json_encode($data));
        $response->setStatusCode($code);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
    * Receive the confirmation token from user email provider, login the user
    */
    public function confirmAction($token)
    {
        $response = new Response();
        $user = $this->container->get('fos_user.user_manager')->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $user->setLastLogin(new \DateTime());

        $this->container->get('fos_user.user_manager')->updateUser($user);
        $data = [
            'token' => $this->container->get("lexik_jwt_authentication.jwt_manager")->create($user),
            // TODO HYPERMEDIA
        ];
        $code = 201;
        $response->setContent(json_encode($data));
        $response->setStatusCode($code);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
