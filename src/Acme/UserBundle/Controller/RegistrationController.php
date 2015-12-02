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
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class RegistrationController
 * @package Acme\UserBundle\Controller
 */
class RegistrationController extends BaseController
{

    /**
     * Register a new user.
     *
     * @ApiDoc(
     *  section = "User",
     *  description = "Register a new user.",
     *  statusCodes = {
     *      200 = "User registered and wait for confirmation",
     *      201 = "User registered without confirmation",
     *      400 = "Invalid data received."
     *  },
     *  parameters = {
     *      { "name" = "fos_user_registration_form[username]", "dataType" = "string", "required" = true, "description" = "Username of the user to register." },
     *      { "name" = "fos_user_registration_form[email]", "dataType" = "string", "required" = true, "description" = "Email of the user to register." },
     *      { "name" = "fos_user_registration_form[plainPassword][first]", "dataType" = "string", "required" = true, "description" = "Password of the user to register." },
     *      { "name" = "fos_user_registration_form[plainPassword][second]", "dataType" = "string", "required" = true, "description" = "Confirm password of the user to register." },
     *      { "name" = "callback", "dataType" = "string", "required" = true, "description" = "Url for the confirmation link to send in the confirmation mail." }
     *  }
     * )
     * @Method("POST")
     * @Route("register")
     */
    public function registerAction()
    {
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
