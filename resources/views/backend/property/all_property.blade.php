  @extends('admin.admin_dashboard')
  @section('admin')


  <div class="page-content">

    <nav class="page-breadcrumb">
     <ol class="breadcrumb">
      <a href="{{ route('add.property') }}" class="btn btn-inverse-info"> Add Property</a>
    </ol>
  </nav>

  <div class="row">
   <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Property All</h6>

        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <thead>
              <tr>
                <th>Code </th> 
                <th>Image </th> 
                <th>Name </th> 
                <th>P Type </th> 
                <th>Type </th> 
                <th>City </th>                 
                <th>Status </th>  
                <th>Action </th> 
              </tr>
            </thead>
            <tbody>
             @foreach($property as $key => $item)
             <tr>
              <td>{{ $item->property_code }}</td> 
              <td><img src="{{ asset($item->property_thumbnail) }}" style="width:60px; height:60px;"> </td> 
              <td style="max-width: 120px; overflow: hidden; text-overflow: ellipsis;">{{ $item->property_name }}</td> 
              <td>{{ $item['type']['type_name'] }}</td> 
              <td>{{ $item->property_status }}</td> 
              <td>{{ $item->property_city }}</td> 
              
              <td> 
                @if($item->status == 1)
                <span class="badge rounded-pill bg-success">Active</span>
                @else
                <span class="badge rounded-pill bg-danger">InActive</span>
                @endif

              </td> 
              <td>

                <a href="{{ route('details.property', $item->id) }}" class="btn btn-inverse-success" title="Details"> <i data-feather="eye" style="width:15px;height: 15px;"></i> </a>

                <a href="{{ route('edit.property', $item->id) }}" class="btn btn-inverse-warning" title="Edit"> <i data-feather="edit" style="width:15px;height: 15px;"></i> </a>

                <a href="{{ route('delete.property', $item->id) }}" class="btn btn-inverse-danger" id="delete" title="Delete"> <i data-feather="trash-2" style="width:15px;height: 15px;"></i>  </a>

              </td> 
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>

</div>




@endsection