<?php 

namespace App\Controllers;

use App\Controllers\Zip;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Content;
use CodeIgniter\Password\Password;
use CodeIgniter\I18n\Time;

//fetching login model from DB
use App\Models\LoginModel;


class Auth extends BaseController{

    protected $loginUser;

    //Constructor

    public function __construct()
    {

        helper(['url']);
    

        $this->loginUser = new LoginModel();
        
    }



    //-----------------------login function---------------------------------------

    public function login(){

        //fetch session
        $session = session();
          // Check if the user is logged in
          if ($session->get('isLoggedIn')) {
            return redirect()->to('/'); // Redirect to login if not logged in
        }

        echo view('/login/header');
        echo view('/login');
        
        echo view('/login/footer');

        if($this->request->getMethod() == 'POST'){
        // Get the input email and password from the request

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        
        

        //fetch and check if user is there in database

        $isUser = $this->loginUser->where('email',$email)->first();

        //if user is present then we are gonna check fir futher authentication

        if($isUser){
            // Verify the password

            if(password_verify($password,$isUser['password'])){
            
            // create session data
          
            $sessionData = [
              
                'email' => $email,
                'firstname'=> $isUser['firstname'],
                'isLoggedIn' => true,
            ];

            // Set session data
            session()->set($sessionData);

              
                return redirect()->to('/dashboard');
            }
            else {
                // Invalid password
                return redirect()->to('/login');
            }
        }

        //user not found
        else{

            return redirect()->to('/login');
        }
        }
        
    }

    
    //--------------------register function ------------------------------------------
    public function register(){

        $session = session();
          // Check if the user is logged in
          if ($session->get('isLoggedIn')) {
            return redirect()->to('/'); // Redirect to login if not logged in
        }

        helper(['form']);
    
        $data = [];
        $validation = \Config\Services::validation();

        // if user submit data
        if($this->request->getMethod()=='POST'){

           

            //we will do validation here
            $check = $this->validate([
                'firstname' => 'required|min_length[3]|max_length[20]',
                'lastname' => 'required|min_length[3]|max_length[20]',
                'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[register.email]',
                'password' => 'required|min_length[5]|max_length[200]',
                
            ]);

            //if user has not valid details
            if( ! $check){
            
            //if not valid info error will store in an array

           $data['validation'] = $validation->getErrors();
            }
            else{
                //store the data into database

        $firstname = $this->request->getVar('firstname');
        $lastname = $this->request->getVar('lastname');
        $email = $this->request->getVar('email');
        $psd = $this->request->getVar('password');
        $password = password_hash($psd,PASSWORD_DEFAULT);

        $role = $this->request->getVar('role');

        $this->loginUser->save(["firstname" => $firstname,"lastname"=>$lastname,"email"=>$email,"password"=>$password,"role"=>$role]);
        session()->setFlashdata("register","successfully register now you can login ");
       
        return redirect()->to('/login');
            }
        }

        echo view('/login/header');
        echo view('/register',$data);
        
        echo view('/login/footer');

        
    }



// ----------------------------------- logout function---------------------------------------------

public function logout()
{
    // Destroy the session
    session()->destroy();

    // Redirect to login page
    return redirect()->to('/login');
}


}






?>