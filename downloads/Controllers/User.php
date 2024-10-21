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
 
		$result = $this->userModel->select('id, student_id, date, month, year, frequency, minute, activity, detail, academic_year, semester, created_at, updated_at, deleted_at')->findAll();
		
		foreach ($result as $key => $value) {
							
			$ops = '<div class="btn-group">';
			$ops .= '	<button type="button" class="btn btn-sm btn-info" onclick="edit('. $value->id .')"><i class="fa fa-edit"></i></button>';
			$ops .= '	<button type="button" class="btn btn-sm btn-danger" onclick="remove('. $value->id .')"><i class="fa fa-trash"></i></button>';
			$ops .= '</div>';
			
			$data['data'][$key] = array(
				$value->id,
				$value->student_id,
				$value->date,
				$value->month,
				$value->year,
				$value->frequency,
				$value->minute,
				$value->activity,
				$value->detail,
				$value->academic_year,
				$value->semester,
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
        $fields['student_id'] = $this->request->getPost('student_id');
        $fields['date'] = $this->request->getPost('date');
        $fields['month'] = $this->request->getPost('month');
        $fields['year'] = $this->request->getPost('year');
        $fields['frequency'] = $this->request->getPost('frequency');
        $fields['minute'] = $this->request->getPost('minute');
        $fields['activity'] = $this->request->getPost('activity');
        $fields['detail'] = $this->request->getPost('detail');
        $fields['academic_year'] = $this->request->getPost('academic_year');
        $fields['semester'] = $this->request->getPost('semester');
        $fields['created_at'] = $this->request->getPost('created_at');
        $fields['updated_at'] = $this->request->getPost('updated_at');
        $fields['deleted_at'] = $this->request->getPost('deleted_at');


        $this->validation->setRules([
            'student_id' => ['label' => 'Student Id', 'rules' => 'permit_empty|numeric'],
            'date' => ['label' => 'Date', 'rules' => 'permit_empty|numeric'],
            'month' => ['label' => 'Month', 'rules' => 'permit_empty|numeric'],
            'year' => ['label' => 'Year', 'rules' => 'permit_empty|numeric'],
            'frequency' => ['label' => 'Frequency', 'rules' => 'permit_empty|numeric'],
            'minute' => ['label' => 'Minute', 'rules' => 'permit_empty|numeric'],
            'activity' => ['label' => 'Activity', 'rules' => 'permit_empty'],
            'detail' => ['label' => 'Detail', 'rules' => 'permit_empty'],
            'academic_year' => ['label' => 'Academic Year', 'rules' => 'permit_empty|numeric'],
            'semester' => ['label' => 'Semester', 'rules' => 'permit_empty|numeric'],
            'created_at' => ['label' => 'Created At', 'rules' => 'permit_empty|valid_date'],
            'updated_at' => ['label' => 'Updated At', 'rules' => 'permit_empty|valid_date'],
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
        $fields['student_id'] = $this->request->getPost('student_id');
        $fields['date'] = $this->request->getPost('date');
        $fields['month'] = $this->request->getPost('month');
        $fields['year'] = $this->request->getPost('year');
        $fields['frequency'] = $this->request->getPost('frequency');
        $fields['minute'] = $this->request->getPost('minute');
        $fields['activity'] = $this->request->getPost('activity');
        $fields['detail'] = $this->request->getPost('detail');
        $fields['academic_year'] = $this->request->getPost('academic_year');
        $fields['semester'] = $this->request->getPost('semester');
        $fields['created_at'] = $this->request->getPost('created_at');
        $fields['updated_at'] = $this->request->getPost('updated_at');
        $fields['deleted_at'] = $this->request->getPost('deleted_at');


        $this->validation->setRules([
            'student_id' => ['label' => 'Student Id', 'rules' => 'permit_empty|numeric'],
            'date' => ['label' => 'Date', 'rules' => 'permit_empty|numeric'],
            'month' => ['label' => 'Month', 'rules' => 'permit_empty|numeric'],
            'year' => ['label' => 'Year', 'rules' => 'permit_empty|numeric'],
            'frequency' => ['label' => 'Frequency', 'rules' => 'permit_empty|numeric'],
            'minute' => ['label' => 'Minute', 'rules' => 'permit_empty|numeric'],
            'activity' => ['label' => 'Activity', 'rules' => 'permit_empty'],
            'detail' => ['label' => 'Detail', 'rules' => 'permit_empty'],
            'academic_year' => ['label' => 'Academic Year', 'rules' => 'permit_empty|numeric'],
            'semester' => ['label' => 'Semester', 'rules' => 'permit_empty|numeric'],
            'created_at' => ['label' => 'Created At', 'rules' => 'permit_empty|valid_date'],
            'updated_at' => ['label' => 'Updated At', 'rules' => 'permit_empty|valid_date'],
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