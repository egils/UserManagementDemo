<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Egils\GroupsBundle\Model\Manager;

use Egils\GroupsBundle\Model\GroupInterface;

/**
 * Interface GroupManagerInterface
 * @package Egils\GroupsBundle\Model\Manager
 */
interface GroupManagerInterface
{
    /**
     * Create new Group object.
     *
     * @return GroupInterface
     */
    public function create();

    /**
     * Add Group object from persistent layer.
     *
     * @param GroupInterface $group
     * @param bool $save
     */
    public function add(GroupInterface $group, $save = false);

    /**
     * Remove Group object from persistent layer.
     *
     * @param GroupInterface $group
     * @param bool $save
     */
    public function remove(GroupInterface $group, $save = false);

    /**
     * Save persistent layer.
     */
    public function save();

    /**
     * Clear Group objects from persistent layer.
     */
    public function clear();

    /**
     * Get Group object class name.
     *
     * @return string
     */
    public function getClass();
}
