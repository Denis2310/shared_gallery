{% extends 'base.html' %}

{% block title %} Login to Shared Gallery {% endblock %}


{% block body %}
<h2 align='center'>Login or <a href="register">Register</a></h2>

<div class="row">
 <div class="col-md-6 offset-md-3">
 	{% if session.message != '' %}
 	<div class="alert alert-primary">{{session.message()}}</div>
 	{% endif %}
 	<div class="form">
 		<form action="" method="post">
	 		<div class="form-group">
	 			<label for="username">Username:</label>
	 			<input class="form-control" type="text" name="username" placeholder="Your Username.." id="username">
	 		</div>
	 		<div class="form-group">
	 			<label for="password">Password:</label>
	 			<input class="form-control" type="password" name="password" placeholder="Your Password.." id="password"> 			
	 		</div>
	 		<button type="submit" name="submit" class="btn btn-primary float-right">Login</button>
 		</form>
 	</div>
 </div>
</div>

{% endblock %}