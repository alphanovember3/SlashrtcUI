<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Reports extends BaseController
{
    // Constructor
    public function __construct()
    {
       helper('form');
    }

    //this function is used to return theb matching string which used for filter in showReport function 
    public function filterMatch($campaign,$userData,$type){

        $prefix = $campaign;
        // Creating a regular expression pattern to match the prefix
        $pattern = "/^" . preg_quote($prefix, '/') . "/";
        //here we are creating one array which will conatain all the campaign names
        if($type == 'campaign'){

            $campaignNames = array_map(function($data) {
                return $data->campaignName;
            }, $userData);
            
        } 
        else{
            
            $campaignNames = array_map(function($data) {
                return $data->agentName;
            }, $userData);

        }
        //preg_grep function is used to to check if the pattern is present in $campaignnames array if present then put the matching campaigname in the array
        $matchingCampaignNames = preg_grep($pattern, $campaignNames);

        if($matchingCampaignNames){
            //current function is used to access the first element of the array
            $campaign = current($matchingCampaignNames);
        }
        return $campaign;
    }


//show all the caller report data in frontend
    public function showReport($reportNo) {

        helper('form', 'helper');
        if($reportNo == 1){
            
            // API URL
            $apiUrl = 'http://192.168.0.133:8080/mysql/callreport/getall';
        }
    
        else if($reportNo == 2){
            
            // API URL
            $apiUrl = 'http://192.168.0.133:8080/mongo/callreport/getall';
        }
        else{
            
            // API URL
            $apiUrl = 'http://192.168.0.133:8080/elastic/callreport/getall';
        }
    
        // Fetch the API response
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // Executing the curl request
        $response = curl_exec($curl);
        curl_close($curl);
    
        // Decode the JSON response
        $userData = json_decode($response);


        //Filter Logic :

        $agent = $this->request->getGet('agent');
        $campaign = $this->request->getGet('campaign');
        $calltype = $this->request->getget('calltype');


        if ($agent || $campaign || $calltype) {

           
            if($campaign){
                $campaign = $this->filterMatch($campaign,$userData,'campaign');

            }
            if($agent){

                $agent = $this->filterMatch($agent,$userData,'agent');
            }

            //main filter logic 
            $newUserData = array_filter($userData, function($data) use ($agent,$campaign,$calltype) {

                

                if($agent && $campaign && $calltype){
                    
                    return ($data->agentName == $agent && $data->campaignName == $campaign && $data->calltype == $calltype );
                }
              
                else if($calltype && $agent){
                    return ($data->calltype == $calltype && $data->agentName == $agent) ;
                    
                }
                else if($calltype && $campaign){
                    return ($data->calltype == $calltype && $data->campaignName == $campaign) ;
                    
                }
                else if($agent && $campaign){
                    return ($data->agentName == $agent && $data->campaignName == $campaign) ;
                    
                }
                else if($agent){
                    
                    return ($data->agentName == $agent) ;
                }
                else if($campaign){
                    return ($data->campaignName == $campaign) ;
                    
                }
                else if($calltype){
                    return ($data->calltype == $calltype) ;
                    
                }
            });
        
            $userData =  $newUserData;

        
        }
        
        
        
       
        // Pagination Logic        
        // Load Pagination library 
        $pager = \Config\Services::pager(); 
        $page = $this->request->getVar('page') ? $this->request->getVar('page') : 1; 
        // Number of records per page
        $perPage = 5; 
        // Calculate the offset 
        $offset = ($page - 1) * $perPage;
        
        // Slice the user data for the current page
        $pagedData = array_slice($userData, $offset, $perPage);
    
        // Get the total number of rows for pagination 
        $totalRows = sizeof($userData);
        
       
        // Showing data to the frontend
        $data['pagename'] = 'report';
        $data['pagedata'] = [
            'callerdata' => $pagedData, 
            'pager' => $pager->makeLinks($page, $perPage, $totalRows, 'default_full'),
            'reportNo'=>$reportNo
        ];
    
        echo view('template', $data);
    }
    

    // Function where we will download the reports from SQL or MongoDB or Elasticsearch
    public function getSummaryReport($reportNo)
    {
        // API URL
       

        if($reportNo == 1){
            // API URL
            $apiUrl = 'http://192.168.0.133:8080/mysql/callreportSummary/get';
            
        }
        else if($reportNo == 2){
            // API URL
            $apiUrl = 'http://192.168.0.133:8080/mongo/callreportSummary/get';
            
        }
        else {
            // API URL
            $apiUrl = 'http://192.168.0.133:8080/elastic/callreportSummary/get';
            
        }

        // Fetch the API response
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // Executing the curl request
        $response = curl_exec($curl);
        curl_close($curl);

        // Decode the JSON response
        $userData = json_decode($response);

        
       
      //Excel sheet creation using spreadsheet library 

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="summaryReport.xlsx"');
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'Total_Calls');
        $activeWorksheet->setCellValue('B1', 'Call_Hour');
        $activeWorksheet->setCellValue('C1', 'Call_Answered');
        $activeWorksheet->setCellValue('D1', 'Call_Autodrop');
        $activeWorksheet->setCellValue('E1', 'Call_Autofail');
        $activeWorksheet->setCellValue('F1', 'Talktime');
    
            $num =2;

        foreach($userData as $data1){

            if($reportNo == 3){

                $activeWorksheet->setCellValue('A'.$num, $data1->doc_count);
                $activeWorksheet->setCellValue('B'.$num, $data1->key_as_string);   
                $activeWorksheet->setCellValue('C'.$num, $data1->AnsweredCount->doc_count);   
                $activeWorksheet->setCellValue('D'.$num, $data1->dropCount->doc_count);   
                $activeWorksheet->setCellValue('E'.$num, $data1->failCount->doc_count);   
                $activeWorksheet->setCellValue('F'.$num, $data1->Talktime->value);   
                 $num++;
            }
            else if($reportNo == 2){

                
                $activeWorksheet->setCellValue('A'.$num, $data1->Total_Calls);
                $activeWorksheet->setCellValue('B'.$num, $data1->_id.'-'.$data1->_id+1);   
                $activeWorksheet->setCellValue('C'.$num, $data1->Call_Answered);   
                $activeWorksheet->setCellValue('D'.$num, $data1->Call_Autodrop);   
                $activeWorksheet->setCellValue('E'.$num, $data1->Call_Autofail);   
                $activeWorksheet->setCellValue('F'.$num, $data1->Talktime);   
                 $num++;
            } 
            else {

                
                $activeWorksheet->setCellValue('A'.$num, $data1->Total_Calls);
                $activeWorksheet->setCellValue('B'.$num, $data1->Call_Hour.'-'.$data1->Call_Hour+1);   
                $activeWorksheet->setCellValue('C'.$num, $data1->Call_Answered);   
                $activeWorksheet->setCellValue('D'.$num, $data1->Call_Autodrop);   
                $activeWorksheet->setCellValue('E'.$num, $data1->Call_Autofail);   
                $activeWorksheet->setCellValue('F'.$num, $data1->Talktime);   
                 $num++;
            } 
        }
    
        $writer = new Xlsx($spreadsheet);
        $writer->save("php://output");
       
       
    }

        //CDR report in excel file using sql mongo elastic api
    public function getLoggerReport($reportNo)
    {   

        if($reportNo == 1){
            // API URL
            $apiUrl = 'http://192.168.0.133:8080/mysql/callreport/getall';
            
        }
        else if($reportNo == 2){
            // API URL
            $apiUrl = 'http://192.168.0.133:8080/mongo/callreport/getall';
            
        }
        else {
            // API URL
            $apiUrl = 'http://192.168.0.133:8080/elastic/callreport/getall';
            
        }


        // Fetch the API response
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // Executing the curl request
        $response = curl_exec($curl);
        curl_close($curl);

        // Decode the JSON response
        $userData = json_decode($response);

       
      //Excel sheet creation using spreadsheet library 

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="loggerReport.xlsx"');
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'Datetime');
        $activeWorksheet->setCellValue('B1', 'CallType');
        $activeWorksheet->setCellValue('C1', 'Disposition Type');
        $activeWorksheet->setCellValue('D1', 'callDuration');
        $activeWorksheet->setCellValue('E1', 'AgentName');
        $activeWorksheet->setCellValue('F1', 'campaignName');
        $activeWorksheet->setCellValue('G1', 'processName');
        $activeWorksheet->setCellValue('H1', 'leadsetId');
        $activeWorksheet->setCellValue('I1', 'referenceUuid');
        $activeWorksheet->setCellValue('J1', 'customerUuid');
        $activeWorksheet->setCellValue('K1', 'holdTime');
        $activeWorksheet->setCellValue('L1', 'muteTime');
        $activeWorksheet->setCellValue('M1', 'ringingTime');
        $activeWorksheet->setCellValue('N1', 'transferTime');
        $activeWorksheet->setCellValue('O1', 'conferenceTime');
        $activeWorksheet->setCellValue('P1', 'callTime');
        $activeWorksheet->setCellValue('Q1', 'disposeTime');
        $activeWorksheet->setCellValue('R1', 'disposeName');
    
            $num =2;
        foreach($userData as $data1){
             
            $activeWorksheet->setCellValue('A'.$num, $data1->datetime);
            $activeWorksheet->setCellValue('B'.$num, $data1->calltype);   
            $activeWorksheet->setCellValue('C'.$num, $data1->disposeType);   
            $activeWorksheet->setCellValue('D'.$num, $data1->callDuration);   
            $activeWorksheet->setCellValue('E'.$num, $data1->agentName);   
            $activeWorksheet->setCellValue('F'.$num, $data1->campaignName);   
            $activeWorksheet->setCellValue('G'.$num, $data1->processName);   
            $activeWorksheet->setCellValue('H'.$num, $data1->leadsetId);   
            $activeWorksheet->setCellValue('I'.$num, $data1->referenceUuid);   
            $activeWorksheet->setCellValue('J'.$num, $data1->customerUuid);   
            $activeWorksheet->setCellValue('K'.$num, $data1->holdTime);   
            $activeWorksheet->setCellValue('L'.$num, $data1->muteTime);   
            $activeWorksheet->setCellValue('M'.$num, $data1->ringingTime);   
            $activeWorksheet->setCellValue('N'.$num, $data1->transferTime);   
            $activeWorksheet->setCellValue('O'.$num, $data1->conferenceTime);   
            $activeWorksheet->setCellValue('P'.$num, $data1->callTime);   
            $activeWorksheet->setCellValue('Q'.$num, $data1->disposeTime);   
            $activeWorksheet->setCellValue('R'.$num, $data1->disposeName);   
             $num++;
        }
    
        $writer = new Xlsx($spreadsheet);
        $writer->save("php://output");
       
       
    }


        
