<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Egils\UserBundle\Doctrine\EntityManager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Egils\UserBundle\Model\GroupInterface;
use Egils\UserBundle\Model\UserInterface;
use Egils\UserBundle\Model\Manager\UserManager as BaseUserManager;

/**
 * Class UserManager
 * @package Egils\UserBundle\Doctrine\EntityManager
 */
class UserManager extends BaseUserManager
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $class;

    /**
     * Constructor.
     *
     * @param EntityManager $em
     * @param string $class
     */
    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        $this->repository = $em->getRepository($class);
        $this->class = $em->getClassMetadata($class)->name;
    }

    /**
     * {@inheritdoc}
     */
    public function add(UserInterface $user, $save = false)
    {
        $this->em->persist($user);
        if (true === $save) {
            $this->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove(UserInterface $user, $save = false)
    {
        $this->em->remove($user);
        if (true === $save) {
            $this->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function save()
    {
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->em->clear($this->getClass());
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

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param GroupInterface $group
     * @return UserInterface[]
     */
    public function findManyWithGroup(GroupInterface $group)
    {
        $builder = $this->repository->createQueryBuilder('u');
        $query = $builder->select('u')
            ->innerJoin('u.groups', 'g', Join::WITH, 'g = :group')
            ->setParameter('group', $group)
            ->getQuery();

        return $query->getResult();
    }
}
