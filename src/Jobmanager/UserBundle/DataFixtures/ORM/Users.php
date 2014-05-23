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
        $noms = array('gerard');

        foreach ($noms as $i => $nom) {
            $users[$i] = new User();
            $users[$i]->setUsername($nom);
            $users[$i]->setSalt(uniqid(mt_rand()));

            // call encoder service
            $encoder = $this->container
                ->get('security.encoder_factory')
                ->getEncoder($users[$i])
            ;

            $password = $encoder->encodePassword('137paf6', $users[$i]->getSalt());

            $users[$i]->setPassword($password);

            $users[$i]->setRoles(array('ROLE_ADMIN'));

            $manager->persist($users[$i]);
        }

        $manager->flush();
    }
} 