//show all the caller summary report data in frontend
public function showSummaryReport($reportNo) {

    if($reportNo == 1){
        
        // API URL
        $apiUrl = 'http://192.168.0.133:8080/mysql/callreportSummary/get';
    }

    else if($reportNo == 2){
        
        // API URL
        $apiUrl = 'http://192.168.0.133:8080/mongo/callreportSummary/get';
    }
    else{
        
        // API URL
        $apiUrl = 'http://192.168.0.133:8080/elastic/callreportSummary/get';
    }

    // Fetch the API response
    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // Executing the curl request
    $response = curl_exec($curl);
    curl_close($curl);

    // Decode the JSON response
    $userData = json_decode($response);
    
   
    // Pagination Logic        
    // Load Pagination library 
    $pager = \Config\Services::pager(); 
    $page = $this->request->getVar('page') ? $this->request->getVar('page') : 1; 
    // Number of records per page
    $perPage = 8; 
    // Calculate the offset 
    $offset = ($page - 1) * $perPage;
    
    // Slice the user data for the current page
    $pagedData = array_slice($userData, $offset, $perPage);

    // Get the total number of rows for pagination 
    $totalRows = sizeof($userData);

    // Showing data to the frontend
    $data['pagename'] = 'summaryReport';
    $data['pagedata'] = [
        'callerdata' => $pagedData, 
        'pager' => $pager->makeLinks($page, $perPage, $totalRows, 'default_full'),
        'reportNo' => $reportNo
    ];

    echo view('template', $data);
} 


   
}


