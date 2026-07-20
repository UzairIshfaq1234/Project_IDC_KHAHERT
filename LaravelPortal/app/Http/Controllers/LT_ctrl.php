<?php

namespace App\Http\Controllers;
use App\Models\idc_patient;

use Illuminate\Http\Request;
use Mail;
use App\Mail\IDC_Patient as Mail_IDC;

use App\Mail\IDC_PatientUpdate;


class LT_ctrl extends Controller
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


    $recent_patients = idc_patient::latest('created_at')->take(6)->get();

        return view('LT.LT_dashboard',compact('total_patient_added_today_treated','all_Patient_count','last_updated_treated_record','all_NotTreated_count','all_Treated_count','recent_patients'));
    }

    public function addpatient(){
        return view('LT.patients_add');
    }


    public function Barcode_Scanner()
    {
        return view('LT.barcode_scanner');
    }


    public function Barcode_Lookup(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $patient = idc_patient::where('Sampleno', trim($request->code))->first();

        if (! $patient) {
            return response()->json(['found' => false, 'message' => 'No patient matches this barcode / sample number.']);
        }

        return response()->json([
            'found'   => true,
            'patient' => [
                'id'        => $patient->Id,
                'name'      => $patient->Name,
                'sampleno'  => $patient->Sampleno,
                'email'     => $patient->Email,
                'contactno' => $patient->Contactno,
                'addedby'   => $patient->Addedby,
                'treated'   => $patient->treated,
                'result'    => $patient->Result,
                'date'      => $patient->created_at ? $patient->created_at->format('d M Y · h:i A') : '',
                'profile'   => route('patient.profile', ['id' => $patient->Id]),
                'receipt'   => route('patient.receipt', ['id' => $patient->Id]),
                'label'     => route('patient.label', ['id' => $patient->Id]),
                'report'    => $patient->treated == '1' ? route('patient.report', ['id' => $patient->Id]) : null,
            ],
        ]);
    }


    public function Patient_Calendar()
    {
        $calendar_events = idc_patient::all()->map(function ($p) {
            return [
                'id'    => $p->Id,
                'title' => $p->Name,
                'start' => $p->created_at ? $p->created_at->format('Y-m-d') : null,
                'extendedProps' => [
                    'sampleno'  => $p->Sampleno,
                    'name'      => $p->Name,
                    'email'     => $p->Email,
                    'contactno' => $p->Contactno,
                    'addedby'   => $p->Addedby,
                    'treated'   => $p->treated,
                    'result'    => $p->Result,
                    'date'      => $p->created_at ? $p->created_at->format('d M Y · h:i A') : '',
                    'profile'   => route('patient.profile', ['id' => $p->Id]),
                    'receipt'   => route('patient.receipt', ['id' => $p->Id]),
                    'label'     => route('patient.label', ['id' => $p->Id]),
                ],
            ];
        })->filter(fn ($e) => $e['start'])->values();

        return view('LT.patient_calendar', compact('calendar_events'));
    }


    public function Patient_Profile($id)
    {
        $patient = idc_patient::where('Id', $id)->firstOrFail();

        return view('LT.patient_profile', compact('patient'));
    }


    public function Patient_Receipt($id)
    {
        $patient = idc_patient::where('Id', $id)->firstOrFail();

        return view('prints.patient_receipt', compact('patient'));
    }


    public function Patient_Report($id)
    {
        $patient = idc_patient::where('Id', $id)->firstOrFail();

        if ($patient->treated != '1') {
            flash()->addWarning('No diagnostic result has been recorded for this patient yet.');
            return redirect()->back();
        }

        return view('prints.patient_report', compact('patient'));
    }


    public function Patient_Label($id)
    {
        $patient = idc_patient::where('Id', $id)->firstOrFail();

        return view('prints.patient_label', compact('patient'));
    }


    public function Add_Patient_data(Request $request)
    {

        // dd($request);





        $validatedData = $request->validate([
            'Sampleno'                 => 'required|unique:idc_patients,Sampleno',
            'Name'                     => 'required',
            'Email'                    => 'required|email',
            'ContactNo'                => 'required|digits:11|numeric',

        ]);


 


        $data = idc_patient::create([
            'Sampleno'              => request('Sampleno'),
            'Name'                  => request('Name'),
            'Email'                 => request('Email'),
            'Contactno'             => request('ContactNo'),
            'Addedby'               => session()->get('LT_Auth_Session'),
            'treated'               => '0',


        ]);



        if ($data) {


            $Maildata=[
                'Name'         => ucwords($request->Name),
                'Sampleno'     => $request->Sampleno,
                'ContactNo'    =>$request->ContactNo ,
                'ID'           =>$data->id,
                'Addedby'      => session()->get('LT_Auth_Session')
    
    
            ];
    
            Mail::to($request->Email)->send(new Mail_IDC($Maildata) );

            return response()->json(['message' => 'Patient Added Successfully']);
        }


        return redirect()->back();
    }

    
    public function All_Patient_data()
    {

        $all_patient_records = idc_patient::all();


        return view('LT.patients_all', compact('all_patient_records'));
    }



    public function Update_Patient_data(Request $request)
    {
        // dd($request);

        $validatedData_UpdatePatient = $request->validate([
            'Name'                     => 'required',
            'Email'                    => 'required|email',
            'Contactno'                => 'required|digits:11|numeric',
        ]);

        $Update_Patient_Result = idc_patient::where('Id', $request->Id)->update($validatedData_UpdatePatient);


        $Patient_Data = idc_patient::where('Id', $request->Id)->first();

        if ($Update_Patient_Result) {


            $Maildata=[
                'Name'         => ucwords($request->Name),
                'Sampleno'     => $Patient_Data->Sampleno,
                'ContactNo'    => $request->Contactno ,
                'ID'           => $request->Id,
                'Addedby'      => $Patient_Data->Addedby,
                'Updatedby'    => session()->get('LT_Auth_Session'),

    
            ];
    
            Mail::to($request->Email)->send(new IDC_PatientUpdate($Maildata) );

            return response()->json(['message' => 'Patient Updated Successfully']);
        } else {
            return response()->json(['message' => 'Error! Patient Updated Failed !']);
        }
    }


}
