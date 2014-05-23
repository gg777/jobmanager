<?php
/**
 * Created by PhpStorm.
 * User: gerard
 * Date: 23/05/2014
 * Time: 23:08
 */

namespace Jobmanager\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Jobmanager\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Users implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $logins = array('gerard');

        foreach ($logins as $k => $login) {
            $users[$k] = new User();
            $users[$k]->setUsername($login);
            $users[$k]->setSalt(uniqid(mt_rand()));

            // call encoder service
            $encoder = $this->container
                ->get('security.encoder_factory')
                ->getEncoder($users[$k])
            ;

            $password = $encoder->encodePassword('137paf6', $users[$k]->getSalt());

            $users[$k]->setPassword($password);

            $users[$k]->setRoles(array('ROLE_ADMIN'));

            $manager->persist($users[$k]);
        }

        $manager->flush();
    }
} 