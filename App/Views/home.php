{% extends 'base.html' %}

{% block title %} Shared Gallery {% endblock %}


{% block body %}
<h2 class="text-center">Welcome to Shared Gallery, Please <a href="login">Login</a> or <a href="register">Register</a></h2>

<div class="row">
	<div class="col-md-6 offset-md-3 text-center">
	 	{% if session.message != '' %}
	 	<div class="alert alert-primary">{{session.message()}}</div>
	 	{% endif %}
		<button type="submit" class="btn btn-success btn-lg btn-images-number">Get number of images uploaded!</button>
		<div class="images-number-container"></div>
	</div>
</div>

{% endblock %}