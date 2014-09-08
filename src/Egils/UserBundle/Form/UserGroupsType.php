<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Egils\UserBundle\Form;

use Egils\UserBundle\Model\Manager\GroupManagerInterface;
use Egils\UserBundle\Form\DataTransformer\UserGroupsTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class UserGroupsType
 * @package Egils\UserBundle\Form
 */
class UserGroupsType extends AbstractType
{

    /**
     * @var GroupManagerInterface
     */
    protected $manager;

    /**
     * @param GroupManagerInterface $manager
     */
    public function __construct(GroupManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new UserGroupsTransformer($this->manager));
    }

    /**
     * @inheritdoc
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->getGroups(),
            'expanded' => true,
            'multiple' => true,
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'egils_user_groups';
    }

    public function getParent()
    {
        return 'choice';
    }

    /**
     * @return array
     */
    private function getGroups()
    {
        $groups = array();
        foreach ($this->manager->all() as $group) {
            $groups[$group->getId()] = $group->getName();
        }

        return $groups;
    }
}
