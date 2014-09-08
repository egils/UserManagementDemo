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

use Egils\GroupsBundle\Model\GroupInterface;

/**
 * Class User.
 * @package Egils\UserBundle\Model
 */
abstract class User implements UserInterface
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var GroupInterface[]|array
     */
    protected $groups;

    /**
     * @inheritdoc
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @inheritdoc
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    /**
     * @inheritdoc
     */
    public function hasGroup(GroupInterface $group)
    {
        return in_array($group, $this->groups);
    }

    /**
     * @inheritdoc
     */
    public function addGroup(GroupInterface $group)
    {
        if (false === $this->hasGroup($group)) {
            $this->groups[] = $group;
        }
    }
}
