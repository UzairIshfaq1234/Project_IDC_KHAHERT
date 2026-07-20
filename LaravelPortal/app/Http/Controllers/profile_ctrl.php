<?php

namespace App\Http\Controllers;

use App\Models\idc_admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class profile_ctrl extends Controller
{
    /**
     * Resolve the currently logged-in account from whichever role session is
     * active. Login writes Admin_/LT_/Path_ session keys together for Admins,
     * so we check the most privileged session first.
     */
    private function currentAccount()
    {
        $username = session('Admin_Auth_Session')
            ?? session('LT_Auth_Session')
            ?? session('Path_Auth_Session');

        if (! $username) {
            return null;
        }

        return idc_admin::where('Username', $username)->first();
    }

    public function index()
    {
        $account = $this->currentAccount();

        if (! $account) {
            return redirect('/');
        }

        return view('profile.my_profile', compact('account'));
    }

    public function updateInfo(Request $request)
    {
        $account = $this->currentAccount();

        if (! $account) {
            return response()->json(['message' => 'Session expired. Please log in again.'], 401);
        }

        $request->validate([
            'Name'      => 'required|string|max:255',
            'Email'     => 'required|email',
            'ContactNo' => 'required|digits:11|numeric',
        ]);

        $account->update([
            'Name'      => $request->Name,
            'Email'     => $request->Email,
            'Contactno' => $request->ContactNo,
        ]);

        return response()->json(['message' => 'Profile details updated successfully']);
    }

    public function updatePassword(Request $request)
    {
        $account = $this->currentAccount();

        if (! $account) {
            return response()->json(['message' => 'Session expired. Please log in again.'], 401);
        }

        $request->validate([
            'CurrentPassword' => 'required|string',
            'NewPassword'     => 'required|string|min:8|max:15|confirmed',
        ]);

        if ($request->CurrentPassword !== $account->Password) {
            return response()->json(['errors' => ['CurrentPassword' => ['Current password is incorrect.']]], 422);
        }

        $account->update(['Password' => $request->NewPassword]);

        return response()->json(['message' => 'Password updated successfully']);
    }

    public function updatePhoto(Request $request)
    {
        $account = $this->currentAccount();

        if (! $account) {
            return response()->json(['message' => 'Session expired. Please log in again.'], 401);
        }

        $request->validate([
            'Image' => 'required|image|mimes:jpeg,png,jpg|max:3000',
        ]);

        $image = $request->file('Image');
        $filename = time() . '_' . $account->Username . '.' . $image->getClientOriginalExtension();
        $publicPath = public_path('Admin_Images/' . $filename);

        Image::make($image)
            ->resize(128, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->resizeCanvas(128, 128, 'center', false, 'ffffff')
            ->save($publicPath);

        $account->update(['Image' => $filename]);

        // Refresh whichever role-image session keys are present for this login.
        if (session()->has('Admin_Role_Image')) {
            session()->put('Admin_Role_Image', $filename);
        }
        if (session()->has('LT_Role_Image')) {
            session()->put('LT_Role_Image', $filename);
        }
        if (session()->has('Path_Role_image')) {
            session()->put('Path_Role_image', $filename);
        }

        return response()->json(['message' => 'Profile photo updated successfully', 'image' => asset('Admin_Images/' . $filename)]);
    }
}
