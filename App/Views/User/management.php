{% extends 'base.html' %}

{% block title %} Shared Gallery {% endblock %}


{% block body %}

<div class="row">
	<div class="col-md-12 text-center">
		<form method="post" action="" enctype="multipart/form-data">
			<div class="form-group upload_container">
				<div class="circle_upload mx-auto"><i class="fas fa-angle-down"></i></div>
				<input class="" type="file" name="file" id="file">
			</div>
			<button type="submit" name="upload-image" class="btn btn-primary btn-lg">Upload</button>
			{% if session.message != '' %}
			<div class="alert alert-primary col-md-6 offset-md-3 mt-2">{{session.message}}</div>
			{% endif %}
		</form>
	</div>
</div>

<div class="row">
	<div class="col-md-10 offset-md-1">
		<h3 class="uploaded-images">Uploaded images</h3>
		<table class="table table-bordered">
			<thead>
				<th> Id </th>
				<th> Image Path </th>
				<th> Owner </th>
				<th> Image </th>
			</thead>
			<tbody>
				{% for image in images %}
					<tr>
						<td> {{image.id}} </td>
						<td> {{image.path}} </td>
						<td> {{image.username}} </td>
						<td> <img class="rounded" src="../public/images/{{image.user_id}}/{{image.path}}"> </td>
						{% if image.user_id == session.user_id %}
						<td> <a class="delete-image" href="management/{{image.id}}/delete"> Delete </a> </td>
						{% endif %}
					</tr>
				{% endfor %}
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$(".circle_upload").click(function(){
			$("#file").toggle();
		});
	});
</script>

{% endblock %}