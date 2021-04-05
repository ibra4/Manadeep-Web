<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bid;
use App\Models\cite;
use App\Models\type;
use App\Models\gallery;
class BidWebController extends Controller
{

    public function index()
    {
        $Bid = Bid::where('approve',1)->orderBy('id','DESC')-> get();
        $AllBid=array();

        foreach ($Bid as $key){
            $key->image='/Koha-Web/public'.$key->image;
            $AllBid[] =$key;
        }
        return view('admin.bids.index')->with('bids', $AllBid);
    }

    public function AddPage()
    {
        $cite = cite::all();
        $type = type::all();

        return view('admin.bids.create')
        ->with('cite', $cite)
        ->with('type', $type);
    }

    public function create(Request $request)
    {
        if(isset($_FILES["image"]["type"]))
        {
            $FILES = $_FILES["image"];

            //Send error
            if ($FILES['error'])
            {
                return response()->json(['error'=>'Invalid file']);
            }

            //Change file name
            $imageFileType = pathinfo($FILES["name"],PATHINFO_EXTENSION);
            $uniqid = uniqid();
            $file_path='/files/' . $uniqid .'.'.$imageFileType;
            $file = "/var/www/html/Koha-Web/public" .$file_path;

            //Upload file
            if(move_uploaded_file($FILES["tmp_name"], $file)){
               $gallery = new gallery();
               $gallery->user_id = $request->input('user_id');
               $gallery->filepath = $file_path;
               $gallery->save();
            }
        }


        $request->validate([
            'name' => 'required',
            'estimate_price' => 'required',
            'location' => 'required',
            'sex' => 'required',
            'Age' => 'required',
            'type' => 'required',
            'Description' => 'required',
            'Bid_time' => 'required'
        ]);

        $bid = new Bid();

        $bid->name = $request->input('name');
        $bid->estimate_price = $request->input('estimate_price');
        $bid->image = $gallery->filepath;
        $bid->location = $request->input('location');
        $bid->sex = $request->input('sex');
        $bid->Age = $request->input('Age');
        $bid->type = $request->input('type');
        $bid->user_id = @auth()->user()->id;
        $bid->Description = $request->input('Description');
        $bid->Bid_time = $request->input('Bid_time');
        $bid->approve = 1;
        $bid->seen = 0;

        $bidTime=$request->input('Bid_time');
        $date1 = date("Y-m-d H:i:s");
        $date2 = date("Y-m-d H:i:s",strtotime("+$bidTime days",strtotime($date1)));

        $bid->StartBidDate = $date1;
        $bid->EndBidDate = $date2;
        $bid->save();
//         dd($bid);
        return redirect()->route('admin.bids', app()->getLocale());
      }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $bid = Bid::find($id);
        $bid->image='/Koha-Web/public'.$bid->image;
        return view('admin.bids.show')->with([
            'bid' => $bid,
        ]);
    }

    public function edit($id)
    {
        $bid = Bid::find($id);
        $cite = cite::all();
        $type = type::all();

        return view('admin.bids.edit')->with([
            'bid' => $bid,
        ]) ->with('cite', $cite)
        ->with('type', $type);
    }

    public function update(Request $request, $id)
    {
//         die("Sss");
//         $request->validate([
//             'name' => 'required',
//             'estimate_price' => 'required',
//             'location' => 'required',
//             'sex' => 'required',
//             'Age' => 'required',
//             'type' => 'required',
//             'Description' => 'required',
//             'Bid_time' => 'required'
//         ]);

        $bid = Bid::find($id);


        $bid->name = $request->input('name');
        $bid->estimate_price = $request->input('estimate_price');
      //  $bid->image = $gallery->filepath;
        $bid->location = $request->input('location');
        $bid->sex = $request->input('sex');
        $bid->Age = $request->input('Age');
        $bid->type = $request->input('type');
        $bid->user_id = @auth()->user()->id;
        $bid->Description = $request->input('Description');
        $bid->Bid_time = $request->input('Bid_time');
        $bid->approve = 1;
   //     $bid->seen = 0;

        $bidTime=$request->input('Bid_time');
        $date1 = date("Y-m-d H:i:s");
        $date2 = date("Y-m-d H:i:s",strtotime("+$bidTime days",strtotime($date1)));

        $bid->StartBidDate = $date1;
        $bid->EndBidDate = $date2;
        $bid->save();
        //         dd($bid);
        return redirect()->route('admin.bids', app()->getLocale());
    }

    public function destroy($id)
    {
        $Bid = Bid::find($id);
        if ($Bid->delete()) {
            \Session::flash('message', $Bid->name . ' Has been Deleted');
            \Session::flash('class', 'alert-success');
        } else {
            \Session::flash('message', 'Error deleting the user');
            \Session::flash('class', 'alert-danger');
        }
        return redirect()->route('admin.bids', app()->getLocale());
    }
}
