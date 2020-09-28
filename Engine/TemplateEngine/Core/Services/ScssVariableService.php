<?php

namespace Oforge\Engine\TemplateEngine\Core\Services;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Oforge\Engine\Core\Abstracts\AbstractDatabaseAccess;
use Oforge\Engine\Core\Exceptions\NotFoundException;
use Oforge\Engine\TemplateEngine\Core\Exceptions\InvalidScssVariableException;
use Oforge\Engine\TemplateEngine\Core\Models\ScssVariable;
use ReflectionException;

/**
 * Class ScssVariableService
 *
 * @package Oforge\Engine\TemplateEngine\Core\Services
 */
class ScssVariableService extends AbstractDatabaseAccess {

    public function __construct() {
        parent::__construct(["default" => ScssVariable::class]);
    }

    /**
     * @param $scope
     * @param $context
     *
     * @return array|object[]
     */
    public function get($context, $scope = 'Frontend') {
        return $this->repository()->findBy(['scope' => $scope, 'context' => $context]);
    }

    public function getScope($scope) {
        return $this->repository()->findBy(['scope' => $scope]);
    }

    /**
     * @param $id
     * @param $value
     *
     * @throws NotFoundException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update($id, $value) {
        /** @var ScssVariable $element */
        $element = $this->repository()->findOneBy(['id' => $id]);
        if (!isset($element)) {
            throw new NotFoundException("Element with id " . $id . " not found!");
        }

        $element->setValue($value);
        $this->entityManager()->update($element);
    }

    /**
     * @param $templateVariable
     *
     * @throws InvalidScssVariableException
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws ReflectionException
     */
    public function add($templateVariable) {
        if (!isset($templateVariable['scope'])) {
            $templateVariable['scope'] = 'Frontend';
        }

        if (!isset($templateVariable['siteId'])) {
            $templateVariable['siteId'] = 0;
        }

        $this->isValid($templateVariable);

        $element = $this->repository()->findOneBy([
            'name'    => $templateVariable['name'],
            'context' => $templateVariable['context'],
            'scope'   => $templateVariable['scope'],
            'siteId'  => $templateVariable['siteId'],
        ]);

        if (!isset($element)) {
            $element = new ScssVariable();

            $element->fromArray($templateVariable);
            $this->entityManager()->create($element);
        }
    }

    /**
     * @param $templateVariable
     *
     * @return bool
     * @throws InvalidScssVariableException
     */
    private function isValid($templateVariable) {
        $options = [
            'name',
            'value',
            'type',
            'context',
        ];

        foreach ($options as $option) {
            if (!isset($templateVariable[$option])) {
                throw new InvalidScssVariableException($option, $templateVariable);
            }
        }

        if (isset($templateVariable['scope'])) {
            $scopes = ['Frontend', 'Backend'];
            if (!in_array($templateVariable['scope'], $scopes)) {
                throw new InvalidScssVariableException('scope', $templateVariable);
            }
        }

        return true;
    }
}
