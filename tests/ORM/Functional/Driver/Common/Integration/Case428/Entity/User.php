<?php

declare(strict_types=1);

namespace Cycle\ORM\Tests\Functional\Driver\Common\Integration\Case428\Entity;

class User
{
    public const ROLE = 'user';

    public ?int $id = null;
    public ?self $user = null;
    public iterable $users = [];
}
