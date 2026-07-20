<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\idc_patient;

use Mail;
use App\Mail\IDC_PatientAppointment;

class pathologist_ctrl extends Controller
{
    public function index(){

            // Assuming your model is named idc_patient
    $total_patient_added_today_treated = idc_patient::whereRaw('DATE(created_at) = CURDATE()')
    ->where('treated', '0') 
    ->count();

    $all_Patient_count = idc_patient::all()->count();

    $last_updated_treated_record = idc_patient::where('treated', '1') 
    ->latest('updated_at') 
    ->value('id'); 

    $all_NotTreated_count = idc_patient::where('treated',0)->count();
    $all_Treated_count = idc_patient::where('treated',1)->count();

    $patientsTreatedByDoctorCount = idc_patient::where('Doctorby', session()->get('Path_Auth_Session'))
    ->where('treated', '1') // Assuming 'Positive' is the value for treated patients
    ->count();


    $pending_queue = idc_patient::where('treated', '0')->latest('created_at')->take(6)->get();

        return view('Pathologist.pathologist_dashboard',compact('total_patient_added_today_treated','all_Patient_count','last_updated_treated_record','all_NotTreated_count','all_Treated_count','patientsTreatedByDoctorCount','pending_queue'));
    }

    public function Appointments(){

        $patient_appointment=idc_patient::where('treated','0')->get();

        return view('Pathologist.pathologist_appointments',compact('patient_appointment'));
    }


    public function Update_Appointment_data(Request $request)
    {

        $validatedData_UpdateAppointment = $request->validate([
            'Result'                   => 'required',
            'Image'                    => 'required|image|mimes:jpeg,png,jpg|max:3000',

        ]);

        $Patient_Data = idc_patient::where('Id', $request->Id)->first();


        $image = $request->file('Image');
        $filename = time() . '_' . $Patient_Data->Sampleno. '.' . $image->getClientOriginalExtension();
        $publicPath = public_path('Patient_Images/' . $filename);


        $datatoupdate=[
            'Result'   => $request->Result,
            'Doctorby' => session()->get('Path_Auth_Session'),
            'treated'  => '1',
            'Image'    => $filename,

        ];

        $image->move('Patient_Images', $filename);






        $Update_Appointment_Result = idc_patient::where('Id', $request->Id)->update($datatoupdate);



        if ($Update_Appointment_Result) {


            $Maildata=[
                'Name'         => ucwords($Patient_Data->Name),
                'Sampleno'     => $Patient_Data->Sampleno,
                'ContactNo'    => $Patient_Data->Contactno ,
                'ID'           => $request->Id,
                'Addedby'      => $Patient_Data->Addedby,
                'Resultedby'    => session()->get('Path_Auth_Session'),
                'Result'      => $request->Result,


    
            ];
    
            Mail::to($Patient_Data->Email)->send(new IDC_PatientAppointment($Maildata) );

            return response()->json(['message' => 'Appointment Updated Successfully']);
        } else {
            return response()->json(['message' => 'Error! Appointment Updated Failed !']);
        }
    }



}
