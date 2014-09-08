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

/**
 * Class GroupManager
 * @package Egils\GroupsBundle\Model\Manager
 */
abstract class GroupManager implements GroupManagerInterface
{

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $className = $this->getClass();
        $value = new $className;

        return $value;
    }
}
