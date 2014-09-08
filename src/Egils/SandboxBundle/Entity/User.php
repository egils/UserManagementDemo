<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Egils\SandboxBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Egils\UserBundle\Model\GroupInterface;
use Egils\UserBundle\Model\User as BaseUser;

/**
 * Class User
 * @package Egils\SandboxBundle\Entity
 */
class User extends BaseUser
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param ArrayCollection $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    /**
     * @param GroupInterface $group
     * @return bool
     */
    public function hasGroup(GroupInterface $group)
    {
        return $this->groups->contains($group);
    }

    /**
     * @param GroupInterface $group
     */
    public function addGroup(GroupInterface $group)
    {
        if (false === $this->hasGroup($group)) {
            $this->groups->add($group);
        }
    }
}
