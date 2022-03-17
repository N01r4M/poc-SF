<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new Users();
        $user->setLastName('Admin');
        $user->setFirstName('Admin');
        $user->setEmail('admin@mail.fr');
        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);
        $user->setRole('ROLE_ADMIN');
        $user->setIsTeamManager(false);
        $user->setTeam(null);
        $manager->persist($user);
        $this->addReference('user_0', $user);

        $user = new Users();
        $user->setLastName('Goudreau');
        $user->setFirstName('Guérin');
        $user->setEmail('gg@mail.fr');
        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);
        $user->setRole('ROLE_USER');
        $user->setIsTeamManager(true);
        $user->setTeam($this->getReference('team_0'));
        $manager->persist($user);
        $this->addReference('user_1', $user);

        $user = new Users();
        $user->setLastName('Quirion');
        $user->setFirstName('Annette');
        $user->setEmail('aq@mail.fr');
        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);
        $user->setRole('ROLE_USER');
        $user->setIsTeamManager(false);
        $user->setTeam($this->getReference('team_0'));
        $manager->persist($user);
        $this->addReference('user_2', $user);

        $user = new Users();
        $user->setLastName('Proulx');
        $user->setFirstName('Pierette');
        $user->setEmail('pp@mail.fr');
        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);
        $user->setRole('ROLE_USER');
        $user->setIsTeamManager(false);
        $user->setTeam($this->getReference('team_0'));
        $manager->persist($user);
        $this->addReference('user_3', $user);

        $user = new Users();
        $user->setLastName('Berthelette');
        $user->setFirstName('Monique');
        $user->setEmail('mb@mail.fr');
        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);
        $user->setRole('ROLE_USER');
        $user->setIsTeamManager(true);
        $user->setTeam($this->getReference('team_1'));
        $manager->persist($user);
        $this->addReference('user_4', $user);

        $user = new Users();
        $user->setLastName('Labrie');
        $user->setFirstName('Nicolas');
        $user->setEmail('nl@mail.fr');
        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);
        $user->setRole('ROLE_USER');
        $user->setIsTeamManager(false);
        $user->setTeam($this->getReference('team_1'));
        $manager->persist($user);
        $this->addReference('user_5', $user);

        $user = new Users();
        $user->setLastName('Beauchemin');
        $user->setFirstName('Delphine');
        $user->setEmail('db@mail.fr');
        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);
        $user->setRole('ROLE_USER');
        $user->setIsTeamManager(false);
        $user->setTeam($this->getReference('team_1'));
        $manager->persist($user);
        $this->addReference('user_6', $user);

        $user = new Users();
        $user->setLastName('Bourassa');
        $user->setFirstName('Tanguy');
        $user->setEmail('bt@mail.fr');
        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);
        $user->setRole('ROLE_USER');
        $user->setIsTeamManager(true);
        $user->setTeam($this->getReference('team_2'));
        $manager->persist($user);
        $this->addReference('user_7', $user);

        $user = new Users();
        $user->setLastName('Boiver');
        $user->setFirstName('Noémi');
        $user->setEmail('nb@mail.fr');
        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);
        $user->setRole('ROLE_USER');
        $user->setIsTeamManager(false);
        $user->setTeam($this->getReference('team_2'));
        $manager->persist($user);
        $this->addReference('user_8', $user);

        $user = new Users();
        $user->setLastName('Charrette');
        $user->setFirstName('Olivier');
        $user->setEmail('co@mail.fr');
        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);
        $user->setRole('ROLE_USER');
        $user->setIsTeamManager(false);
        $user->setTeam($this->getReference('team_2'));
        $manager->persist($user);
        $this->addReference('user_9', $user);

        $user = new Users();
        $user->setLastName('Flamand');
        $user->setFirstName('Henry');
        $user->setEmail('hf@mail.fr');
        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);
        $user->setRole('ROLE_USER');
        $user->setIsTeamManager(true);
        $user->setTeam($this->getReference('team_3'));
        $manager->persist($user);
        $this->addReference('user_10', $user);

        $user = new Users();
        $user->setLastName('Abril');
        $user->setFirstName('Gaspard');
        $user->setEmail('ga@mail.fr');
        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);
        $user->setRole('ROLE_USER');
        $user->setIsTeamManager(false);
        $user->setTeam($this->getReference('team_3'));
        $manager->persist($user);
        $this->addReference('user_11', $user);

        $user = new Users();
        $user->setLastName('Dublin');
        $user->setFirstName('Philipa');
        $user->setEmail('pd@mail.fr');
        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);
        $user->setRole('ROLE_USER');
        $user->setIsTeamManager(false);
        $user->setTeam($this->getReference('team_3'));
        $manager->persist($user);
        $this->addReference('user_12', $user);

        $user = new Users();
        $user->setLastName('Langlais');
        $user->setFirstName('Germain');
        $user->setEmail('gl@mail.fr');
        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);
        $user->setRole('ROLE_USER');
        $user->setIsTeamManager(true);
        $user->setTeam($this->getReference('team_4'));
        $manager->persist($user);
        $this->addReference('user_13', $user);

        $user = new Users();
        $user->setLastName('Lafond');
        $user->setFirstName('Ancelina');
        $user->setEmail('al@mail.fr');
        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);
        $user->setRole('ROLE_USER');
        $user->setIsTeamManager(false);
        $user->setTeam($this->getReference('team_4'));
        $manager->persist($user);
        $this->addReference('user_14', $user);

        $user = new Users();
        $user->setLastName('Moreau');
        $user->setFirstName('Marc');
        $user->setEmail('mm@mail.fr');
        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);
        $user->setRole('ROLE_USER');
        $user->setIsTeamManager(false);
        $user->setTeam($this->getReference('team_4'));
        $manager->persist($user);
        $this->addReference('user_15', $user);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TeamsFixtures::class
        ];
    }
}
