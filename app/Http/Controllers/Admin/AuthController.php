<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Dompdf\Dompdf;
use App\Models\Company;
use App\Models\Branch;
use App\Models\Setting;
use App\User;

class AuthController extends Controller
{
    //
    public function __construct()
    {
        # code...
        $this->middleware('auth:api', ['except' => ['login','pdf','getSettings']]);
    }

    public function pdf()
    {

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $html = view('card');
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();

        # code...
        return response()->json([
            'message'=>'success',
            'test'=>'test'
        ]);
    }

    /**
     * Get a JWT via given credentials.
     */

     public function login()
     {
         # code...
         $credentials = request(['email', 'password']);

         if(! $token = auth()->attempt(['email'=>$credentials['email'], 'password'=>$credentials['password'], 'is_admin'=>1])){
             return response()->json(['error' => 'Login failed.'], 401);
         }

         return $this->respondWithToken($token);
     }

     /**
      * Get the authenticated User
      */

      public function me()
      {
          # code...
          return response()->json(auth()->user());
      }

      /**
       * Log the user out (Invalidate the token)
       */

       public function logout()
       {
           # code...
           auth()->logout();
           return response()->json(['message' => 'Successfully logged out.']);
       }

       /**
        * Refresh a token.
        */

       public function refresh()
       {
           # code...
           return $this->respondWithToken(auth()->refresh());
       }

       /**
        * Get the token array structure
        */

        protected function respondWithToken($token)
        {
            # code...

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'email'=>auth()->user()->email,
                'is_admin'=>auth()->user()->is_admin,
                'expires_in' =>  auth()->factory()->getTTL() * 60
            ]);
        }

        public function getSettings()
        {
            # code...
            $settings = Setting::first();
            return response()->json([
                'settings'=> $settings
            ]);
        }

        public function updateSettings(Request $request)
        {
            # code...
            $invalid_characters = array('*','"','/','\\','[',']',':',';','|','=',' ');
            $logoName = '';
            $backgroundName = '';
            $logoSMName = '';
            if($request->hasFile('logo')){
                $file = $request->file('logo');
                $cleaned_name = str_replace($invalid_characters, '',$file->getClientOriginalName());
                $cleaned_name = str_replace('_', '', $cleaned_name);
                $logoName = 'logo' . strtotime("now") . $cleaned_name;
                $file->storeAs(
                    '/', $logoName, 'card'
                );
            }

            if($request->hasFile('background')){
                $file = $request->file('background');
                $cleaned_name = str_replace($invalid_characters, '',$file->getClientOriginalName());
                $cleaned_name = str_replace('_', '', $cleaned_name);
                $backgroundName = 'background' . strtotime("now") . $cleaned_name;
                $file->storeAs(
                    '/', $backgroundName, 'card'
                );
            }

            if($request->hasFile('logo_sm')){
                $file = $request->file('logo_sm');
                $cleaned_name = str_replace($invalid_characters, '',$file->getClientOriginalName());
                $cleaned_name = str_replace('_', '', $cleaned_name);
                $logoSMName = 'logo_sm' . strtotime("now") . $cleaned_name;
                $file->storeAs(
                    '/', $logoSMName, 'card'
                );
            }


            $settings = Setting::first();
            $settings->name = $request->name;
            $settings->email = $request->email;
            $settings->address = $request->address;
            $settings->website = $request->website;
            $settings->mobile = $request->mobile;
            $settings->telephone = $request->telephone;
            $settings->logo = ($logoName != '')? $logoName : $settings->logo;
            $settings->background = ($backgroundName != '')? $backgroundName:$settings->background;
            $settings->logo_sm = ($logoSMName != '')?$logoSMName:$settings->logo_sm;
            $settings->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Setttings updated.',
                'settings'=>$settings
            ]);

        }

        public function users()
        {
            # code...
            $users = User::where('is_admin', 0)->orderBy('created_at', 'DESC')->get();
            return response()->json([
                'message' =>'Success',
                'users'=>$users
            ]);
        }

        public function updateUser(Request $request)
        {
            # code...
            $message = 'User information updated.';
            $id = intval($request->id);
            $user = User::where('id', $id)->first();
            if(!$user){
                $user = new User;
                $message = 'New user created.';
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->company_id = $request->company_id;
            if($request->password != ""){
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return response()->json([
                'success' => 'suceess',
                'message' => $message
            ]);

        }

        public function deleteUser(Request $request)
        {
            # code..
            User::where('id', $request->id)->delete();
            return response()->json([
                'status'=>'success'
            ]);
        }

        public function addUser(Request $request)
        {
            $user = new User;
            $message = 'New user created.';           
            $user->name = $request->name;
            $user->email = $request->email;
            $user->company_id = $request->company_id;
            if($request->password != ""){
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return response()->json([
                'success' => 'suceess',
                'message' => $message
            ]);

        }
        

}
