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

/**
 * Class UserManager
 * @package Egils\UserBundle\Model\Manager
 */
abstract class UserManager implements UserManagerInterface
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
