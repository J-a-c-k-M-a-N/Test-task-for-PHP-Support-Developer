<?php

// POINT 2

require_once ROOT.'/services/DataValidate.php';
require_once ROOT.'/services/OpensslRSA.php';
require_once ROOT.'/config/Registry.php';
require_once ROOT.'/components/CurlPost.php';

class DataService
{
    private $data;

    const EMPTY_STRING = "[]";

    /**
     * DataService constructor.
     * @param string $data from index.php
     */
    public function __construct(string $data)
    {
        /* @var $data JSON */
        $this->data = $data;
    }

    public function getData(): string
    {
        return $this->data;
    }

    /**
     * Return result from point 3.
     * It return json data or error.
     * @return string
     * @throws Exception
     */
    public function execute(): string
    {
        $data = $this->getData();
        $dataArrayValidate = $this->validate($data);

        $dataValidated = $dataArrayValidate['dataValidated'];
        $errors = $dataArrayValidate['errors'];

        /** Check if has errors when data validated */
        if (!($errors === self::EMPTY_STRING)) {
            return $errors;
        }

        $encryptData = OpensslRSA::encryptDataByPublKey($dataValidated);

        $endpoint_3 = Registry::$curlPath;

        $data = array(
            "dataJSON" => $dataValidated,
            "encryptData" => utf8_encode($encryptData),
        );
        $postData = json_encode($data);

        $curlRequest = new CurlPost($endpoint_3);

        /** Result from Point 3 */
        $result = $curlRequest->execute($postData);

        try {
            if (!$result) {
                throw new Exception('Data is not verified!');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
        $resultDecode = utf8_decode(json_decode($result,TRUE));

        $encryptData = OpensslRSA::decryptDataByPrivKey($resultDecode);

        return $encryptData;
    }

    /**
     * Return array of errors and data validated
     * @param string $data json
     * @return array
     */
    private function validate(string $data): array
    {
        $dataArray = json_decode($data, true);
        $validation = new DataValidate($dataArray);

        $dataValidated = json_encode($validation->execute());
        $errors = json_encode($validation->getErrors());

        return array(
            'errors' => $errors,
            'dataValidated' => $dataValidated
        );
    }
}