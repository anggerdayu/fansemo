@extends('layout.base')

@section('content')
<div class="container mt80">
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-12">
			{{-- featured area --}}
			<div class="row mb10">
				<div class="col-sm-12">
					<img src="http://101.50.2.112/usr/1/20150729174651_A7zfMA6j3muVrmDByitVV94HLCu4tES7thDwQpSq.jpg" style="width:100%">
					<div style="background-color:black; color:white;padding-top: 7px;padding-bottom: 18px;padding-left: 20px;font-size: larger;">
						Judul meme featured
					</div>
				</div>
			</div>

			<div class="row mb10">
				<div class="col-sm-12">
					<marquee>Spot text iklan kali ya ..... Just tampilan doang belum dinamis</marquee>
				</div>
			</div>

			<div class="row mb10">
				<div class="col-sm-12 col-md-4 col-lg-4 mb20">
					<center><img src="http://101.50.2.112/imgpost/1/20150729174651_A7zfMA6j3muVrmDByitVV94HLCu4tES7thDwQpSq.jpg" title="Titttsssss" class="img-content"><br><br>
					<p>Meme 1</p>
					</center>
				</div>

				<div class="col-sm-12 col-md-4 col-lg-4 mb20">
					<center><img src="http://101.50.2.112/imgpost/1/20150729174651_A7zfMA6j3muVrmDByitVV94HLCu4tES7thDwQpSq.jpg" title="Titttsssss" class="img-content"><br><br>
					<p>Meme 2</p></center>
				</div>

				<div class="col-sm-12 col-md-4 col-lg-4 mb20">
					<center><img src="http://101.50.2.112/imgpost/1/20150729174651_A7zfMA6j3muVrmDByitVV94HLCu4tES7thDwQpSq.jpg" title="Titttsssss" class="img-content"><br><br>
					<p>Meme 3</p></center>
				</div>
				<div class="col-sm-12 col-md-4 col-lg-4 mb20">
					<center><img src="http://101.50.2.112/imgpost/1/20150729174651_A7zfMA6j3muVrmDByitVV94HLCu4tES7thDwQpSq.jpg" title="Titttsssss" class="img-content"><br><br>
					<p>Meme 1</p>
					</center>
				</div>

				<div class="col-sm-12 col-md-4 col-lg-4 mb20">
					<center><img src="http://101.50.2.112/imgpost/1/20150729174651_A7zfMA6j3muVrmDByitVV94HLCu4tES7thDwQpSq.jpg" title="Titttsssss" class="img-content"><br><br>
					<p>Meme 2</p></center>
				</div>

				<div class="col-sm-12 col-md-4 col-lg-4 mb20">
					<center><img src="http://101.50.2.112/imgpost/1/20150729174651_A7zfMA6j3muVrmDByitVV94HLCu4tES7thDwQpSq.jpg" title="Titttsssss" class="img-content"><br><br>
					<p>Meme 3</p></center>
				</div>
				<div class="col-sm-12 col-md-4 col-lg-4 mb20">
					<center><img src="http://101.50.2.112/imgpost/1/20150729174651_A7zfMA6j3muVrmDByitVV94HLCu4tES7thDwQpSq.jpg" title="Titttsssss" class="img-content"><br><br>
					<p>Meme 1</p>
					</center>
				</div>

				<div class="col-sm-12 col-md-4 col-lg-4 mb20">
					<center><img src="http://101.50.2.112/imgpost/1/20150729174651_A7zfMA6j3muVrmDByitVV94HLCu4tES7thDwQpSq.jpg" title="Titttsssss" class="img-content"><br><br>
					<p>Meme 2</p></center>
				</div>

				<div class="col-sm-12 col-md-4 col-lg-4 mb20">
					<center><img src="http://101.50.2.112/imgpost/1/20150729174651_A7zfMA6j3muVrmDByitVV94HLCu4tES7thDwQpSq.jpg" title="Titttsssss" class="img-content"><br><br>
					<p>Meme 3</p></center>
				</div>
			</div>
		</div>

		<div class="col-lg-4 col-md-4 col-sm-12">
			{{-- video --}}
			<div class="row mb10">
				<div class="col-sm-12">
					<iframe style="width:100%; height:300px" src="https://www.youtube.com/embed/IV878LDRbQU" frameborder="0" allowfullscreen></iframe>
				</div>
			</div>

			<div class="row mb10">
				<div class="col-sm-12 admin-msg">
					<p>Ini area pesan dari admin, sementara belum bisa diedit karena masih dummy.<br>Mohon sabar menunggu sampai fitur selesai.</p>
				</div>
			</div>

			<h3><i class="glyphicon glyphicon-thumbs-up"></i> Editor's Pick</h3>

			<ul class="list-group">
			  <li class="list-group-item">
			  	<div class="row">
			  		<div class="col-sm-12 col-md-4 col-lg-4 mb10">
			  			<center><img src="http://101.50.2.112/imgpost/1/20150729174651_A7zfMA6j3muVrmDByitVV94HLCu4tES7thDwQpSq.jpg" title="Titttsssss" class="img-content"></center>
			  		</div>
			  		<div class="col-sm-12 col-md-6 col-lg-6">
			  			<center>
			  				<strong>Meme1</strong><br>
			  				<p>100 likes, 10 dislikes</p>
			  				<button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
			  			</center>
			  		</div>
			  	</div>	
			  </li>
			  <li class="list-group-item">
			  	<div class="row">
			  		<div class="col-sm-12 col-md-4 col-lg-4 mb10">
			  			<center><img src="http://101.50.2.112/imgpost/1/20150729174651_A7zfMA6j3muVrmDByitVV94HLCu4tES7thDwQpSq.jpg" title="Titttsssss" class="img-content"></center>
			  		</div>
			  		<div class="col-sm-12 col-md-6 col-lg-6">
			  			<center>
			  				<strong>Meme2</strong><br>
			  				<p>100 likes, 10 dislikes</p>
			  				<button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
			  			</center>
			  		</div>
			  	</div>	
			  </li>
			  <li class="list-group-item">
			  	<div class="row">
			  		<div class="col-sm-12 col-md-4 col-lg-4 mb10">
			  			<center><img src="http://101.50.2.112/imgpost/1/20150729174651_A7zfMA6j3muVrmDByitVV94HLCu4tES7thDwQpSq.jpg" title="Titttsssss" class="img-content"></center>
			  		</div>
			  		<div class="col-sm-12 col-md-6 col-lg-6">
			  			<center>
			  				<strong>Meme3</strong><br>
			  				<p>100 likes, 10 dislikes</p>
			  				<button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
			  			</center>
			  		</div>
			  	</div>	
			  </li>
			  <li class="list-group-item">
			  	<div class="row">
			  		<div class="col-sm-12 col-md-4 col-lg-4 mb10">
			  			<center><img src="http://101.50.2.112/imgpost/1/20150729174651_A7zfMA6j3muVrmDByitVV94HLCu4tES7thDwQpSq.jpg" title="Titttsssss" class="img-content"></center>
			  		</div>
			  		<div class="col-sm-12 col-md-6 col-lg-6">
			  			<center>
			  				<strong>Meme4</strong><br>
			  				<p>100 likes, 10 dislikes</p>
			  				<button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
			  			</center>
			  		</div>
			  	</div>	
			  </li>
			  <li class="list-group-item">
			  	<div class="row">
			  		<div class="col-sm-12 col-md-4 col-lg-4 mb10">
			  			<center><img src="http://101.50.2.112/imgpost/1/20150729174651_A7zfMA6j3muVrmDByitVV94HLCu4tES7thDwQpSq.jpg" title="Titttsssss" class="img-content"></center>
			  		</div>
			  		<div class="col-sm-12 col-md-6 col-lg-6">
			  			<center>
			  				<strong>Meme5</strong><br>
			  				<p>100 likes, 10 dislikes</p>
			  				<button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-up"></i></button>
                <button class="btn btn-default disabledlike" data-toggle="modal" data-target="#modalSignin"><i class="glyphicon glyphicon-thumbs-down"></i></button>
			  			</center>
			  		</div>
			  	</div>	
			  </li>
			</ul>


		</div>
	</div>
</div>
@stop