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

use Egils\UserBundle\Model\GroupInterface;

/**
 * Interface GroupManagerInterface
 * @package Egils\UserBundle\Model\Manager
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
     * Get all groups.
     *
     * @return GroupInterface[]
     */
    public function all();

    /**
     * Get specific Group by its id.
     * @param $id
     * @return GroupInterface
     */
    public function find($id);

    /**
     * Get range of Groups.
     *
     * @param $offset
     * @param $limit
     * @return GroupInterface[]|array
     */
    public function fetch($offset, $limit);

    /**
     * Get groups by list of identifiers.
     *
     * @param array $ids
     * @return GroupInterface[]
     */
    public function findMany(array $ids);

    /**
     * Get Group object class name.
     *
     * @return string
     */
    public function getClass();
}
