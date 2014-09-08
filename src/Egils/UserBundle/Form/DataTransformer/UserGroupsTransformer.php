<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Egils\UserBundle\Form\DataTransformer;

use Egils\GroupsBundle\Model\GroupInterface;
use Egils\GroupsBundle\Model\Manager\GroupManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class UserTransformer
 * @package Egils\UserBundle\Form\DataTransformer
 */
class UserGroupsTransformer implements DataTransformerInterface
{
    /**
     * @var GroupManagerInterface
     */
    protected $manager;

    /**
     * @param GroupManagerInterface $manager
     */
    public function __construct(GroupManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param GroupInterface[]|array $groups
     * @return mixed|void
     */
    public function transform($groups)
    {
        $data = array();
        foreach ($groups as $group) {
            $data[] = $group->getId();
        }

        return $data;
    }

    /**
     * @param array $groups
     * @return GroupInterface[]|array
     */
    public function reverseTransform($groups)
    {
        return $this->manager->findMany($groups);
    }
}
