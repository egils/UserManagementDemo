<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Egils\GroupsBundle\Doctrine\Provider;

use Doctrine\ORM\EntityRepository;
use Egils\GroupsBundle\Model\Provider\GroupProviderInterface;

/**
 * Class GroupProvider
 * @package Egils\GroupsBundle\Doctrine\Provider
 */
class GroupProvider implements GroupProviderInterface
{
    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * {@inheritdoc}
     */
    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }
}
