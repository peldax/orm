<?php

declare(strict_types=1);

namespace Cycle\ORM\Tests\Functional\Driver\MySQL\Relation\HasMany\Cyclic;

// phpcs:ignore
use Cycle\ORM\Tests\Functional\Driver\Common\Relation\HasMany\Cyclic\CyclicHasManyReferencesWithCompositePKTest as CommonTest;

/**
 * @group driver
 * @group driver-mysql
 */
class CyclicHasManyReferencesWithCompositePKTest extends CommonTest
{
    public const DRIVER = 'mysql';
}