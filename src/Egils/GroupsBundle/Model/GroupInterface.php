<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Egils\GroupsBundle\Model;

/**
 * Interface GroupInterface
 * @package Egils\GroupsBundle\Model
 */
interface GroupInterface
{

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return GroupInterface
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
     * @return GroupInterface
     */
    public function setName($name);

    /**
     * Get name.
     *
     * @return string
     */
    public function getName();
}
