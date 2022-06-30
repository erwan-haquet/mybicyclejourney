<?php

namespace Tests\Integration\App\AccountManagement\Application\User\Command;

use App\AccountManagement\Application\User\Command\Signup;
use App\AccountManagement\Domain\User\Model\UserId;
use App\AccountManagement\Domain\User\Repository\UserRepositoryInterface;
use App\Supporting\Domain\I18n\Model\Locale;
use Library\CQRS\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Uid\Uuid;

class SignupCommandTest extends KernelTestCase
{
    private ?UserRepositoryInterface $userRepository;
    private ?CommandBus $commandBus;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = static::getContainer();
        $this->commandBus = $container->get('Library\CQRS\Command\CommandBus');
        $this->userRepository = $container->get('App\AccountManagement\Domain\User\Repository\UserRepositoryInterface');
    }

    public function testICanSignupWithValidEmailAndPassword(): void
    {
        $id = UserId::fromString(Uuid::v4());
        
        $command = new Signup([
            'id' => $id,
            'locale' => Locale::from('EN'),
            'email' => 'erwan@mybicyclejourney.com',
            'plainPassword' => 'teIUHhlls09t',
        ]);
        
        $user = $this->userRepository->findByEmail('erwan@mybicyclejourney.com');
        $this->assertNull($user);
        
        $this->commandBus->handle($command);

        $user = $this->userRepository->findByEmail('erwan@mybicyclejourney.com');
        $this->assertNotNull($user);
        $this->assertTrue($user->id()->equals($id));
    }

    public function testICanNotSignupWithInvalidEmail(): void
    {
        $invalidEmail = 'invalid email';
        
        $command = new Signup([
            'id' => UserId::fromString(Uuid::v4()),
            'locale' => Locale::from('EN'),
            'email' => $invalidEmail,
            'plainPassword' => 'teIUHhlls09t',
        ]);
        
        $this->expectException(ValidationFailedException::class);
        $this->commandBus->handle($command);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->commandBus = null;
        $this->userRepository = null;
    }
}
