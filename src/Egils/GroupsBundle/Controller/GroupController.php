<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Egils\GroupsBundle\Controller;

use Egils\GroupsBundle\Form\GroupType;
use Egils\GroupsBundle\Model\Manager\GroupManagerInterface;
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
 * Class GroupController
 * @package Egils\GroupsBundle\Controller
 */
class GroupController extends FOSRestController
{
    /**
     * @return GroupManagerInterface
     */
    private function getGroupManager()
    {
        return $this->get('egils_groups.manager.group');
    }

    /**
     * Get all groups.
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
    public function getGroupsAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $start = null == $offset ? 0 : $offset + 1;
        $limit = $paramFetcher->get('limit');

        $groups = $this->get('egils_groups.provider.group')->fetch($start, $limit);

        return array('groups' => $groups, 'offset' => $offset, 'limit' => $limit);
    }

    /**
     * Get a single group.
     *
     * @ApiDoc(
     *   output = "Egils\GroupsBundle\Model\Group",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the group is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="group")
     *
     * @param Request $request the request object
     * @param int $id the group id
     *
     * @return array
     *
     * @throws NotFoundHttpException when group does not exist
     */
    public function getGroupAction(Request $request, $id)
    {
        $group = $this->get('egils_groups.provider.group')->find($id);
        if (false === $group) {
            throw $this->createNotFoundException("Group does not exist.");
        }

        $view = new View($group);
        $securityGroup = $this->container->get('security.context')->isGranted('ROLE_API') ? 'restapi' : 'standard';
        $view->getSerializationContext()->setGroups(array('Default', $securityGroup));

        return $view;
    }

    /**
     * Presents the form to use to create a new group.
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
    public function newGroupAction()
    {
        return $this->createForm(new GroupType($this->getGroupManager()));
    }

    /**
     * Presents the form to use to update an existing group.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     200 = "Returned when successful",
     *     404 = "Returned when the group is not found"
     *   }
     * )
     *
     * @Annotations\View()
     *
     * @param Request $request the request object
     * @param int $id the group id
     *
     * @return FormTypeInterface
     *
     * @throws NotFoundHttpException when group not exist
     */
    public function editGroupAction(Request $request, $id)
    {
        $group = $this->get('egils_groups.provider.group')->find($id);

        if (false === $group) {
            throw new NotFoundHttpException("Group does not exist.");
        }

        $form = $this->createForm(new GroupType($this->getGroupManager()), $group);

        return $form;
    }

    /**
     * Creates a new group from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Egils\GroupsBundle\Form\GroupType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *   template = "EgilsGroupsBundle:Group:newGroup.html.twig",
     *   statusCode = Codes::HTTP_BAD_REQUEST
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|RouteRedirectView
     */
    public function postGroupAction(Request $request)
    {
        $group = $this->getGroupManager()->create();
        $form = $this->createForm(new GroupType($this->getGroupManager()), $group);

        $form->submit($request);
        if ($form->isValid()) {
            $this->getGroupManager()->add($group, true);

            return $this->routeRedirectView('get_group', array('id' => $group->getId()));
        }

        return array(
            'form' => $form
        );
    }

    /**
     * Update existing group from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Egils\GroupsBundle\Form\GroupType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *   template="EgilsGroupsBundle:Group:editGroup.html.twig",
     *   templateVar="form"
     * )
     *
     * @param Request $request the request object
     * @param int $id the group id
     *
     * @return FormTypeInterface|RouteRedirectView
     *
     * @throws NotFoundHttpException when group not exist
     */
    public function putGroupAction(Request $request, $id)
    {
        $group = $this->get('egils_groups.provider.group')->find($id);
        if (null === $group) {
            throw new NotFoundHttpException("Group does not exist.");
        } else {
            $statusCode = Codes::HTTP_NO_CONTENT;
        }

        $form = $this->createForm(new GroupType($this->getGroupManager()), $group);

        $form->submit($request);
        if ($form->isValid()) {
            $this->getGroupManager()->add($group, true);

            return $this->routeRedirectView('get_group', array('id' => $group->getId()), $statusCode);
        }

        return $form;
    }

    /**
     * Removes a group.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful",
     *     404 = "Returned when the group is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the group id
     *
     * @return RouteRedirectView
     */
    public function deleteGroupAction(Request $request, $id)
    {
        $group = $this->get('egils_groups.provider.group')->find($id);
        if (null === $group) {
            $statusCode = Codes::HTTP_NOT_FOUND;
        } else {
            $statusCode = Codes::HTTP_NO_CONTENT;
            $this->getGroupManager()->remove($group, true);
        }

        return $this->routeRedirectView('get_groups', array(), $statusCode);
    }

    /**
     * Removes a group.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes={
     *     204="Returned when successful",
     *     404 = "Returned when the group is not found"
     *   }
     * )
     *
     * @param Request $request the request object
     * @param int $id the group id
     *
     * @return RouteRedirectView
     */
    public function removeGroupAction(Request $request, $id)
    {
        return $this->deleteGroupAction($request, $id);
    }
}
