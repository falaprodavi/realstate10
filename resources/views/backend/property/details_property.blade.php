    @extends('admin.admin_dashboard')
    @section('admin')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


    <div class="page-content">

        <div class="row">

            <div class="col-md-12 grid-margin stretch-card">

                <div class="example">
                    <div class="d-flex align-items-start">
                        <img src="{{ asset($property->property_thumbnail) }}" class="align-self-start wd-250 wd-sm-250 me-3 img-fluid rounded" alt="{{ $property->property_name }}">
                        <div>
                            <h2 class="mb-2">{{ $property->property_name }}</h2>
                            <p>{{ $property->property_short_desc }}</p>
                            <p>
                                @if($property->status == 1)
                                <span class="badge rounded-pill bg-success">Active</span>
                                @else
                                <span class="badge rounded-pill bg-danger">InActive</span>
                                @endif
                            </p>
                            <p>

                                @if($property->status == 1)
                                <form method="POST" action="{{ route('inactive.property') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $property->id }}">
                                    <button type="submit" class="btn btn-danger mt-2">Inactive</button>
                                </form>                                
                                @else
                                <form method="POST" action="{{ route('active.property') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $property->id }}">
                                    <button type="submit" class="btn btn-success mt-2">Active</button>
                                </form>   
                                @endif
                                
                            </p>
                        </div>
                    </div>
                </div>
                <hr>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h6 class="card-title">Proparty Details</h6>

                    <div class="table-responsive">
                        <table class="table table-striped">       
                            <tbody>     

                                <tr>                                  
                                    <td>Agent</td>
                                    <td>
                                        @if($property->agent_id == NULL)
                                        Admin
                                        @else
                                        {{ $property['user']['name'] }}
                                        @endif
                                    </td>                  
                                </tr>


                                <tr>                                  
                                    <td>COD</td>
                                    <td>{{ $property->property_code }}</td>                  
                                </tr>
                                <tr>                                  
                                    <td>Status</td>
                                    <td>{{ $property->property_status }}</td>                  
                                </tr>
                                <tr>                                  
                                    <td>Lowest Price</td>
                                    <td>{{ $property->property_lowest_price }}</td>                  
                                </tr>
                                <tr>                                  
                                    <td>Max Price</td>
                                    <td>{{ $property->property_max_price }}</td>                  
                                </tr>
                                <tr>                                  
                                    <td>Bedrooms</td>
                                    <td>{{ $property->property_bedrooms }}</td>                  
                                </tr>
                                <tr>                                  
                                    <td>Bathrooms</td>
                                    <td>{{ $property->property_bathrooms }}</td>                  
                                </tr>
                                <tr>                                  
                                    <td>Garage</td>
                                    <td>{{ $property->property_garage }}</td>                  
                                </tr>
                                <tr>                                  
                                    <td>Size Property</td>
                                    <td>{{ $property->property_size }}</td>                  
                                </tr>
                                <tr>                                  
                                    <td>Features</td>
                                    <td>{{ $property->property_features }}</td>                  
                                </tr>
                                <tr>                                  
                                    <td>HOT</td>
                                    <td>{{ $property->property_hot }}</td>                  
                                </tr>
                                <tr>                                  
                                    <td>Neighborhood</td>
                                    <td>{{ $property->property_neighborhood }}</td>                  
                                </tr>
                                <tr>                                  
                                    <td>Property Type</td>
                                    <td>{{ $property['type']['type_name'] }}</td>                  
                                </tr>
                                <tr>                                  
                                    <td>Amenities</td>
                                    <td>
                                        <select name="amenities_id[]" class="js-example-basic-multiple form-select" multiple="multiple" data-width="100%">
                                            @foreach($amenities as $ameni)
                                            <option value="{{ $ameni->id }}" {{ (in_array($ameni->id, $property_ami)) ? 'selected' : '' }}>{{ $ameni->amenities_name }}</option>
                                            @endforeach 
                                        </select>   
                                    </td>                  
                                </tr>

                                

                                


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">Location</h6>

                <div class="table-responsive">
                    <table class="table table-striped">       
                        <tbody>

                            <tr>                                  
                                <td>Address</td>
                                <td>{{ $property->property_address }}</td>                  
                            </tr>
                            <tr>                                  
                                <td>City</td>
                                <td>{{ $property->property_city }}</td>                  
                            </tr>
                            <tr>                                  
                                <td>State</td>
                                <td>{{ $property->property_state }}</td>                  
                            </tr>
                            <tr>                                  
                                <td>CEP</td>
                                <td>{{ $property->property_cep }}</td>                  
                            </tr>                            
                            <tr>                                  
                                <td>Latitude</td>
                                <td>{{ $property->property_latitude }}</td>                  
                            </tr>
                            <tr>                                  
                                <td>Longitude</td>
                                <td>{{ $property->property_longitude }}</td>                  
                            </tr>



                        </tbody>
                    </table>





                </div>
            </div>
        </div>
    </div>
</div>

</div>




@endsection