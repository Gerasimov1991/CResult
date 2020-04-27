<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Branch;
use App\Models\Font;
use File;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $companies = Company::get();
        return response()->json([
            'status'=>'Success',
            'companies'=>$companies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $invalid_characters = array('*','"','/','\\','[',']',':',';','|','=',' ');
        $id = request()->get('id');
        $company = Company::where('id', $id)->first();
        $message = 'Company information updated.';
        $logoName = '';
        $backgroundName = '';
        if(!$company){
            $company = new Company;
            $message = 'New company created.';
        }else{
            $logoName = $company->logo;
            $backgroundName = $company->background;
        }

        if($request->hasFile('logo')){
            $file = $request->file('logo');
            $cleaned_name = str_replace($invalid_characters, '',$file->getClientOriginalName());
            $cleaned_name = str_replace('_', '', $cleaned_name);
            $logoName = 'company_logo' . strtotime("now") . $cleaned_name;
            $file->storeAs(
                '/', $logoName, 'card'
            );
        }

        if($request->hasFile('background')){
            $file = $request->file('background');
            $cleaned_name = str_replace($invalid_characters, '',$file->getClientOriginalName());
            $cleaned_name = str_replace('_', '', $cleaned_name);
            $backgroundName = 'company_background' . strtotime("now") . $cleaned_name;
            $file->storeAs(
                '/', $backgroundName, 'card'
            );
        }

        $company->name = $request->name;
        $company->address = $request->address;
        $company->footer_text = $request->footer_text;
        $company->logo = $logoName;
        $company->background = $backgroundName;
        $company->header_color = $request->header_color;
        $company->header_background_color = $request->header_background_color;
        $company->footer_text_color = $request->footer_text_color;
        $company->footer_background_color = $request->footer_background_color;
        $company->save();

        return response()->json([
            'status' => 'Success',
            'message'=>$message
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    // Branches method
    public function getBranches()
    {
        # code...
        $branches = Branch::with('company')->get();

        return response()->json([
            'status'=>'Success',
            'branches'=>$branches
        ]);
    }

    public function updateBranch(Request $request)
    {
        # code...
        $invalid_characters = array('*','"','/','\\','[',']',':',';','|','=',' ');
        $message = 'Branch information updated.';
        $id = request()->get('id');
        $branch = Branch::where('id', $id)->first();
        $imageName = '';
        $shorName = '';
        $frontImageName = '';
        if(!$branch){
            $branch = new Branch;
            $message = 'New branch created.';
        }else{
            $imageName = $branch->preset_image;
            $frontImageName = $branch->front_image;
        }

        if($request->hasFile('image')){
            $file = $request->file('image');
            $cleaned_name = str_replace($invalid_characters, '',$file->getClientOriginalName());
            $cleaned_name = str_replace('_', '', $cleaned_name);
            $imageName = 'branch_preset' . strtotime("now") . $cleaned_name;
            $file->storeAs(
                '/', $imageName, 'card'
            );
        }

        if($request->hasFile('front_image')){
            $file = $request->file('front_image');
            $cleaned_name = str_replace($invalid_characters, '',$file->getClientOriginalName());
            $cleaned_name = str_replace('_', '', $cleaned_name);
            $frontImageName = 'front_image' . strtotime("now") . $cleaned_name;
            $file->storeAs(
                '/', $frontImageName, 'card'
            );
        }

        if(preg_match_all('/\b(\w)/',strtoupper($request->name),$m)) {
            $shorName = implode('',$m[1]);
        }

        $branch->name           = $request->name;
        $branch->preset_image   = $imageName;
        $branch->address        = $request->address;
        $branch->website        = $request->website;
        $branch->short_name     = strtoupper($shorName);
        $branch->slug           = str_replace(' ', '-', $request->name);
        $branch->company_id     = $request->company_id;
        $branch->front_image    = $frontImageName;
        $branch->upload_avatar  = ($request->upload_avatar == 'true')?1:0;
        $branch->save();

        return response()->json([
            'status' => 'Success',
            'message'=>$message
        ]);

    }

    public function installFonts()
    {
        $fonts = public_path().'/company/customfont/';
        $css = public_path().'/company/css/fonts.css';

        file_put_contents($css, '');
        Font::query()->truncate();

        foreach (File::allFiles($fonts) as $file) {
            $fontName = explode('.',$file->getFilename())[0];
            $url = '../customfont/'.$file->getFilename();
            $texts = "\n@font-face{
                font-family: \"".$fontName."\";
                src: url(".$url.") format(\"truetype\");
            }";
            $font = new Font;
            $font->name = $fontName;
            $font->save();

            file_put_contents($css, $texts, FILE_APPEND);
        }
    }
}

