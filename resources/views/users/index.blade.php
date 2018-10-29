@extends('layouts.new_template')
@section('page-heading')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>Data</h2>
  </div>
  <div class="col-lg-2">
  </div>
</div>
@endsection
@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>Data Pengguna</h5>
        <div class="ibox-tools">
          <a href="{{ route('users.create') }}"><button type="button" class="btn btn-md btn-success">Tambah Pengguna</button></a>
        </div>
      </div>
      <div class="ibox-content">
        <table id="tbl-user"  class="table table-bordered">
          <thead>
           <tr>
             <th>No</th>
             <th>Name</th>
             <th>Email</th>
             <th>Roles</th>
             <th>Action</th>
           </tr>
         </thead>
         <tbody>
           @foreach ($data as $key => $user)
           <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
              @if(!empty($user->getRoleNames()))
              @foreach($user->getRoleNames() as $v)
              <label class="badge badge-success">{{ $v }}</label>
              @endforeach
              @endif
            </td>
            <td style="white-space: nowrap; width: 1%">
             <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
             <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
             @if (! (Auth::user()->id == $user->id))
             {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
             {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
             {!! Form::close() !!}
             @endif
           </td>
         </tr>
         @endforeach
       </tbody>
     </table>
   </div>
 </div>
</div>
</div>
@endsection
@section('custom_js')
<script>
  let $table    = $("#tbl-user").DataTable();
</script>
@endsection