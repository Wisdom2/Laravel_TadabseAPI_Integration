<?php
  namespace App\HttpClientUtilHelper;
  
  use GuzzleHttp\Client;
  
 class TadabaseServices
  {

      protected $client;

      public function __construct(Client $client)
      {
          $this->client = $client;
      }

      
      public function data_entities()
      {
        return $this->getEndPointRequest('/api/v1/data-tables'); 

      }

      // Describe schema entity
      public function entity_schema($table_id)
      {
        return $this->getEndPointRequest("/api/v1/data-tables/$table_id/fields"); 
      }

      // Show table records
      public function show_entity_records($table_id)
      {
        return $this->getEndPointRequest("/api/v1/data-tables/$table_id/records"); 
      }

      //Put Data
      public function put_data($table_id, $record_id, $form_data)
      {
         return $this->postEndPointRequest("/api/v1/data-tables/$table_id/records/$record_id", $form_data); 
      }

      //Post data
      public function save_data($table_id, $form_data)
      {
         return $this->postEndPointRequest("/api/v1/data-tables/$table_id/records", $form_data); 
      }

      // DELETE record
      public function delete_record($table_id, $record_id)
      {
         return $this->deleteEndPointRequest("/api/v1/data-tables/$table_id/records/$record_id"); 
      }

      // Delete request endpoint
      public function deleteEndPointRequest($url)
      {
        try {
          $response = $this->client->request('DELETE', $url,[
            'headers' => [
                "X-Tadabase-App-id" =>  env('API_ID'),
                "X-Tadabase-App-Key" => env('API_KEY'),
                "X-Tadabase-App-Secret" => env('API_SECRET')
            ]
        ]);

        } catch (\Exception $e) {
                return $e;
        }
    
        return $this->response_handler($response->getBody()->getContents());
      }


      // Get request endpoint
      public function getEndPointRequest($url)
      {
        try {
          $response = $this->client->request('GET', $url,[
            'headers' => [
                "X-Tadabase-App-id" =>  env('API_ID'),
                "X-Tadabase-App-Key" => env('API_KEY'),
                "X-Tadabase-App-Secret" => env('API_SECRET')
            ]
        ]);

        } catch (\Exception $e) {
                return $e;
        }
        
        return $this->response_handler($response->getBody()->getContents());
      }
    

      // Post request endpoint
      public function postEndPointRequest($url, $data)
      {
        
        try {
          $response = $this->client->request('POST', $url, [
            'headers' => [
                'X-Tadabase-App-id' =>  env('API_ID'),
                'X-Tadabase-App-Key' => env('API_KEY'),
                'X-Tadabase-App-Secret' => env('API_SECRET'),
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => $data,
        ]);

        } catch (\Exception $e) {
                return $e;
        }
       
        return $this->response_handler($response->getBody()->getContents());
      }
      
      public function response_handler($response)
      {
        if ($response) {
          return json_decode($response);
        }
        
        return [];
      }
 }
 


?>