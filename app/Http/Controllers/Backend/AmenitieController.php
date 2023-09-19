<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Amenities;

class AmenitieController extends Controller
{
    public function AllAmenitie()
    {

        $amenities = Amenities::latest()->get();
        return view ('backend.amenities.all_amenities', compact('amenities'));
        
    } //End Method


    public function AddAmenitie()
    {

        return view ('backend.amenities.add_amenities');
        
    } //End Method

    public function StoreAmenitie(Request $request)
    {

        $request->validate([
            'amenities_name' => 'required|unique:amenities|max:200',
        ]);

        Amenities::insert([

            'amenities_name' => $request->amenities_name,            

        ]);


        //$data->save();

        $notification = array(
            'message' => 'Amenitie Create',
            'alert-type' => 'success'
        );

        return redirect()->route('all.amenitie')->with($notification);
        
    } //End Method


        public function EditAmenitie($id)
    {

        $amenities = Amenities::findOrFail($id);
        return view ('backend.amenities.edit_amenities', compact('amenities'));
        
    } //End Method



    public function UpdateAmenitie(Request $request)
    {

        $request->validate([
            'amenities_name' => 'required|unique:amenities|max:200',
        ]);

        $ameid = $request->id;

        Amenities::findOrFail($ameid)->update([

            'amenities_name' => $request->amenities_name,

        ]);

        $notification = array(
            'message' => 'Amenities Type Update',
            'alert-type' => 'success'
        );

        return redirect()->route('all.amenitie')->with($notification);
        
    } //End Method


    public function DeleteAmenitie($id){

        Amenities::findOrFail($id)->delete();


        $notification = array(
            'message' => 'Amenitie Delete',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } //End Method


}
