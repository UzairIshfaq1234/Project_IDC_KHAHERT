<?php

namespace App\Http\Controllers;
use App\Models\idc_admin;

use Illuminate\Http\Request;

class login_ctrl extends Controller
{
    public function login(){

        if (session()->has('Admin_Auth_Session'))
        {
            return redirect('/AdminDashboard');

        }
        else if(session()->has('LT_Auth_Session'))
        {
            return redirect('/LTDashboard');

        } 
        else if (session()->has('Path_Auth_Session') )
        {
            return redirect('/PathologistDashboard');
        } 
        else 
        {
        return view('authentication.login');
        }
    }

    public function login_auth(Request $request){

        $request->validate([
            'Username'      => 'required|max:30',
            'Password'      => 'required|max:30',
            'Role'          => 'required',
        ]);
        
        $authenticate=idc_admin::where('Username', $request->Username)->where('Password', $request->Password)->where('Role', $request->Role)->first();

        if(empty($authenticate)){

            flash()->addError('Provide Correct Credentials.');
            return redirect()->back();
            
        }
        else{

            if($authenticate->Role == 1){
                session()->put('Admin_Auth_Session', $authenticate->Username);
                session()->put('Admin_Role_Session', $authenticate->Role);
                session()->put('Admin_Role_Image', $authenticate->Image);

                session()->put('LT_Auth_Session', $authenticate->Username);
                session()->put('LT_Role_Session', $authenticate->Role);
                session()->put('LT_Role_Image', $authenticate->Image);

                session()->put('Path_Auth_Session', $authenticate->Username);
                session()->put('Path_Role_Session', $authenticate->Role);
                session()->put('Path_Role_image', $authenticate->Image);

                

                flash()
                ->options([
                    'timeout' => 3000, // 3 seconds
                ])
                ->addSuccess('Welcome Dear   '.$authenticate->Username);
                return redirect('/AdminDashboard');


            }
            
            else if($authenticate->Role == 2){
                session()->put('LT_Auth_Session', $authenticate->Username);
                session()->put('LT_Role_Session', $authenticate->Role);
                session()->put('LT_Role_Image', $authenticate->Image);

                
                flash()
                ->options([
                    'timeout' => 3000, // 3 seconds
                ])
                ->addSuccess('Welcome Dear   '.$authenticate->Username);
                return redirect('/LTDashboard');


            }
            
            else if($authenticate->Role == 3){
                session()->put('Path_Auth_Session', $authenticate->Username);
                session()->put('Path_Role_Session', $authenticate->Role);
                session()->put('Path_Role_image', $authenticate->Image);

                flash()
                ->options([
                    'timeout' => 3000, // 3 seconds
                ])
                ->addSuccess('Welcome Dear   '.$authenticate->Username);

                return redirect('/PathologistDashboard');

            }
            else{
                flash()->addError('Provide Correct Role.');
                return redirect()->back();
            }
            
        }
    }


    public function logout(){

        if (session()->has('Admin_Auth_Session') or session()->has('LT_Auth_Session') or session()->has('Path_Auth_Session') ) {
            
            session()->flush();
            flash()->addSuccess('Logout Successfully.');
            return redirect('/');

        } else {
            return redirect('/');
        }
    }

}
