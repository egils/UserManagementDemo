<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Egils\UserBundle\Controller;

use Egils\UserBundle\Form\UserType;
use Egils\UserBundle\Model\Manager\UserManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\RouteRedirectView;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormTypeInterface;

use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UserController
 * @package Egils\UserBundle\Controller
 */
class UserController extends FOSRestController
{
    /**
     * @return UserManagerInterface
     */
    private function getUserManager()
    {
        return $this->get('egils_user.manager.user');
    }

    /**
     * Get all users.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="10", description="How many to fetch.")
     *
     * @Annotations\View()
     *
     * @param Request $request the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getUsersAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $start = null == $offset ? 0 : $offset + 1;
        $limit = $paramFetcher->get('limit');

        $users = $this->get('egils_user.provider.user')->fetch($start, $limit);

        return array('users' => $users, 'offset' => $offset, 'limit' => $limit);
    }

    /**
     * Get a single user.
     *
     * @ApiDoc(
     *   output = "Egils\UserBundle\Model\User",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the user is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="user")
     *
     * @param Request $request the request object
     * @param int $id the user id
     *
     * @return array
     *
     * @throws NotFoundHttpException when user does not exist
     */
    public function getUserAction(Request $request, $id)
    {
        $user = $this->get('egils_user.provider.user')->find($id);
        if (false === $user) {
            throw $this->createNotFoundException("User does not exist.");
        }

        $view = new View($user);
        $securityGroup = $this->container->get('security.context')->isGranted('ROLE_API') ? 'restapi' : 'standard';
        $view->getSerializationContext()->setGroups(array('Default', $securityGroup));

        return $view;
    }

    /**
     * Presents the form to use to create a new user.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View()
     *
     * @return FormTypeInterface
     */
    public function newUserAction()
    {
        return $this->createForm(new UserType());
    }

    /**
     * Presents the form to use to update an existing user.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     200 = "Returned when successful",
     *     404 = "Returned when the user is not found"
     *   }
     * )
     *
     * @Annotations\View()
     *
     * @param Request $request the request object
     * @param int $id the user id
     *
     * @return FormTypeInterface
     *
     * @throws NotFoundHttpException when user not exist
     */
    public function editUserAction(Request $request, $id)
    {
        $user = $this->get('egils_user.provider.user')->find($id);

        if (false === $user) {
            throw new NotFoundHttpException("User does not exist.");
        }

        $form = $this->createForm(new UserType(), $user);

        return $form;
    }

    /**
     * Creates a new user from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Egils\UserBundle\Form\UserType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *   template = "EgilsUserBundle:User:newUser.html.twig",
     *   statusCode = Codes::HTTP_BAD_REQUEST
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|RouteRedirectView
     */
    public function postUserAction(Request $request)
    {
        $user = $this->getUserManager()->create();
        $form = $this->createForm(new UserType(), $user);

        $form->submit($request);
        if ($form->isValid()) {
            $this->getUserManager()->add($user, true);

            return $this->routeRedirectView('get_user', array('id' => $user->getId()));
        }

        return array(
            'form' => $form
        );
    }

    /**
     * Update existing user from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Egils\UserBundle\Form\UserType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *   template="EgilsUserBundle:User:editUser.html.twig",
     *   templateVar="form"
     * )
     *
     * @param Request $request the request object
     * @param int $id the user id
     *
     * @return FormTypeInterface|RouteRedirectView
     *
     * @throws NotFoundHttpException when user not exist
     */
    public function putUserAction(Request $request, $id)
    {
        $user = $this->get('egils_user.provider.user')->find($id);
        if (null === $user) {
            throw new NotFoundHttpException("User does not exist.");
        } else {
            $statusCode = Codes::HTTP_NO_CONTENT;
        }

        $form = $this->createForm(new UserType(), $user);

        $form->submit($request);
        if ($form->isValid()) {
            $this->getUserManager()->add($user, true);

            return $this->routeRedirectView('get_user', array('id' => $user->getId()), $statusCode);
        }

        return $form;
    }

    /**
     * Removes an user.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful",
     *     404 = "Returned when the user is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the user id
     *
     * @return RouteRedirectView
     */
    public function deleteUserAction(Request $request, $id)
    {
        $user = $this->get('egils_user.provider.user')->find($id);
        if (null === $user) {
            $statusCode = Codes::HTTP_NOT_FOUND;
        } else {
            $statusCode = Codes::HTTP_NO_CONTENT;
            $this->getUserManager()->remove($user, true);
        }

        return $this->routeRedirectView('get_user', array(), $statusCode);
    }

    /**
     * Removes an user.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful",
     *     404 = "Returned when the user is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the user id
     *
     * @return RouteRedirectView
     */
    public function removeUserAction(Request $request, $id)
    {
        return $this->deleteUserAction($request, $id);
    }
}
