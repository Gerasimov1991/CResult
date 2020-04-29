<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
// use Mail;
use App\Models\Font;
use Auth;
use Dompdf\Dompdf;
use App\Models\Company;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
class CardController extends Controller
{
    public function __construct()
    {
        # code...
        $this->middleware('auth:api');
    }
    //
    public function saveCardWithPhoto(Request $request)
    {
        $status = 0;
        $message = 'Card saved.';
        $this->cardSave($request, $status);
        return response()->json([
            'status' => 'Success',
            'message'=>$message
        ], 200);

    }

    public function saveCard(Request $request)
    {

        $status = 0;
        $this->cardSave($request, $status);
        return response()->json([
            'status' => 'Success'
        ], 200);
    }

    private function cardSave($request, $status)
    {
        $card = Card::where('email', $request->email)->first();
        $new_name = '';
        if(!$card){
            $card = new Card;

        }else{
            $new_name =$card->image;
        }

        if($request->hasFile('image')){
            $file = $request->file('image');
            $invalid_characters = array('*','"','/','\\','[',']',':',';','|','=',' ');

            $cleaned_name = str_replace($invalid_characters, '',$file->getClientOriginalName());
            $cleaned_name = str_replace('_','',$cleaned_name);
            $cardName = str_replace($invalid_characters, '', str_replace(' ', '',  $request->name));
            $new_name = 'card'.auth()->user()->id.$cardName.strtotime("now").$cleaned_name;

            $file->storeAs(
                '/', $new_name, 'card'
            );
        }


        $card->image            = $new_name;
        $card->name             = strtoupper($request->name);
        $card->title            = strtoupper($request->title);
        $card->user_id          = auth()->user()->id;
        $card->mobile           = $request->mobile;
        $card->email            = $request->email;
        $card->direct_dial      = $request->dd;
        $card->branch_id        = $request->branch_id;
        $card->status           = $status;
        $card->package_id       = $request->package_id;
        $card->name_font_size   = $request->name_font_size;
        $card->name_font_weight = $request->name_font_weight;
        $card->title_font_size  = $request->title_font_size;
        $card->title_font_weight= $request->title_font_weight;
        $card->main_font_size   = $request->main_font_size;
        $card->main_color       = $request->main_color;
        $card->sub_color        = $request->sub_color;
        $card->font_name        = $request->font_name;
        $card->image_size       = $request->image_size;
        $card->image_top_margin = $request->image_top_margin;
        $card->image_right_margin= $request->image_right_margin;
        $card->margin_top       = $request->margin_top;
        $card->margin_bottom    = $request->margin_bottom;
        $card->footer_font_size = $request->footer_font_size;
        $card->save();
    }

    public function getOrders()
    {
        # code...
        $branch_id = request()->get('branch_id');
        if($branch_id == 0)
        {
            $orders = Card::where('status', 0)->get();
        }
        else
        {
            $orders = Card::where('status', 0)->where('branch_id', $branch_id)->get();
        }
        
        return response()->json([
            'status' => 'Success',
            'bid' => $branch_id,
            'orders' => $orders
        ]);
    }

    public function getSHOrders()
    {
        # code...
        $orders = Card::where('status', 0)->where('branch_id', 1)->get();
        return response()->json([
            'status' => 'Success',
            'orders' => $orders
        ]);
    }
    public function getPastOrders()
    {
        # code...
        $orders = Card::where('status', 1)->get();
        return response()->json([
            'status' => 'Success',
            'orders' => $orders
        ]);
    }
    public function getSRPastOrders()
    {
        # code...
        $orders = Card::where('status', 1)->where('branch_id', 2)->get();
        return response()->json([
            'status' => 'Success',
            'orders' => $orders
        ]);
    }

    public function getSHPastOrders()
    {
        # code...
        $orders = Card::where('status', 1)->where('branch_id', 1)->get();
        return response()->json([
            'status' => 'Success',
            'orders' => $orders
        ]);
    }
    public function approveOrder()
    {
        # code...
        $email = request()->get('email');
        $card = Card::where('email', $email)->with('branch','package')->first();
        $data = array();
        // instantiate and use the dompdf class
        $data['preset_image'] = $card->branch->preset_image;
        $data['name'] = $card->name;
        $data['title'] = $card->title;
        $data['mobile'] = $card->mobile;
        $data['direct_dial'] = $card->direct_dial;
        $data['email'] = $card->email;
        $data['image'] = $card->image;
        $data['address'] = $card->branch->address;
        $data['details'] = $card->package->details;
        $data['price'] = number_format($card->package->price,0);
        $pdf = PDF::loadView('proof',$data);       
       
        $pdf = $pdf->output();
        $name = 'proof_'.$card->id.'_'.strtotime("now").'.pdf';
        $card->update(['proof'=>$name]);
        $filePath = public_path() .'/pdf/'.$name;
        file_put_contents($filePath, $pdf);        
        
        $card->update(['status'=>1]);
        $card = [
            'name'=>$card->name,
            'email'=>$card->email,
            'title'=>$card->title,
            'package_details'=>$card->package->details,
            'package_price'=>$card->package->price,
            'proof'=>$card->proof,
            'url'=>public_path() .'/pdf/'.$card->proof,
        ];

        Mail::to($card['email'])->send(new SendMail($card));
        Mail::to("chitanokumar0@gmail.com")->send(new SendMail($card));
        // Mail to customer
        // Mail::send('mail', $card, function($message) use ($card) {
        //     $message->to($card['email'], $card['name'],$card['url'])->subject
        //        ('Order Summary');
            
        //     $message->from('info@chitano.info','C Result Print');
        // });

        // // Mail to admin
        // Mail::send('mailadmin', $card, function($message) use ($card) {
        //     $message->to('chitanokumar0@gmail.com', 'Admin',$card['url'])->subject
        //        ('New order');
        //     $message->cc(['chitanokumar@gmail.com']);           
        //     $message->from('info@chitano.info','C Result Print');
        // });

        // $to = Auth::user()->email;
        // $subject = "Order Summary";
        // $txt = $filePath;
        // $headers = "info@chitano.info,C Result Print" . "\r\n";
        
        // mail($to,$subject,$txt,$headers);

        // $to = Auth::user()->where('is_admin','1')->first()->email;
        // $subject = "New Order";
        // $txt = $filePath;
        // $headers = "info@chitano.info,C Result Print" . "\r\n";
        
        // mail($to,$subject,$txt,$headers);
        


        return response()->json([
            'status'=>'Success',
            'message'=>'Thanks, your order has been sent'
        ]);
    }

    public function deleteOrder()
    {
        # code...
        $card = Card::where('id', request()->get('id'))->first();
        if($card->image != ""){
            try{
                $path = public_path() . '/company/images/card/'.$card->image;
                unlink($path);
            }catch(Exception $e){

            }
        }
        $card->delete();

        return response()->json([
            'status'=>'Success',
            'message'=>'Card has been deleted.'
        ]);
    }
    public function getCard()
    {
        # code...
        $id = request()->get('id');
        $card = Card::where('id', $id)->first();

        return response()->json([
            'status'=>'Success',
            'card'=>$card
        ]);
    }

    public function fonts()
    {
        $fonts = Font::get();
        return response()->json(['fonts'=>$fonts]);
    }
}
