<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Egils\UserBundle\Model\Manager;

use Egils\UserBundle\Model\UserInterface;

/**
 * Interface UserManagerInterface
 * @package Egils\UserBundle\Model\Manager
 */
interface UserManagerInterface
{
    /**
     * Create new User object.
     *
     * @return UserInterface
     */
    public function create();

    /**
     * Add User object from persistent layer.
     *
     * @param UserInterface $user
     * @param bool $save
     */
    public function add(UserInterface $user, $save = false);

    /**
     * Remove User object from persistent layer.
     *
     * @param UserInterface $user
     * @param bool $save
     */
    public function remove(UserInterface $user, $save = false);

    /**
     * Save persistent layer.
     */
    public function save();

    /**
     * Clear User objects from persistent layer.
     */
    public function clear();

    /**
     * Get User object class name.
     *
     * @return string
     */
    public function getClass();
}
