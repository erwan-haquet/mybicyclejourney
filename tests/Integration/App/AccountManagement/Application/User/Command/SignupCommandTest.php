<?php

namespace Tests\Integration\App\AccountManagement\Application\User\Command;

use App\AccountManagement\Domain\User\Model\UserId;
use App\AccountManagement\Domain\User\Repository\UserRepositoryInterface;
use Library\CQRS\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Uid\Uuid;
use Tests\Fixtures\App\AccountManagement\Application\User\Command\SignupFactory;

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
        
        // Assert that user does not already exist
        $user = $this->userRepository->findById($id);
        $this->assertNull($user);

        $command = SignupFactory::new(id: $id);
        $this->commandBus->handle($command);

        $user = $this->userRepository->findById($id);
        $this->assertNotNull($user);
    }
    
    public function testICanNotRegisterWithAlreadyExistingEmail(): void
    {
        $email = 'erwan@mybicyclejourney.com';

        // Register the user once
        $command = SignupFactory::new(email: $email);
        $this->commandBus->handle($command);
        $user = $this->userRepository->findByEmail($email);
        $this->assertNotNull($user);

        $command = SignupFactory::new(email: $email);
        
        $this->expectException(ValidationFailedException::class);
        $this->commandBus->handle($command);
    }

    public function testICanNotSignupWithInvalidEmail(): void
    {
        $invalidEmail = 'invalid email';
        $command = SignupFactory::new(email: $invalidEmail);

        $this->expectException(ValidationFailedException::class);
        $this->commandBus->handle($command);
    }

    /**
     * @dataProvider invalidPasswordProvider
     */
    public function testICanNotSignupWithInvalidPassword($password): void
    {
        $command = SignupFactory::new(plainPassword: $password);

        $this->expectException(ValidationFailedException::class);
        $this->commandBus->handle($command);
    }

    private function invalidPasswordProvider(): array
    {
        return array(
            ['', 'blank password'],
            ['mYpA22', 'lower than 6 character password'],
            ['mysup3erpass', 'missing uppercase character password'],
            ['mySupErpAss', 'missing numeric character password'],
            ['T3STOFPASSWORD', 'missing lowercase character password'],
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->commandBus = null;
        $this->userRepository = null;
    }
}
