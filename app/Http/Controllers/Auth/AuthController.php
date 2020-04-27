<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Dompdf\Dompdf;
use App\Models\Card;
use App\Models\Company;

class AuthController extends Controller
{
    //
    public function __construct()
    {
        # code...
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function pdf()
    {
        $email = request()->get('email');
        $card = Card::where('email', $email)->with('branch')->first();
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $html = view('card', compact('card'));
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        //$dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        $output = $dompdf->output();
        $name = 'proof_'.$card->id.'_'.strtotime("now").'.pdf';
        $card->update(['proof'=>$name]);
        $filePath = public_path() .'/pdf/'.$name;
        file_put_contents($filePath, $output);
        // Output the generated PDF to Browser
        // $dompdf->stream();

        # code...
        return response()->json([
            'message'=>'success',
            'name'=>$name
        ]);
    }

    public function downloadProof()
    {
        $email = request()->get('email');
        $card = Card::where('email', $email)->with('branch')->first();
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $html = view('proof', compact('card'));
        // $dompdf->load_html($html);

        // (Optional) Setup the paper size and orientation
        //$dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        // $dompdf->render();

        // $output = $dompdf->output();
        // $name = 'proof_'.$card->id.'_'.strtotime("now").'.pdf';
        // $card->update(['proof'=>$name]);
        // $filePath = public_path() .'/pdf/'.$name;
        // file_put_contents($filePath, $output);
        // Output the generated PDF to Browser
        //$dompdf->stream();

        # code...
        return response()->json([
            'message'=>'success',
            'name'=>$name
        ]);
    }

    public function getCompany()
    {
        # code...
        $company_id = auth()->user()->company_id;
        $company = Company::where('id', $company_id)->with('branches')->first();

        return response()->json([
            'status'=>'success',
            'company'=>$company
        ]);
    }
    /**
     * Get a JWT via given credentials.
     */

     public function login()
     {
         # code...
         $credentials = request(['email', 'password']);

         if(! $token = auth()->attempt($credentials)){
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
                'expires_in' =>  auth()->factory()->getTTL() * 60
            ]);
        }


}
