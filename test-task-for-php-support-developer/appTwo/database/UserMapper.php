<?php

class UserMapper
{
    /** @var PDO */
    private $adapter;

    /** @param PDO $storage */
    public function __construct(PDO $storage)
    {
        $this->adapter = $storage;
    }

    /**
     * finds a user from storage based on ID and returns a User object
     * @param int $id
     * @return User
     */
    public function findById(int $id): User
    {
        $result = $this->adapter->prepare("SELECT * FROM users WHERE user_id=?");
        $result->execute([$id]);

        if ($result === null) {
            throw new InvalidArgumentException("User #$id not found");
        }

        return $this->mapRowToUser($result->fetch());
    }

    public function save(User $user)
    {
        if ($user->getId()) {
            $result = $this->adapter->prepare("UPDATE users SET user_data =:data WHERE user_id =:id");
            $result->execute($user->getUserData());
        }
        $result = $this->adapter->prepare("INSERT INTO users (user_data) VALUES (?)");
        $result->execute([$user->getUserData()]);

        $id = $this->adapter->lastInsertId();
        $user->setId($id);
    }

    private function mapRowToUser(array $row): User
    {
        return User::fromState($row);
    }
}