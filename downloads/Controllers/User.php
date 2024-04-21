<?php
// ADEL CODEIGNITER 4 CRUD GENERATOR

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\UserModel;

class User extends BaseController
{
	
    protected $userModel;
    protected $validation;
	
	public function __construct()
	{
	    $this->userModel = new UserModel();
       	$this->validation =  \Config\Services::validation();
		
	}
	
	public function index()
	{

	    $data = [
                'controller'    	=> 'user',
                'title'     		=> 'User CRUD'				
			];
		
		return view('user', $data);
			
	}

	public function getAll()
	{
 		$response = array();		
		
	    $data['data'] = array();
 
		$result = $this->userModel->select('id, smart_intake_id, name, file, created_by, updated_by, deleted_by, created_at, updated_at, deleted_at')->findAll();
		
		foreach ($result as $key => $value) {
							
			$ops = '<div class="btn-group">';
			$ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit('. $value->id .')"><i class="fa fa-edit"></i></button>';
			$ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove('. $value->id .')"><i class="fa fa-trash"></i></button>';
			$ops .= '</div>';
			
			$data['data'][$key] = array(
				$value->id,
				$value->smart_intake_id,
				$value->name,
				$value->file,
				$value->created_by,
				$value->updated_by,
				$value->deleted_by,
				$value->created_at,
				$value->updated_at,
				$value->deleted_at,

				$ops,
			);
		} 

		return $this->response->setJSON($data);		
	}
	
	public function getOne()
	{
 		$response = array();
		
		$id = $this->request->getPost('id');
		
		if ($this->validation->check($id, 'required|numeric')) {
			
			$data = $this->userModel->where('id' ,$id)->first();
			
			return $this->response->setJSON($data);	
				
		} else {
			
			throw new \CodeIgniter\Exceptions\PageNotFoundException();

		}	
		
	}	
	
	public function add()
	{

        $response = array();

        $fields['id'] = $this->request->getPost('id');
        $fields['smart_intake_id'] = $this->request->getPost('smart_intake_id');
        $fields['name'] = $this->request->getPost('name');
        $fields['file'] = $this->request->getPost('file');
        $fields['created_by'] = $this->request->getPost('created_by');
        $fields['updated_by'] = $this->request->getPost('updated_by');
        $fields['deleted_by'] = $this->request->getPost('deleted_by');
        $fields['created_at'] = $this->request->getPost('created_at');
        $fields['updated_at'] = $this->request->getPost('updated_at');
        $fields['deleted_at'] = $this->request->getPost('deleted_at');


        $this->validation->setRules([
            'smart_intake_id' => ['label' => 'Smart Intake Id', 'rules' => 'permit_empty|numeric'],
            'name' => ['label' => 'Name', 'rules' => 'permit_empty'],
            'file' => ['label' => 'File', 'rules' => 'permit_empty'],
            'created_by' => ['label' => 'Created By', 'rules' => 'permit_empty'],
            'updated_by' => ['label' => 'Updated By', 'rules' => 'permit_empty'],
            'deleted_by' => ['label' => 'Deleted By', 'rules' => 'permit_empty'],
            'created_at' => ['label' => 'Created At', 'rules' => 'required|valid_date'],
            'updated_at' => ['label' => 'Updated At', 'rules' => 'required|valid_date'],
            'deleted_at' => ['label' => 'Deleted At', 'rules' => 'permit_empty|valid_date'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
			
        } else {

            if ($this->userModel->insert($fields)) {
												
                $response['success'] = true;
                $response['messages'] = 'Data has been inserted successfully';	
				
            } else {
				
                $response['success'] = false;
                $response['messages'] = 'Insertion error!';
				
            }
        }
		
        return $this->response->setJSON($response);
	}

	public function edit()
	{

        $response = array();
		
        $fields['id'] = $this->request->getPost('id');
        $fields['smart_intake_id'] = $this->request->getPost('smart_intake_id');
        $fields['name'] = $this->request->getPost('name');
        $fields['file'] = $this->request->getPost('file');
        $fields['created_by'] = $this->request->getPost('created_by');
        $fields['updated_by'] = $this->request->getPost('updated_by');
        $fields['deleted_by'] = $this->request->getPost('deleted_by');
        $fields['created_at'] = $this->request->getPost('created_at');
        $fields['updated_at'] = $this->request->getPost('updated_at');
        $fields['deleted_at'] = $this->request->getPost('deleted_at');


        $this->validation->setRules([
            'smart_intake_id' => ['label' => 'Smart Intake Id', 'rules' => 'permit_empty|numeric'],
            'name' => ['label' => 'Name', 'rules' => 'permit_empty'],
            'file' => ['label' => 'File', 'rules' => 'permit_empty'],
            'created_by' => ['label' => 'Created By', 'rules' => 'permit_empty'],
            'updated_by' => ['label' => 'Updated By', 'rules' => 'permit_empty'],
            'deleted_by' => ['label' => 'Deleted By', 'rules' => 'permit_empty'],
            'created_at' => ['label' => 'Created At', 'rules' => 'required|valid_date'],
            'updated_at' => ['label' => 'Updated At', 'rules' => 'required|valid_date'],
            'deleted_at' => ['label' => 'Deleted At', 'rules' => 'permit_empty|valid_date'],

        ]);

        if ($this->validation->run($fields) == FALSE) {

            $response['success'] = false;
            $response['messages'] = $this->validation->listErrors();
			
        } else {

            if ($this->userModel->update($fields['id'], $fields)) {
				
                $response['success'] = true;
                $response['messages'] = 'Successfully updated';	
				
            } else {
				
                $response['success'] = false;
                $response['messages'] = 'Update error!';
				
            }
        }
		
        return $this->response->setJSON($response);
		
	}
	
	public function remove()
	{
		$response = array();
		
		$id = $this->request->getPost('id');
		
		if (!$this->validation->check($id, 'required|numeric')) {

			throw new \CodeIgniter\Exceptions\PageNotFoundException();
			
		} else {	
		
			if ($this->userModel->where('id', $id)->delete()) {
								
				$response['success'] = true;
				$response['messages'] = 'Deletion succeeded';	
				
			} else {
				
				$response['success'] = false;
				$response['messages'] = 'Deletion error!';
				
			}
		}	
	
        return $this->response->setJSON($response);		
	}	
		
}	