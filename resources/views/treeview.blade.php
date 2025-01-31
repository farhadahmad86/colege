<!DOCTYPE html>
<html>
<head>
	<title>Laravel Category Treeview Example</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<link href={{asset("public/css/treeview.css")}} rel="stylesheet">
</head>
<body>
<div class="container">
	<div class="panel panel-primary">
		<div class="panel-heading">Manage Category TreeView</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-6">
					<h3>Category List</h3>
					<ul id="tree1">
						@php
						$count=0;
						@endphp
						@foreach($categories as $category)
							<li>
								{{ $category->coa_head_name }}
								@if(count($category->childs))
									@include('manageChild',['childs' => $category->childs ,'count' =>$count])
								@endif
							</li>
						@endforeach
					</ul>
				</div>
			</div>


		</div>
	</div>
</div>
<script src={{asset("public/js/treeview.js")}}></script>
</body>
</html>