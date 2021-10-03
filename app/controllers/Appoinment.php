<?php
  class Appoinment extends Controller {
    private $appoinmentModel,
            $_patient_id,
            $_physio,
            $_defaultphysio,
            $_physiolist;

    public function __construct(){
        if(!isLoggedIn()){
            redirect('users/login');
        }
        if(isset($_POST['id'])){
            $this->appoinmentModel = $this->model('AppoinmentModel');
            $this->_patient_id= $_SESSION['appoinment']['patient_id']=trim($_POST['id']);
            $this->_physiolist=$_SESSION['appoinment']['physio_list']=$this->appoinmentModel->getphysio_list();
            $this->_physio=$_SESSION['appoinment']['physio']=4;
            $this->_defaultphysio=$_SESSION['appoinment']['defaultphysio']=$_SESSION['appoinment']['physio'];
            // $this->appoinmentModel->getphysio($this->_patient_id);
        }elseif(isset($_SESSION['appoinment']['patient_id']) && isset($_SESSION['appoinment']['physio']) && isset($_SESSION['appoinment']['physio_list'])){
            $this->appoinmentModel = $this->model('AppoinmentModel');
            $this->_patient_id=$_SESSION['appoinment']['patient_id'];
            $this->_physiolist=$_SESSION['appoinment']['physio_list'];
            $this->_physio=$_SESSION['appoinment']['physio'];
            $this->_defaultphysio=$_SESSION['appoinment']['defaultphysio'];
        }
        else{
            redirect($_SESSION['role']."/index");
        }
        
      }
    public function calendar(){
        if(isset($_GET['physio'])){
            $this->_physio=$_SESSION['appoinment']['physio']=trim($_GET['physio']);
        }
        // if(isset($_GET['month']) && isset($_GET['year']) && isset($_GET['physio'])){
        //     $data=[
        //         'month'=>$_GET['month'],
        //         'year'=>$_GET['year'],
        //         'no_of_slots'=>5,
        //         'physio_list'=>$this->_physiolist,
        //         'physio'=>trim($_GET['physio'])
        //     ];
        //     $li=$this->appoinmentModel->getavailabledays($data['month'],$data['physio']);
        //     $data['bookslots']=$li;
        //     $this->view('appoinment/calendar', $data);
        // }
        if(isset($_GET['month']) && isset($_GET['year'])){
            $data=[
                'month'=>$_GET['month'],
                'year'=>$_GET['year'],
                'no_of_slots'=>5,
                'physio_list'=>$this->_physiolist,
                'physio'=>$this->_physio,
                'defaultphysio'=>$this->_defaultphysio
            ];
            $li=$this->appoinmentModel->getavailabledays($data['month'],$data['physio']);
            $data['bookslots']=$li;
            $this->view('appoinment/calendar', $data);
        }
        elseif(isset($_GET['date'])){
            $date=$_GET['date'];
            $this->slots($date);
        }
        else{
            $data=[
                'month'=>date("m"),
                'year'=>date("Y"),
                'no_of_slots'=>5,
                'physio_list'=>$this->_physiolist,
                'physio'=>$this->_physio,
                'defaultphysio'=>$this->_defaultphysio
            ];
            $li=$this->appoinmentModel->getavailabledays(date('m'),$data['physio']);
            $data['bookslots']=$li;
            $this->view('appoinment/calendar', $data);
        }

    }
    public function slots($date=null){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $field=[
                'physio_id'=>$this->_physio,
                'patient_id'=>$this->_patient_id,
                'time_slot'=>$_POST['timeslot'],
                'date'=>$_POST['date']
            ];
            $where=['physio_id','=',$this->_physio];
            $this->appoinmentModel->saveappoinment($field,$where);
            redirect('');
        }
        else{
        $li=$this->appoinmentModel->getavailableslots($date);
        $booking=(array_column($li, 'time_slot'));
        $data=[
            'duration' => 20,
            'cleanup' => 0,
            'start' => "09:00",
            'end' => "15:00",
            'date'=>$date,
            'bookings'=>$booking
        ];
        $this->view('appoinment/slots', $data);
        }
    }
  }