<?php
namespace Oforge\Engine\Auth\Models\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="oforge_auth_backend_user")
 * @ORM\HasLifecycleCallbacks
 */
class BackendUser extends BaseUser {
    /**
     * TODO: This values should not be constants. What if we want to add a new role?
     */
    public const ROLE_PUBLIC        = -2;
    public const ROLE_LOGGED_IN     = -1;
    public const ROLE_SYSTEM        = 0;
    public const ROLE_ADMINISTRATOR = 1;
    public const ROLE_MODERATOR     = 2;
    /**
     * @var string
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;
    /**
     * 0 = admin, 1 = moderator, 2 = other
     *
     * @var int
     * @ORM\Column(name="role", type="integer", nullable=false)
     */
    private $role;

    public function __construct() {
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getName() : string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name) : void {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getRole() : int {
        return $this->role;
    }

    /**
     * @param $role int
     */
    public function setRole($role) {
        $this->role = $role;
    }
}
