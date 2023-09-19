    @extends('admin.admin_dashboard')
    @section('admin')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


    <div class="page-content">


        <div class="row profile-body">

            <!-- middle wrapper start -->
            <div class="col-md-12 col-xl-12 middle-wrapper">
                <div class="row">

                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Add Property</h6>


                            <form method="POST" action="{{ route('store.property') }}" id="myForm" enctype="multipart/form-data">

                                @csrf


                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Property Name</label>
                                            <input type="text" name="property_name" class="form-control">
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Property Status</label>
                                            <select name="property_status" class="form-select" id="exampleFormControlSelect1">
                                                <option selected="" disabled="">Select Type</option>
                                                <option value="buy">For Buy</option>
                                                <option value="rent">For Rent</option>
                                            </select>
                                        </div>
                                    </div><!-- Col -->

                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Lowest Price</label>
                                            <input type="text" name="property_lowest_price" class="form-control">
                                        </div>
                                    </div><!-- Col -->

                                    <div class="col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Max Price</label>
                                            <input type="text" name="property_max_price" class="form-control">
                                        </div>
                                    </div><!-- Col -->




                                </div><!-- Row -->


                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label class="form-label">Badrooms</label>
                                            <input type="number" class="form-control" name="property_bedrooms">
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label class="form-label">Bathrooms</label>
                                            <input type="number" class="form-control" name="property_bathrooms">
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label class="form-label">Garage</label>
                                            <input type="number" class="form-control" name="property_garage">
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label class="form-label">Property Size</label>
                                            <input type="number" class="form-control" name="property_size">
                                        </div>
                                    </div><!-- Col -->
                                </div><!-- Row -->


                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label class="form-label">Property Type</label>
                                            <select name="ptype_id" class="form-select" id="exampleFormControlSelect1">
                                                <option selected="" disabled="">Select Type</option>
                                                @foreach($propertytype as $ptype)
                                                <option value="{{ $ptype->id }}">{{ $ptype->type_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div><!-- Col -->

                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label class="form-label">Property Amenities</label>

                                            <select name="amenities_id[]" class="js-example-basic-multiple form-select" multiple="multiple" data-width="100%">
                                                @foreach($amenities as $ameni)
                                                <option value="{{ $ameni->amenities_name }}">{{ $ameni->amenities_name }}</option>
                                                @endforeach
                                            </select>


                                        </div>
                                    </div><!-- Col -->

                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label class="form-label">Agent</label>
                                            <select name="agent_id" class="form-select" id="exampleFormControlSelect1">
                                                <option selected="" disabled="">Select Agent</option>
                                                @foreach($activeAgent as $agent)
                                                <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div><!-- Col -->
                                </div><!-- Row -->


                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Short Description</label>
                                            <textarea name="property_short_desc" class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                                        </div>
                                    </div><!-- Col -->

                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Long Description</label>
                                            <textarea name="property_long_desc" class="form-control" name="tinymce" id="tinymceExample" rows="10"></textarea>
                                        </div>
                                    </div><!-- Col -->


                                </div><!-- Row -->



                                <hr>

                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Thumbnail</label>
                                            <input type="file" name="property_thumbnail" class="form-control" onchange="mainThumUrl(this)">
                                            <img src="" id="mainThumb" style="padding-top:10px">
                                        </div>
                                    </div><!-- Col -->

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Multi Images</label>
                                            <input type="file" name="multi_img[]" class="form-control" id="multiImg" multiple="">
                                            <div class="row" id="preview_img" style="padding-top:10px"></div>
                                        </div>
                                    </div><!-- Col -->

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Vídeo</label>
                                            <input type="text" class="form-control" name="property_video">
                                        </div>
                                    </div><!-- Col -->

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Neighborhood</label>
                                            <input type="text" class="form-control" name="property_neighborhood">
                                        </div>
                                    </div><!-- Col -->

                                </div><!-- Row -->




                                <hr>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label class="form-label">Address</label>
                                            <input type="text" class="form-control" name="property_address">
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control" name="property_city">
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label class="form-label">State</label>
                                            <input type="text" class="form-control" name="property_state">
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label class="form-label">CEP</label>
                                            <input type="text" class="form-control" name="property_cep">
                                        </div>
                                    </div><!-- Col -->
                                </div><!-- Row -->


                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Latitude</label>
                                            <input type="text" class="form-control" name="property_latitude">
                                            <a href="https://www.latlong.net/" target="_blank">Go here to get</a>
                                        </div>
                                    </div><!-- Col -->

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Longitude</label>
                                            <input type="text" class="form-control" name="property_longitude">
                                        </div>
                                    </div><!-- Col -->
                                </div><!-- Row -->


                                <div class="mb-5 mt-5">
                                    <div class="form-check form-check-inline">
                                      <input type="checkbox" name="property_features" value="1" class="form-check-input" id="checkInline1">
                                      <label class="form-check-label" for="checkInline1">
                                        Features Property
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                  <input type="checkbox" name="property_hot" value="1" class="form-check-input" id="checkInline">
                                  <label class="form-check-label" for="checkInline">
                                    Hot Property
                                </label>
                            </div>
                        </div>


                        <!-- FACILITIES -->


                        <div class="row add_item">
                            <div class="col-md-4">
                              <div class="mb-3">
                                <label for="facility_name" class="form-label">Facilities </label>
                                <select name="facility_name[]" id="facility_name" class="form-control">
                                  <option value="">Select Facility</option>
                                  <option value="Hospital">Hospital</option>
                                  <option value="SuperMarket">Super Market</option>
                                  <option value="School">School</option>
                                  <option value="Entertainment">Entertainment</option>
                                  <option value="Pharmacy">Pharmacy</option>
                                  <option value="Airport">Airport</option>
                                  <option value="Railways">Railways</option>
                                  <option value="Bus Stop">Bus Stop</option>
                                  <option value="Beach">Beach</option>
                                  <option value="Mall">Mall</option>
                                  <option value="Bank">Bank</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="mb-3">
                            <label for="distance" class="form-label"> Distance </label>
                            <input type="text" name="distance[]" id="distance" class="form-control" placeholder="Distance (Km)">
                        </div>
                    </div>
                    <div class="form-group col-md-4" style="padding-top: 30px;">
                      <a class="btn btn-success addeventmore"><i class="fa fa-plus-circle"></i> Add More..</a>
                  </div>
              </div> <!---end row-->

              <div class="row mt-5">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>



    </div>
</div>
</div>
</div>
<!-- middle wrapper end -->

</div>

</div>


<!--========== Start of add multiple class with ajax ==============-->
<div style="visibility: hidden">
 <div class="whole_extra_item_add" id="whole_extra_item_add">
  <div class="whole_extra_item_delete" id="whole_extra_item_delete">
   <div class="container mt-2">
    <div class="row">

     <div class="form-group col-md-4">
      <label for="facility_name">Facilities</label>
      <select name="facility_name[]" id="facility_name" class="form-control">
        <option value="">Select Facility</option>
        <option value="Hospital">Hospital</option>
        <option value="SuperMarket">Super Market</option>
        <option value="School">School</option>
        <option value="Entertainment">Entertainment</option>
        <option value="Pharmacy">Pharmacy</option>
        <option value="Airport">Airport</option>
        <option value="Railways">Railways</option>
        <option value="Bus Stop">Bus Stop</option>
        <option value="Beach">Beach</option>
        <option value="Mall">Mall</option>
        <option value="Bank">Bank</option>
    </select>
</div>
<div class="form-group col-md-4">
  <label for="distance">Distance</label>
  <input type="text" name="distance[]" id="distance" class="form-control" placeholder="Distance (Km)">
</div>
<div class="form-group col-md-4" style="padding-top: 20px">
  <span class="btn btn-success btn-sm addeventmore"><i class="fa fa-plus-circle">Add</i></span>
  <span class="btn btn-danger btn-sm removeeventmore"><i class="fa fa-minus-circle">Remove</i></span>
</div>
</div>
</div>
</div>
</div>
</div>


<!----For Section-------->
<script type="text/javascript">
 $(document).ready(function(){
  var counter = 0;
  $(document).on("click",".addeventmore",function(){
    var whole_extra_item_add = $("#whole_extra_item_add").html();
    $(this).closest(".add_item").append(whole_extra_item_add);
    counter++;
});
  $(document).on("click",".removeeventmore",function(event){
    $(this).closest("#whole_extra_item_delete").remove();
    counter -= 1
});
});
</script>
<!--========== End of add multiple class with ajax ==============-->


<!-- mainThumUrl start -->
<script type="text/javascript">
    function mainThumUrl(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e){
              $('#mainThumb').attr('src',e.target.result).width(80);
          };
          reader.readAsDataURL(input.files[0]);
      }
  }
