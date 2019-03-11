{% extends 'base.html' %}

{% block title %} Register to Shared Gallery {% endblock %}


{% block body %}
 <h2 align='center'>Registration</h2>

<div class="row">
 <div class="col-md-6 offset-md-3">
 	{% if session.message != '' %}
 	<div class="alert alert-primary">{{session.message()}}</div>
 	{% endif %}
 	<div class="form">
 		<form action="" method="POST">
	 		<div class="form-group">
	 			<label for="username">Username:</label>
	 			<input class="form-control" type="text" name="username" placeholder="Your Username.." id="username">
	 		</div>
	 		<div class="form-group">
	 			<label for="email">Email:</label>
	 			<input class="form-control" type="email" name="email" placeholder="example@domain.com" id="email">
	 		</div>
	 		<div class="form-group">
	 			<label for="password">Password:</label>
	 			<input class="form-control" type="password" name="password" placeholder="Your Password.." id="password"> 			
	 		</div>
	 		<div class="form-group">
	 			<label for="password-confirm">Confirm Password:</label>
	 			<input class="form-control" type="password" name="password-confirm" placeholder="Confirm Password.." id="password-confirm"> 			
	 		</div>
	 		<button type="submit" name="submit" class="btn btn-primary float-right">Register</button>
 		</form>
 	</div>
 </div>
</div>
{% endblock %}