<?php


class User
{
    /**
     * @var string
     */
    private $userData;
    /**
     * @var int|null
     */
    private $id;

    /**
     * @param array $state
     * @return User
     */
    public static function fromState(array $state): User
    {
        return new self(
            $state['user_data'],
            $state['user_id']
        );
    }

    /**
     * User constructor.
     * @param string $userData
     * @param int|NULL $id
     */
    public function __construct(string $userData, int $id = NULL)
    {
        $this->userData = $userData;
        $this->id = $id ?? null;
    }

    /**
     * @return string
     */
    public function getUserData()
    {
        return $this->userData;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}