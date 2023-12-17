<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
*/
namespace Luminova\ExtraUtils\Payment\Http;

use Luminova\ExtraUtils\Payment\Merchants\Clients;
use Luminova\ExtraUtils\Payment\Exceptions\PaymentException;
use Luminova\ExtraUtils\Payment\Http\Response;

class Network {
   /**
    * @var string $authorizationBearer header bearer token
   */
   private $authorizationBearer = '';

   /**
    * @var string $merchantName merchant name
   */
   private string $merchantName = '';

   /**
    * @param string $auth auth bearer token
   */
   public function __construct(string $auth)
   {
      $this->authorizationBearer = $auth; 
   }

   /**
    * Set merchant name 
    * @param string $name 
    * @return void 
   */
   public function setMerchantName(string $name): void 
   {
      $this->merchantName = $name;
   }

   /**
    * Send network request 
    * @param string $url api endpoint
    * @param string $method api request method 
    * @param array $params api request parameters
    * @param bool $extra 
    *
    * @return Response new Response instance
    * @throws PaymentException
   */
   public function request(string $url, string $method = 'GET', ?array $params = null, bool $extras = false): Response 
   {
      $method = strtoupper($method);
      if (!in_array($method, ['GET', 'POST'])) {
         throw new PaymentException('Invalid request method. Supported methods: GET, POST.');
      }

      $curl = curl_init();
      $postField = $this->buildParams($params);
      $sendHeaders = [
         'Authorization: Bearer ' . $this->authorizationBearer,
         "Cache-Control: no-cache",
      ];
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_HEADER, true);
      if($extras){
         curl_setopt($curl,CURLOPT_ENCODING, '');
         curl_setopt($curl,CURLOPT_MAXREDIRS, 10);
         curl_setopt($curl,CURLOPT_TIMEOUT, 30);
         curl_setopt($curl,CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      }

    
      if($method === 'GET'){
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
      }else{
         curl_setopt($curl,CURLOPT_POST, true);
         $sendHeaders['Content-Type'] = 'application/json';
      }
     
      if($postField !== ''){
         curl_setopt($curl, CURLOPT_POSTFIELDS, $postField);
      }

      curl_setopt($curl, CURLOPT_HTTPHEADER, $sendHeaders);

      $response = curl_exec($curl);
      $error =  (object)[];
      $headers = [];
      $body = [];
      $status = 0;
      
      if ($response === false) {
         $error = (object)[
            'message' => curl_error($curl),
            'code' => curl_errno($curl),
         ];
      }else{
         $info = curl_getinfo($curl);
         $status = $info['http_code'] ?? 0;
         $headerSize = $info['header_size'] ?? 0;
         $returnHeaders = substr($response, 0, strpos($response, "\r\n\r\n"));
         $body = substr($response, $headerSize);
         $headers = $this->headersArray($returnHeaders, $status);
      }

      curl_close($curl);
      return new Response((object) [
         'statusCode' => $status,
         'headers' => $headers,
         'error' => $error, 
         'body' => $body,
         'response' => $response
      ]);
   }

   /**
    * Parse query parameters.
    *
    * @param array|null $params The array of parameters to parse (optional).
    *
    * @return string The parsed query parameters as a string.
   */
   private function buildParams(?array $params = null): string 
   {
      if ($params === null || $params === []) {
         return '';
      }

      if ($this->merchantName === Clients::PAY_STACK) {
         $params = http_build_query($params);
      }

      if (is_array($params)) {
         $params = json_encode($params);
      }

      if ($params === false) {
         return '';
      }

      return $params;
   }

   /**
   * Convert a raw header string to an associative array.
   *
   * @param string $header
   * @param int $code
   *
   * @return array
   */
   private function headersArray(string $header, int $code): array
   {
      $headers = ['statusCode' => $code];
      foreach (explode("\r\n", $header) as $i => $line) {
         if ($i === 0) {
               $headers['http_code'] = $line;
         } else {
               [$key, $value] = explode(': ', $line);
               $headers[$key] = $value;
         }
      }
      return $headers;
   }
}
