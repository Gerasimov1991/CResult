<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends Controller
{
    //
    public function getPackages()
    {
        # code...
        $packages = Package::orderBy('created_at', 'DESC')->get();
        return response()->json([
            'status' => 'Success',
            'packages' => $packages
        ]);
    }

    public function updatePackage(Request $request)
    {
        # code...
        $message = 'Package updated.';
        $id = intval($request->id);
        $package = Package::where('id', $id)->first();
        if(!$package){
            $package = new Package;
            $message = 'New package created.';
        }
        $package->details = $request->details;
        $package->price = $request->price;
        $package->save();

        return response()->json([
            'status' => 'Success',
            'message'=>$message
        ]);
    }

    public function deletePackage(Request $request)
    {
        # code...
        Package::where('id', $request->id)->delete();
        return response()->json([
            'status'=>'Success'
        ]);
    }

}
