<?php

namespace DevFighters\Utils\Interface;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\State\ProviderInterface;
use DevFighters\Utils\Application\Bus\HandlerBus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @implements ProviderInterface<object>
 * @implements ProcessorInterface<mixed, mixed>
 */
abstract class ApiDataAbstract implements ProviderInterface, ProcessorInterface
{
    /**
     * @var array<string, mixed>
     */
    protected array $context;

    /**
     * @var array<string, string|array<string,string>>
     */
    protected array $uriVariables;
    protected mixed $data;

    public function __construct(
        protected HandlerBus $bus,
        protected Security $security,
        protected EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @param array<string, string|array<string,string>> $uriVariables
     * @param array<string, mixed>                       $context
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $this->setApiPlatformVariables(
            uriVariables: $uriVariables,
            context: $context
        );

        return $this->normalizeResult($this->run());
    }

    /**
     * @param array<string, string|array<string,string>> $uriVariables
     * @param array<string, mixed>                       $context
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        $this->setData($data);

        $this->setApiPlatformVariables(
            uriVariables: $uriVariables,
            context: $context
        );

        return $this->run();
    }

    abstract public function run(): mixed;

    /**
     * @param array<string, string|array<string,string>> $uriVariables
     * @param array<string, mixed>                       $context
     */
    protected function setApiPlatformVariables(array $uriVariables, array $context): void
    {
        $this->uriVariables = $uriVariables;
        $this->context = $context;
    }

    protected function setData(mixed $data): void
    {
        $this->data = $data;
    }

    /**
     * @return string|int|float|bool|array<string|int, mixed>|null
     */
    protected function getParametersGET(string|int $parameterName): string|int|float|bool|array|null
    {
        $filters = $this->context['filters'] ?? null;
        if (!is_array($filters)) {
            return null;
        }

        $variable = $filters[$parameterName] ?? null;

        if (is_scalar($variable) && false !== filter_var($variable, FILTER_VALIDATE_INT)) {
            return (int) $variable;
        }

        if (is_scalar($variable) && false !== filter_var($variable, FILTER_VALIDATE_FLOAT)) {
            return (float) $variable;
        }

        if (is_array($variable) || is_string($variable) || is_int($variable) || is_float($variable) || is_bool($variable) || null === $variable) {
            return $variable;
        }

        return null;
    }

    /**
     * @return string|array<string,string>|null
     */
    protected function getParametersURI(string|int $parameterName): string|array|null
    {
        return $this->uriVariables[$parameterName] ?? null;
    }

    protected function mapToSingleOutput(?object $entity, string $outputClass): ?object
    {
        return (is_null($entity)) ? null : new $outputClass($entity);
    }

    /**
     * @param list<object> $entities
     * @param class-string $outputClass
     *
     * @return list<object>
     */
    protected function mapToMultipleOutputs(array $entities, string $outputClass): array
    {
        return array_map(
            callback: static fn (object $entity): object => new $outputClass($entity),
            array: $entities
        );
    }

    /**
     * @return object|list<object>|null
     */
    private function normalizeResult(mixed $result): object|array|null
    {
        if (is_object($result) || null === $result) {
            return $result;
        }

        if (!$this->isObjectList($result)) {
            return null;
        }

        return $result;
    }

    /**
     * @phpstan-assert-if-true list<object> $value
     */
    private function isObjectList(mixed $value): bool
    {
        if (!is_array($value)) {
            return false;
        }

        return array_all($value, fn ($item): bool => is_object($item));
    }

    protected function getSecurityUser(): UserInterface
    {
        $user = $this->security->getUser();
        if (!$user instanceof UserInterface) {
            throw new \LogicException('Authenticated user is required.');
        }

        return $user;
    }
}
