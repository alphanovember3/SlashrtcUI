<?php

namespace App\Controllers;

// this files and libs imported for the file upload and download

use App\Models\UserModel;
use App\Models\LoginModel;
use App\Models\AccessModel;



class Home extends BaseController
{
    protected $user;
    protected $loginUser;
    protected $accessUser;
    protected $pager;
    
    
    public function __construct()
    {
        
        helper(['url']);
        $this->user = new UserModel();
        
        $this->loginUser = new LoginModel();
        $this->accessUser = new AccessModel();
        $this->pager = \Config\Services::pager();
       
        
    }
    public function index()
    {

        $session = session();

        $firstname = session()->get('firstname');

        

        // Check if the user is logged in
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        //access levels sql query
        
        
        
        
        $data['pagename'] = 'home';
        

        
        // Database connection 
        $db = \Config\Database::connect();

$page = $this->request->getVar('page') ? $this->request->getVar('page') : 1; 

// Number of records per page
$perPage = 3; 
// Calculate the offset 
$offset = ($page - 1) * $perPage; 
// Custom query with LIMIT and OFFSET 

$filterdata = $this->request->getGet('role');

$search = $this->request->getGet('search');

if($filterdata){
    
    // $query = "SELECT *, (SELECT level FROM accesslevel WHERE accesslevel.id = users.role) as accessname FROM users WHERE users.role = $filterdata LIMIT $perPage OFFSET $offset"; 
    $query = "SELECT *, (SELECT level FROM accesslevel WHERE accesslevel.id = users.role) as accessname FROM users WHERE users.role = $filterdata"; 
    if (!empty($search)) {
         $query .= " AND (users.email LIKE '%$search%')";
     } 
    $query .= " LIMIT $perPage OFFSET $offset";



}
else if($search){

    $query = "SELECT *, (SELECT level FROM accesslevel WHERE accesslevel.id = users.role) as accessname FROM users WHERE users.email LIKE '%$search%' LIMIT $perPage OFFSET $offset";

}
else{
    
    $query = "SELECT *, (SELECT level FROM accesslevel WHERE accesslevel.id = users.role) as accessname FROM users LIMIT $perPage OFFSET $offset"; 
}

// Get the total number of rows for pagination 
$totalRows = $db->query("SELECT COUNT(*) as count FROM users")->getRow()->count; 
// Execute the query 
$resultTable = $db->query($query); 
$result = $resultTable->getResult(); 
// Load Pagination library 
$pager = \Config\Services::pager(); 

$role = session()->get('role');
// session()->set('role', $newRole);




$data['pagedata'] = [ 'accessuser' => $result, 'pager' => $pager->makeLinks($page, $perPage, $totalRows, 'default_full'),'filterdata'=>$filterdata];



        echo view('template',$data);

        
    }


    //function for save user
    public function saveUser(){

        $username = $this->request->getVar('username');
        $role = $this->request->getVar('email');

        $this->user->save(["email" => $username, "role"=>$role]);
        
        session()->setFlashdata("success","data inserted successfully");
        return redirect()->to(base_url());
    }

    public function getSingleUser($id){

        // first() function will get the details and store it in variable  
        $data = $this->user->where('id',$id)->first();

        //this echo will send the response  for the ajax function

        echo json_encode($data);
    }


    //for update the user
    public function updateUser(){
        
        // now we will get the updated value of the variable by his name 
        $id = $this->request->getVar('updateId');

        $role = $this->request->getVar('role');

        $email = $this->request->getVar('username');

        // now we will store the updated value in the array

        $data['role'] = $role;
        $data['email'] = $email;

        //now we wiil update the data into database using update function

        $this->user->update($id,$data);

       
        return redirect()->to(base_url());

    }

    public function deleteUser(){

        //this $id is coming from data section of the ajax 
        
        $id = $this->request->getVar('id');
       
        $this->user->delete($id);
        
        // return redirect()->to(base_url());
        //here redirect function is not working so we are gonna send response to ajax and from there we will return the window
        //now we will return deleted
        return "deleted";
       
    }

    
  

    // public function search(){
    //      if ($this->request->getMethod() === 'post') { $selectedOption = $this->request->getPost('option'); 
    //         // Fetch data based on the selected option 
    //         $db = \Config\Database::connect();
    //          $query = "SELECT *, (SELECT level FROM accesslevel WHERE accesslevel.id = users.role) as accessname FROM users"; 
    //          $resultTable = $db->query($query); 
    //          $result = $resultTable->getResult(); 
    //          // Filter the results manually 
    //          $filteredBooks = []; foreach ($result as $row) { if ($row->category == $selectedOption) { $filteredBooks[] = $row; } } 
    //          // Send the data as JSON return
    //         $this->response->setJSON($filteredBooks);
    //      }
    // }

    public function chatApp(){

        if(!session()->get('isLoggedIn')){
            return redirect()->to('/login');
        }

        // echo view('inc/header');
        $data['loginDetails'] =  session()->get();
        $data['userData'] = $this->loginUser->find();
       
        echo view('chat',$data);
        // echo view('inc/footer');
    }

  

}
