<?php

namespace DevFighters\Utils\Interface;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\State\ProviderInterface;
use DevFighters\Utils\Application\Bus\HandlerBus;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class ApiDataAbstract implements ProviderInterface, ProcessorInterface
{
    protected array $context;
    protected array $uriVariables;
    protected mixed $data;

    public function __construct(
        protected HandlerBus $bus,
        protected Security $security,
        protected EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @return object|object[]|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $this->setApiPlatformVariables(
            uriVariables: $uriVariables,
            context: $context
        );

        return $this->run();
    }

    /**
     * @return object|object[]|void|null
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $this->setData($data);

        $this->setApiPlatformVariables(
            uriVariables: $uriVariables,
            context: $context
        );

        return $this->run();
    }

    abstract public function run();

    protected function setApiPlatformVariables(array $uriVariables, array $context): void
    {
        $this->uriVariables = $uriVariables;
        $this->context = $context;
    }

    protected function setData(mixed $data): void
    {
        $this->data = $data;
    }

    protected function getParametersGET(string|int $parameterName): string|int|array|null
    {
        /** @var string|array|null $variable */
        $variable = $this->context['filters'][$parameterName] ?? null;

        if (false !== filter_var($variable, FILTER_VALIDATE_INT)) {
            return (int) $variable;
        }

        if (false !== filter_var($variable, FILTER_VALIDATE_FLOAT)) {
            return (float) $variable;
        }

        return $variable;
    }

    protected function getParametersURI(string|int $parameterName): string|int|array|null
    {
        return $this->uriVariables[$parameterName] ?? null;
    }

    protected function mapToSingleOutput(?object $entity, string $outputClass): ?object
    {
        return (!is_null($entity)) ? new $outputClass($entity) : null;
    }

    protected function mapToMultipleOutputs(array $entities, string $outputClass): array
    {
        return array_map(
            callback: static fn ($entity) => new $outputClass($entity),
            array: $entities
        );
    }

    protected function getSecurityUser(): UserInterface
    {
        return $this->security->getUser();
    }
}
