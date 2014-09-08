<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Egils\GroupsBundle\Model\Provider;

use Egils\GroupsBundle\Model\GroupInterface;

/**
 * Interface GroupProviderInterface
 * @package Egils\GroupsBundle\Model\Provider
 */
interface GroupProviderInterface
{

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
}
