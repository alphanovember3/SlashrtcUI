<?php

namespace App\Controllers;

// this files and libs imported for the file upload and download

use App\Models\UserModel;
use App\Models\CampUser;
use App\Models\AccessModel;

class Campcontroller extends BaseController
{
    protected $user;
    protected $campuser;
    protected $accessUser;

    public function __construct()
    {

        helper(['url']);
        $this->user = new UserModel();


        $this->campuser = new CampUser();

        $this->accessUser = new AccessModel();
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
        // select *, ( select email from users where users.id = campaign.superid ) as supervisor from campaign;
        $db = \Config\Database::connect();
        // $query = 'select *, ( select email from users where users.id = campaign.superid ) as supervisor from campaign LIMIT $perPage OFFSET $offset';
        // $resultTable = $db->query($query);
 
        $data['pagename'] = 'camphome';


        $page = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

        // Number of records per page
        $perPage = 8;
        // Calculate the offset 
        $offset = ($page - 1) * $perPage;
        // Custom query with LIMIT and OFFSET 
        // $query = "SELECT *, (SELECT level FROM accesslevel WHERE accesslevel.id = users.role) as accessname FROM users LIMIT $perPage OFFSET $offset"; 

        $filterdata = $this->request->getGet('camp');
        $filtersupervisor = $this->request->getGet('supervisor');




        if ($filterdata) {

            // $query = "SELECT *, (SELECT level FROM accesslevel WHERE accesslevel.id = users.role) as accessname FROM users WHERE users.role = $filterdata LIMIT $perPage OFFSET $offset"; 
            $query = "select *, ( select email from users where users.id = campaign.superid ) as supervisor from campaign WHERE campaign.cid = $filterdata LIMIT $perPage OFFSET $offset";
        }
         
        else {

            $query = "select *, ( select email from users where users.id = campaign.superid ) as supervisor from campaign LIMIT $perPage OFFSET $offset";
            // $query = "SELECT *, (SELECT level FROM accesslevel WHERE accesslevel.id = users.role) as accessname FROM users LIMIT $perPage OFFSET $offset"; 
        }


        // Get the total number of rows for pagination 
        $totalRows = $db->query("SELECT COUNT(*) as count FROM campaign")->getRow()->count;
        // Execute the query 
        $resultTable = $db->query($query);
        $result = $resultTable->getResult();
        // Load Pagination library 
        $pager = \Config\Services::pager();

        $campaign = session()->get('campaign');

        // $alluser= $result->find



        $data['pagedata'] = ['superuser' => $result, 'pager' => $pager->makeLinks($page, $perPage, $totalRows, 'default_full'), 'users' => $this->user->paginate(300), 'campaign' => $campaign, 'allData' => $this->campuser->find(),'filterdata'=>$filterdata];



        echo view('template', $data);
        // echo view('/inc/footer');
    }
    public function dashboard()
    {

        // echo view('/inc/header');
        $data['pagename'] = 'dashboard';
        $data['pagedata'] = [];
        echo view('template', $data);
        // echo view('/inc/footer');

    }
    public function saveUser()
    {

        $campname = $this->request->getVar('username');
        $superid = $this->request->getVar('email');
        $desc = $this->request->getVar('desc');

        $this->campuser->save(["cname" => $campname, "superid" => $superid, "cdesc" => $desc]);

        session()->setFlashdata("success", "data inserted successfully");
        return redirect()->to(base_url() . '/campaign');
    }

    public function getSingleUser($id)
    {

        // first() function will get the details and store it in variable  
        $data = $this->campuser->where('cid', $id)->first();

        //this echo will send the response  for the ajax function

        echo json_encode($data);
    }

    public function updateUsercamp()
    {

        // now we will get the updated value of the variable by his name 
        $id = $this->request->getVar('updateId');

        $superv = $this->request->getVar('role');

        $camp = $this->request->getVar('username');

        // now we will store the updated value in the array

        $data['superid'] = $superv;
        $data['cname'] = $camp;

        //now we wiil update the data into database using update function

        $this->campuser->update($id, $data);


        return redirect()->to(base_url() . '/campaign');
    }

    public function deleteUser()
    {

        //this $id is coming from data section of the ajax 

        $id = $this->request->getVar('id');

        $this->campuser->delete($id);

        // return redirect()->to(base_url());
        //here redirect function is not working so we are gonna send response to ajax and from there we will return the window
        //now we will return deleted
        return "deleted";
    }

    public function deleteMultiUser()
    {

        $ids = $this->request->getVar('ids');

        //now deleting the multiple users using loop

        for ($count = 0; $count < count($ids); $count++) {

            $this->user->delete($ids[$count]);
        }

        echo "multideleted";
    }

    public function filter()
    {

        $campaign =  $this->request->getVar('camp');

        session()->set('campaign', $campaign);

        return redirect()->to('/campaign');
    }
}
