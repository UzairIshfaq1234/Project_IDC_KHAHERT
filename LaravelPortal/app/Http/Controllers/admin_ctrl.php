<?php

namespace App\Http\Controllers;
use App\Models\idc_admin;
use App\Models\idc_patient;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class admin_ctrl extends Controller
{
    public function index(){

        $all_admin_count = idc_admin::all()->count();
        $all_LT_count = idc_admin::where('Role',2)->count();
        $all_Path_count = idc_admin::where('Role',3)->count();

        $all_Patient_count = idc_patient::all()->count();
        $all_Postive_count = idc_patient::where('Result','Positive')->count();
        $all_Negative_count = idc_patient::where('Result','Negative')->count();

        $all_NotTreated_count = idc_patient::where('treated','0')->count();
        $all_Treated_count = idc_patient::where('treated','1')->count();




        // dd($all_Postive_count);


        return view('admin.admin_dashboard',compact('all_admin_count','all_LT_count','all_Path_count','all_Postive_count','all_Negative_count','all_Patient_count','all_NotTreated_count','all_Treated_count'));
    }

    public function addadmin(){
        return view('admin.admin_add');
    }

    public function Add_Admin_data(Request $request)
    {

        // dd($request);

        $validatedData = $request->validate([
            'Name'                     => 'required',
            'Username'                 => 'required|unique:idc_admins,Username',
            'Email'                    => 'required|email',
            'Password'                 => [
                'required',
                'string',
                'min:8',
                'max:15',
            ],
            'Role'                     => 'required',
            'ContactNo'                => 'required|digits:11|numeric',
            'Image'                    => 'required|image|mimes:jpeg,png,jpg|max:3000',

        ]);


        $image = $request->file('Image');
        $filename = time() . '_' . $request->Username . '.' . $image->getClientOriginalExtension();
        $publicPath = public_path('Admin_Images/' . $filename);

        // Resize the image to fit within a 250x250 pixel box without cutting
        Image::make($image)
            ->resize(128, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->resizeCanvas(128, 128, 'center', false, 'ffffff')
            ->save($publicPath);


        $data = idc_admin::create([
            'Name'              => request('Name'),
            'Username'          => request('Username'),
            'Email'             => request('Email'),
            'Password'          => request('Password'),
            'Role'              => request('Role'),
            'Contactno'         => request('ContactNo'),
            'Image'             => $filename,

        ]);



        if ($data) {
            return response()->json(['message' => 'Login Added successfully']);
        }


        return redirect()->back();
    }

    public function All_Admin_data()
    {

        $all_admin_records = idc_admin::all();


        return view('admin.admin_all', compact('all_admin_records'));
    }

    public function Update_Admin_data(Request $request)
    {
        // dd($request);

        $validatedData_UpdateAdmin = $request->validate([
            'Name'                     => 'required',
            'Username'                 => 'required',
            'Email'                    => 'required|email',
            'Password'                 => [
                'required',
                'string',
                'min:8',
                'max:15',
            ],
            'Role'                     => 'required',
            'ContactNo'                => 'required|digits:11|numeric',
        ]);

        $Update_Admin_Result = idc_admin::where('Id', $request->Id)->update($validatedData_UpdateAdmin);

        if ($Update_Admin_Result) {

            return response()->json(['message' => 'Login Updated Successfully']);
        } else {
            return response()->json(['message' => 'Error! Login Updated Failed !']);
        }
    }

    public function Del_Admin_data($id)
    {
        // $record = admin::find($id);
        // dd($record);
        // $record->delete();

        $affectedRows = idc_admin::where('Id', $id)->delete();

        return response()->json(['toast_message' => 'Login Deleted Successfully']);
    }
}
