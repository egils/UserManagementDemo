<?php
/*
* This file is part of the Egils package.
*
* (c) Egils <egils@egils.eu>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Egils\UserBundle\Form\Factory;

use Egils\UserBundle\Model\UserInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class UserFormFactory
 * @package Egils\UserBundle\Form\Factory
 */
class UserFormFactory
{

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * Constructor.
     *
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * Create user form.
     *
     * @param UserInterface $user
     *
     * @return FormInterface
     */
    public function create(UserInterface $user)
    {
        return $this->formFactory->create('egils_user', $user);
    }
}
