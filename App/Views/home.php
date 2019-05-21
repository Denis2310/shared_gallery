{% extends 'base.html' %}

{% block title %} Shared Gallery {% endblock %}

{% block body %}
<h2 class="text-center">Welcome to Shared Gallery, Please <a href="login">Login</a> or <a href="register">Register</a></h2>

<div class="row">
	<div class="col-md-6 offset-md-3 text-center">
	 	{% if session.message != '' %}
	 	<div class="alert alert-primary text-center">{{session.message()}}</div>
	 	{% endif %}
		<button onclick="images_num();" type="submit" class="btn btn-success btn-lg btn-images-number">Get number of images uploaded!</button>
	</div>
</div>

<script>
	function images_num() {
		var request = $.ajax({
			url: 'count',
			type: 'get',
			success: function(response) {
				//json_object = JSON.parse(response);
				//var count = json_object.count;
				var count = response;
				$('.btn-images-number').text('Currently images uploaded: ' + count);
			}

		});

		/*request.done(function(data) {
			$('.btn-images-number').val(data);
		})*/
	}
</script>
{% endblock %}
