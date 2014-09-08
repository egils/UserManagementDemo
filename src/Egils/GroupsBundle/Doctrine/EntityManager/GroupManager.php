<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Egils\GroupsBundle\Doctrine\EntityManager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Egils\GroupsBundle\Model\GroupInterface;
use Egils\GroupsBundle\Model\Manager\GroupManager as BaseGroupManager;

/**
 * Class GroupManager
 * @package Egils\GroupsBundle\Doctrine\EntityManager
 */
class GroupManager extends BaseGroupManager
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
    public function add(GroupInterface $group, $save = false)
    {
        $this->em->persist($group);
        if (true === $save) {
            $this->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove(GroupInterface $group, $save = false)
    {
        $this->em->remove($group);
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
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findMany(array $ids)
    {
        return $this->repository->findBy(array('id' => $ids));
    }
}
