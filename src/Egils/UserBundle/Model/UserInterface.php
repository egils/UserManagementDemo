<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Egils\UserBundle\Model;

use Egils\UserBundle\Model\GroupInterface;

/**
 * Interface UserInterface
 * @package Egils\UserBundle\Model
 */
interface UserInterface
{

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return UserInterface
     */
    public function setId($id);

    /**
     * Get id.
     *
     * @return int
     */
    public function getId();

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return UserInterface
     */
    public function setName($name);

    /**
     * Get name.
     *
     * @return string
     */
    public function getName();

    /**
     * @return GroupInterface[]
     */
    public function getGroups();

    /**
     * @param GroupInterface[] $groups
     */
    public function setGroups($groups);

    /**
     * @param GroupInterface $group
     * @return bool
     */
    public function hasGroup(GroupInterface $group);

    /**
     * @param GroupInterface $group
     */
    public function addGroup(GroupInterface $group);
}