</script>
<!-- mainThumUrl end -->

<!-- multiImg start -->
<script>
  $(document).ready(function(){
       $('#multiImg').on('change', function(){ //on file input change
          if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
          {
              var data = $(this)[0].files; //this file data

              $.each(data, function(index, file){ //loop though each file
                  if(/(\.|\/)(gif|jpe?g|png|webp)$/i.test(file.type)){ //check supported file type
                      var fRead = new FileReader(); //new filereader
                      fRead.onload = (function(file){ //trigger function on successful read
                          return function(e) {
                              var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(100)
                      ; //create image element
                          $('#preview_img').append(img); //append image to output element
                      };
                  })(file);
                      fRead.readAsDataURL(file); //URL representing the file's data.
                  }
              });

          }else{
              alert("Your browser doesn't support File API!"); //if File API is absent
          }
      });
   });
</script>
<!-- multiImg end -->

<!-- validate start -->
<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                property_name: {
                    required : true,
                },
                property_status: {
                    required : true,
                },
                property_lowest_price: {
                    required : true,
                },
                property_max_price: {
                    required : true,
                },
                ptype_id: {
                    required : true,
                },


            },
            messages :{
                property_name: {
                    required : 'Please Enter Property Name',
                },
                property_status: {
                    required : 'Please Select Property Status',
                },
                property_lowest_price: {
                    required : 'Please Enter Lowest Price',
                },
                property_max_price: {
                    required : 'Please Enter Max Price',
                },
                ptype_id: {
                    required : 'Please Select Property Type',
                },


            },
            errorElement : 'span',
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });

</script>

@endsection