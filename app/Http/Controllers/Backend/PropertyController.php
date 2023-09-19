<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\MultiImage;
use App\Models\Facility;
use App\Models\Amenities;
use App\Models\PropertyType;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;


class PropertyController extends Controller
{
    public function AllProperty() {

        $property = Property::latest()->get();
        return view('backend.property.all_property', compact('property'));
        
    } // End Method


    public function AddProperty(){

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();
        return view('backend.property.add_property', compact('propertytype','amenities','activeAgent'));

    } // End Method


    public function StoreProperty(Request $request) {

        $amen = $request->amenities_id;
        $amenities = implode(",", $amen);

        $pcode = IdGenerator::generate(['table' => 'properties', 'field' => 'property_code', 'length' => 5, 'prefix' => 'PC']);

        $image = $request->file('property_thumbnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->fit(370, 250)->save('upload/property/thumbnail/'.$name_gen);
        $save_url = 'upload/property/thumbnail/'.$name_gen;

        $property_id = Property::insertGetId([

            'ptype_id' => $request->ptype_id,
            'amenities_id' => $amenities,
            'property_name' => $request->property_name,
            'property_slug' => strtolower(str_replace(' ', '-', $request->property_name)),
            'property_code' => $pcode,
            'property_status' => $request->property_status,
            'property_lowest_price' => $request->ptype_id,
            'property_max_price' => $request->property_lowest_price,
            'property_short_desc' => $request->property_short_desc,
            'property_long_desc' => $request->property_long_desc,
            'property_bedrooms' => $request->property_bedrooms,
            'property_bathrooms' => $request->property_bathrooms,
            'property_garage' => $request->property_garage,
            'property_size' => $request->property_size,
            'property_video' => $request->property_video,
            'property_address' => $request->property_address,
            'property_city' => $request->property_city,
            'property_state' => $request->property_state,
            'property_cep' => $request->property_cep,
            'property_neighborhood' => $request->property_neighborhood,
            'property_latitude' => $request->property_latitude,
            'property_longitude' => $request->property_longitude,
            'property_features' => $request->property_features,
            'property_hot' => $request->property_hot,
            'agent_id' => $request->agent_id,
            'status' => 1,         
            'property_thumbnail' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        // START Multiple Image Upload From Here //

        $images = $request->file('multi_img');

        foreach($images as $img) {

            $make_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($img)->fit(770, 520)->save('upload/property/multi-image/'.$make_name);
            $uploadPath = 'upload/property/multi-image/'.$make_name;

            MultiImage::insert([

                'property_id' => $property_id,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now(),

            ]);

        }  // End Foreach

        // END Multiple Image Upload From Here //


        // START ADD Facilities From Here //
        
        $facilities = Count($request->facility_name);

        if ($facilities != NULL) {
            for ($i=0; $i < $facilities; $i++) { 
                $fcount = new Facility();
                $fcount->property_id = $property_id;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->distance = $request->distance[$i];
                $fcount->save();

            }
        }

        // END ADD Facilities From Here //

        $notification = array(
            'message' => 'Property Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.property')->with($notification);

    } // End Method


    public function EditProperty($id){

        $facilities = Facility::where('property_id', $id)->get();

        $property = Property::findOrFail($id);

        $type = $property->amenities_id;
        $property_ami = explode(',', $type);

        $multiImage = MultiImage::where('property_id', $id)->get();

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();

        return view('backend.property.edit_property', compact('property','propertytype','amenities','activeAgent', 'property_ami', 'multiImage', 'facilities'));



    } // End Method


    public function UpdateProperty(Request $request){

        $amen = $request->amenities_id;
        $amenities = implode(",", $amen);

        $property_id = $request->id;

        Property::findOrFail($property_id)->update([

            'ptype_id' => $request->ptype_id,
            'amenities_id' => $amenities,
            'property_name' => $request->property_name,
            'property_slug' => strtolower(str_replace(' ', '-', $request->property_name)),            
            'property_status' => $request->property_status,
            'property_lowest_price' => $request->ptype_id,
            'property_max_price' => $request->property_lowest_price,
            'property_short_desc' => $request->property_short_desc,
            'property_long_desc' => $request->property_long_desc,
            'property_bedrooms' => $request->property_bedrooms,
            'property_bathrooms' => $request->property_bathrooms,
            'property_garage' => $request->property_garage,
            'property_size' => $request->property_size,
            'property_video' => $request->property_video,
            'property_address' => $request->property_address,
            'property_city' => $request->property_city,
            'property_state' => $request->property_state,
            'property_cep' => $request->property_cep,
            'property_neighborhood' => $request->property_neighborhood,
            'property_latitude' => $request->property_latitude,
            'property_longitude' => $request->property_longitude,
            'property_features' => $request->property_features,
            'property_hot' => $request->property_hot,
            'agent_id' => $request->agent_id,                        
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Property Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.property')->with($notification);

    } // End Method


    public function UpdatePropertyThumbnail (Request $request){

        $pro_id = $request->id;
        $old_img = $request->old_img;

        $image = $request->file('property_thumbnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->fit(370, 250)->save('upload/property/thumbnail/'.$name_gen);
        $save_url = 'upload/property/thumbnail/'.$name_gen;

        if (file_exists($old_img)) {
            unlink($old_img);
        }

        Property::findOrFail($pro_id)->update([

            'property_thumbnail' => $save_url,
            'updated_at' => Carbon::now(),

        ]);


        $notification = array(
            'message' => 'Property Thumbnail Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Method


    public function UpdatePropertyMultiimage(Request $request){

        $imgs = $request->multi_img;

        foreach($imgs as $id => $img){
            $imgDel = MultiImage::findOrFail($id);
            unlink($imgDel->photo_name);

            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->fit(770,520)->save('upload/property/multi-image/'.$make_name);
            $uploadPath = 'upload/property/multi-image/'.$make_name;

            MultiImage::where('id',$id)->update([

                'photo_name' => $uploadPath,
                'updated_at' => Carbon::now(),

            ]);

        } // End Foreach 


        $notification = array(
            'message' => 'Property Multi Image Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 


    } // End Method 


    public function PropertyMultiimageDelete($id){
        $oldImg = MultiImage::findOrFail($id);
        unlink($oldImg->photo_name);
        MultiImage::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Property Multi Image Delete Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification); 
    } // End Method 


    public function StoreNewMultiimage(Request $request){

        $new_multi = $request->imageid;
        $image = $request->file('multi_img');
        
        $make_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->fit(770,520)->save('upload/property/multi-image/'.$make_name);
        $uploadPath = 'upload/property/multi-image/'.$make_name;

        MultiImage::insert([

            'property_id' => $new_multi,
            'photo_name' => $uploadPath,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Property Multi Image Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification); 
    } // End Method 


    public function UpdatePropertyFacilities(Request $request){


        $pid = $request->id;

        if($request->facility_name == NULL){
            return redirect()->back();

        }else{

            Facility::where('property_id', $pid)->delete();

            $facilities = Count($request->facility_name);

            if ($facilities != NULL) {
                for ($i=0; $i < $facilities; $i++) { 
                    $fcount = new Facility();
                    $fcount->property_id = $pid;
                    $fcount->facility_name = $request->facility_name[$i];
                    $fcount->distance = $request->distance[$i];
                    $fcount->save();
                } // End for
            } // End if 
        }


        $notification = array(
            'message' => 'Facilities Update Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification); 


    } // End Method 


    public function DeleteProperty($id) {

        $property = Property::findOrFail($id);
        unlink ($property->property_thumbnail);
        Property::findOrFail($id)->delete();

        $image = MultiImage::where('property_id', $id)->get();
        foreach ($image as $img){
            unlink($img->photo_name);
            MultiImage::where('property_id', $id)->delete();
        }

        $facilitiesData = Facility::where('property_id', $id)->get();
        foreach($facilitiesData as $item){
            $item->facility_name;
            Facility::where('property_id', $id)->delete();
        }

        $notification = array(
            'message' => 'Property Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification); 

    } // End Method 
    


    public function DetailsProperty($id){

        $facilities = Facility::where('property_id', $id)->get();

        $property = Property::findOrFail($id);

        $type = $property->amenities_id;
        $property_ami = explode(',', $type);

        $multiImage = MultiImage::where('property_id', $id)->get();

        $propertytype = PropertyType::latest()->get();
        $amenities = Amenities::latest()->get();
        $activeAgent = User::where('status','active')->where('role','agent')->latest()->get();

        return view('backend.property.details_property', compact('property','propertytype','amenities','activeAgent', 'property_ami', 'multiImage', 'facilities'));

    } // End Method



    public function InactiveProperty(Request $request){

        $pid = $request->id;
        Property::findOrFail($pid)->update([
            'status' => 0,
            ]);

        $notification = array(
            'message' => 'Property Inactive Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.property')->with($notification); 

    } // End Method


    public function ActiveProperty(Request $request){

        $pid = $request->id;
        Property::findOrFail($pid)->update([
            'status' => 1,
            ]);

        $notification = array(
            'message' => 'Property Active Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.property')->with($notification); 

    } // End Method

} 
