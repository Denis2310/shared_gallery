{% extends 'base.html' %}

{% block title %} Shared Gallery {% endblock %}


{% block body %}

<h2 class="text-center">Welcome dear User to Shared Gallery </h3>

<div class="row">
	<div class="col-md-6 offset-md-3 text-center">
		<button type="submit" class="btn btn-success btn-lg btn-images-number">Get number of images uploaded!</button>
		<div class="images-number-container"></div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<p class="text-center home-text">Please upload new images to your account, or review uploaded images. Of course, you can check images from all users :)</p>
	</div>
</div>

{% endblock %}
