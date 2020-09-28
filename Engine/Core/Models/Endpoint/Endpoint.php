<?php

namespace Oforge\Engine\Core\Models\Endpoint;

use Doctrine\ORM\Mapping as ORM;
use Oforge\Engine\Core\Abstracts\AbstractModel;
use Oforge\Engine\Core\Helper\Statics;

/**
 * @ORM\Table(name="oforge_core_endpoints")
 * @ORM\Entity
 */
class Endpoint extends AbstractModel {
    /**
     * @var int
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @var bool
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default":false})
     */
    private $active = false;
    /**
     * @var string
     * @ORM\Column(name="path_name", type="string", nullable=false, unique=true)
     */
    private $name;
    /**
     * @var string
     * @ORM\Column(name="parent_path_name", type="string", nullable=false)
     */
    private $parentName;
    /**
     * @var string
     * @ORM\Column(name="path", type="string", nullable=false)
     */
    private $path;
    /**
     * @var string
     * @ORM\Column(name="context", type="string", nullable=false)
     */
    private $context;
    /**
     * @var string
     * @ORM\Column(name="controller_class", type="string", nullable=false)
     */
    private $controllerClass;
    /**
     * @var string
     * @ORM\Column(name="controller_method", type="string", nullable=false)
     */
    private $controllerMethod;
    /**
     * @var string
     * @ORM\Column(name="http", type="string", nullable=false, options={"default":EndpointMethod::ANY})
     */
    private $httpMethod = EndpointMethod::ANY;
    /**
     * @var string[]
     * @ORM\Column(name="asset_bundles", type="simple_array", nullable=true)
     */
    private $assetBundles = ['Frontend'];

    /**
     * @var int
     * @ORM\Column(name="sort_order", type="integer", nullable=false, options={"default":Statics::DEFAULT_ORDER})
     */
    private $order = Statics::DEFAULT_ORDER;

    /**
     * @return int
     */
    public function getId() : int {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Endpoint
     */
    public function setId(int $id) : Endpoint {
        $this->id = $id;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive() : bool {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return Endpoint
     */
    public function setActive(bool $active) : Endpoint {
        $this->active = $active;

        return $this;
    }

    /**
     * @return string
     */
    public function getName() : string {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Endpoint
     */
    public function setName(string $name) : Endpoint {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getParentName() : string {
        return $this->parentName;
    }

    /**
     * @param string $parentName
     *
     * @return Endpoint
     */
    public function setParentName(string $parentName) : Endpoint {
        $this->parentName = $parentName;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath() : string {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return Endpoint
     */
    public function setPath(string $path) : Endpoint {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getContext() : string {
        return $this->context;
    }

    /**
     * @param string $context
     *
     * @return Endpoint
     */
    public function setContext(string $context) : Endpoint {
        $this->context = $context;

        return $this;
    }

    /**
     * @return string
     */
    public function getControllerClass() : string {
        return $this->controllerClass;
    }

    /**
     * @param string $controllerClass
     */
    protected function setControllerClass(string $controllerClass) : void {
        $this->controllerClass = $controllerClass;
    }

    /**
     * @return string
     */
    public function getControllerMethod() : string {
        return $this->controllerMethod;
    }

    /**
     * @param string $controllerMethod
     */
    protected function setControllerMethod(string $controllerMethod) : void {
        $this->controllerMethod = $controllerMethod;
    }

    /**
     * @return string
     */
    public function getHttpMethod() : string {
        return $this->httpMethod;
    }

    /**
     * @param string $httpMethod
     *
     * @return Endpoint
     */
    public function setHttpMethod(string $httpMethod) : Endpoint {
        $this->httpMethod = $httpMethod;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getAssetBundles() {
        return $this->assetBundles;
    }

    /**
     * @param string[] $assetBundles
     *
     * @return Endpoint
     */
    public function setAssetBundles($assetBundles) : Endpoint {
        $this->assetBundles = $assetBundles;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrder() : int {
        return $this->order;
    }

    /**
     * @param int $order
     */
    public function setOrder(int $order) : void {
        $this->order = $order;
    }
}
