<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Egils\UserBundle\Model\Provider;

use Egils\UserBundle\Model\UserInterface;

/**
 * Interface UserProviderInterface
 * @package Egils\UserBundle\Model\Provider
 */
interface UserProviderInterface
{

    /**
     * Get specific User by its id.
     * @param $id
     * @return UserInterface
     */
    public function find($id);

    /**
     * Get range of Users.
     *
     * @param $offset
     * @param $limit
     * @return UserInterface[]|array
     */
    public function fetch($offset, $limit);
}
