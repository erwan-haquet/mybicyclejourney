<?php

namespace App\AccountManagement\Application\User\Command;

use App\AccountManagement\Domain\User\Model\UserId;
use Library\CQRS\Command\Command;

/**
 * Verify the user email.
 * This command is triggered after user clicked on a link in welcome email.
 */
class VerifyUserEmail extends Command
{
    public UserId $id;
    
    public string $uri;
}
