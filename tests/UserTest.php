<?php

namespace App\Tests;

use App\Entity\PhoneNumber;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    /** @var EntityManagerInterface */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        DatabasePrimer::prime($kernel);

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }

    /** @test */
    public function a_user_record_can_be_created_in_the_database()
    {
        $user = new User();
        $user->setName('John Doe');
        $user->setEmail('john.doe@example.com');
        $user->setDateOfBirth(new \DateTime('1992-01-01'));
        $phoneNumber = new PhoneNumber();
        $phoneNumber->setUser($user);
        $phoneNumber->setPhoneNumber('+36205555551');
        $user->addPhoneNumber($phoneNumber);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $userRepository = $this->entityManager->getRepository(User::class);
        /** @var User $userRecord */
        $userRecord = $userRepository->findOneBy(['email' => 'john.doe@example.com']);

        $this->assertEquals('John Doe', $userRecord->getName());
        $this->assertEquals('john.doe@example.com', $userRecord->getEmail());
        $this->assertEquals('1992-01-01', $userRecord->getDateOfBirth()->format('Y-m-d'));
        $this->assertEquals($userRecord, $userRecord->getPhoneNumbers()->get(0)->getUser());
        $this->assertEquals('+36205555551', $userRecord->getPhoneNumbers()->get(0)->getPhoneNumber());
    }
}
