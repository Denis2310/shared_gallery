{% extends 'base.html' %}

{% block title %} Shared Gallery {% endblock %}


{% block body %}
<!-- Ovdje treba dodati objekt od usera koji se dohvaca iz baze podataka za registriranog korisnika i onda njegove podatek ubaciti u formu -->
 <h2 class="text-center">Edit Account - {{user.username}}</h2>

<div class="row">
 <div class="col-md-6 offset-md-3">
 	{% if session.message != '' %}
 	<div class="alert alert-primary text-center">{{session.message()}}</div>
 	{% endif %}
 	<div class="form">
 		<form action="update" method="post">
	 		<div class="form-group">
	 			<label for="username">Username:</label>
	 			<input class="form-control" type="text" placeholder="{{user.username}}" id="username" disabled>
	 		</div>
	 		<div class="form-group">
	 			<label for="email">Email:</label>
	 			<input class="form-control" type="email" placeholder="{{user.email}}" id="email" disabled>
	 		</div>
	 		<div class="form-group">
	 			<label for="old-password">Password:</label>
	 			<input class="form-control" type="password" name="old-password" placeholder="Enter current password.." id="old-password">
	 		</div>
	 		<div class="form-group">
	 			<label for="new-password">New Password:</label>
	 			<input class="form-control" type="password" name="new-password" placeholder="New password.." id="new-password">
	 		</div>
	 		<div class="form-group">
	 			<label for="password-confirm">Confirm New:</label>
	 			<input class="form-control" type="password" name="password-confirm" placeholder="Confirm new password.." id="password-confirm">
	 		</div>
	 		<a onclick="return confirm('Your account will be deleted.');" href="myaccount/delete" class="btn btn-danger"> Remove Account </a>
	 		<button type="submit" name="edit-user" class="btn btn-primary float-right"> Save Changes </button>
 		</form>
 	</div>
 </div>
</div>

{% endblock %}
