<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Egils\UserBundle\Doctrine\Provider;

use Doctrine\ORM\EntityRepository;
use Egils\UserBundle\Model\UserInterface;
use Egils\UserBundle\Model\Provider\UserProviderInterface;

/**
 * Class UserProvider
 * @package Egils\UserBundle\Doctrine\Provider
 */
class UserProvider implements UserProviderInterface
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

    /**
     * @inheritdoc
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @inheritdoc
     */
    public function fetch($offset, $limit)
    {
        $builder = $this->repository->createQueryBuilder('u');
        $query = $builder->select('u')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery();

        return $query->getResult();
    }
}
