<?php

class CurlPost
{
    private $url;

    /**
     * @param string $url Request URL
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Get the response from Point 3
     * @param string $postData
     * @return string
     * @throws Exception
     */
    public function execute(string $postData): string
    {
        try {
            $ch = curl_init($this->url);

            /** Check if initialization has gone wrong */
            if ($ch === false) {
                throw new Exception('failed to initialize');
            }
            $postData = ["json" => $postData];

            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

            $content = curl_exec($ch);

            /** Check the return value of curl_exec(), too */
            if ($content === false) {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }

            curl_close($ch);

            return $content;
        } catch(Exception $e) {

            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);
        }
    }
}