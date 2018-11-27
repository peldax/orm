<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\ORM\Relation;

use Spiral\ORM\ORMInterface;
use Spiral\ORM\PromiseInterface;
use Spiral\ORM\Relation;
use Spiral\ORM\RelationInterface;
use Spiral\ORM\State;

abstract class AbstractRelation implements RelationInterface
{
    use Traits\ContextTrait;

    /**
     * @invisible
     * @var ORMInterface
     */
    protected $orm;

    protected $class;

    protected $relation;

    protected $schema;

    /** @var string */
    protected $innerKey;

    /** @var string */
    protected $outerKey;

    public function __construct(ORMInterface $orm, string $class, string $relation, array $schema)
    {
        $this->orm = $orm;
        $this->class = $class;
        $this->relation = $relation;
        $this->schema = $schema;
        $this->innerKey = $this->define(Relation::INNER_KEY);
        $this->outerKey = $this->define(Relation::OUTER_KEY);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        // this is incorrect class
        return sprintf("%s->%s", $this->class, $this->relation);
    }

    public function isRequired(): bool
    {
        if (array_key_exists(Relation::NULLABLE, $this->schema)) {
            return !$this->schema[Relation::NULLABLE];
        }

        return true;
    }

    public function isCascade(): bool
    {
        return $this->schema[Relation::CASCADE] ?? false;
    }

    public function init($data): array
    {
        $item = $this->orm->make($this->class, $data, State::LOADED);

        return [$item, $item];
    }

    public function initPromise(State $state, $data): array
    {
        return [null, null];
    }

    public function extract($data)
    {
        return $data;
    }

    protected function define($key)
    {
        return $this->schema[$key] ?? null;
    }

    protected function getState($entity): ?State
    {
        if ($entity instanceof PromiseInterface) {
            return new State(State::PROMISED, $entity->__context());
        }

        return $this->orm->getHeap()->get($entity);
    }

    protected function getORM(): ORMInterface
    {
        return $this->orm;
    }
}