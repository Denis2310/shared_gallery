{% extends 'base.html' %}

{% block title %} Login to Shared Gallery {% endblock %}


{% block body %}
<h2 align='center'>Login or <a href="register">Register</a></h2>

<div class="row">
 <div class="col-md-6 offset-md-3">
 	<div class="form">
 		<form action="" method="post">
	 		<div class="form-group">
	 			<label for="login-username">Username:</label>
	 			<input class="form-control" type="text" placeholder="Your Username.." id="login-username">
	 		</div>
	 		<div class="form-group">
	 			<label for="login-password">Password:</label>
	 			<input class="form-control" type="password" placeholder="Your Password.." id="login-password"> 			
	 		</div>
	 		<button type="submit" name="submit" class="btn btn-primary float-right">Login</button>
 		</form>
 	</div>
 </div>
</div>
{% endblock %}