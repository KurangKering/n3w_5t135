@extends('layouts.template')
@section('content')


<div class="header"> 
	
	<ol class="breadcrumb">
		<li><a href="#">Home</a></li>
		<li><a href="#">Forms</a></li>
		<li class="active">Data</li>
	</ol> 
	
</div>

<div id="page-inner"> 
	<div class="col-lg-3 col-md-offset-10">
		<button type="button" class="btn btn-info">Tambah User</button>
	</div><br><br>
	<div class="row">
		<div class="col-md-12">
			<!-- Advanced Tables -->
			<div class="panel panel-default">
				<div class="panel-heading">
					
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" >
							
							<div class="col-lg-3 col-md-offset-9">
								<label>Search:</label>
								<input class="form-control" >
							</div>
							<br><br><br><br>		
							<thead>
								<tr>
									<th>Username</th>
									<th>Password</th>
									<th>Level</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<tr class="odd gradeX">
									<td>Admin1</td>
									<td>***</td>
									<td>Bendahara</td>
									<td class="center"> <button type="button" class="btn btn-success">Detail</button>&nbsp <button type="button" class="btn btn-warning">Edit</button>&nbsp <button type="button" class="btn btn-danger">Delete</button></td>
								</tr>
								<tr class="even gradeC">
									<td>Admin2</td>
									<td>***</td>
									<td>Kepala Bagian Keuangan</td>
									<td class="center"> <button type="button" class="btn btn-success">Detail</button>&nbsp <button type="button" class="btn btn-warning">Edit</button>&nbsp <button type="button" class="btn btn-danger">Delete</button></td>
								</tr>
								
							</tbody>
						</table>
					</div>
					
				</div>
			</div>
			<!--End Advanced Tables -->
		</div>
	</div>
	<footer><p><a href=""></a></p></footer>
</div>
<!-- /. PAGE INNER  -->


@endsection