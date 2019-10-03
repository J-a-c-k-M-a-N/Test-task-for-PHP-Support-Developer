<?php

require_once ROOT.'/config/Registry.php';
require_once ROOT.'/services/OpensslRSA.php';
require_once ROOT.'/components/DataBase.php';
require_once ROOT.'/entity/User.php';
require_once ROOT.'/database/UserMapper.php';

/**
 * Class DataVerification
 */
class DataVerification
{
    private $encryptData;
    private $dataJSON;

    /**
     * DataVerification constructor.
     * @param string $dataJSON result from Point 2
     * @param string $encryptData from Point 2
     */
    public function __construct(string $encryptData, string $dataJSON)
    {
        $this->encryptData = $encryptData;
        $this->dataJSON = $dataJSON;
    }

    /**
     * Return result from point 3
     * @return string|bool
     */
    public function execute()
    {
        $encryptData = $this->getEncryptData();
        $dataJSON = $this->getData();

        $decryptDataJson = OpensslRSA::decryptDataByPrivKey($encryptData);

        $result = $this->isValid($dataJSON, $decryptDataJson);

        if ($result) {
            /** connection to db*/
            $db = DataBase::getInstance();
            $user = new User($dataJSON);
            $mapper = new UserMapper($db);

            /** User's data saving to db */
            $mapper->save($user);

            $id = $user->getId();

            /** Data get from db by id */
            $dataFromDb = $mapper->findById($id)->getUserData();

            $encryptDataFromDb = OpensslRSA::encryptDataByPublKey($dataFromDb);

            return $encryptDataFromDb;
        }
        return false;
    }

    public function getEncryptData(): string
    {
        return $this->encryptData;
    }

    public function getData(): string
    {
        return $this->dataJSON;
    }

    /**
     * @param string $data from Point 2
     * @param string $decryptDataHash
     * @return bool
     */
    private function isValid(string $data, string $decryptDataHash): bool
    {
        $resultValidation = ($data === $decryptDataHash) ?? false;

        return $resultValidation;
    }

}