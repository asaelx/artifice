<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>Header</title>
		<link href="https://fonts.googleapis.com/css?family=Titillium+Web:400,400i,600,600i,700,700i" rel="stylesheet">
		<style>
			*{
				margin: 0;
				padding: 0;
				box-sizing: border-box;
			}
			body{
				font-family: 'Titillium Web', sans-serif;
			}
			.header{
				padding: 2rem 2rem 0 2rem;
			}
			.header .logo {
			  background: #000000;
			  padding: 1rem;
			  text-align: center;
			}
			.header .logo .img {
			  width: 150px;
			}
			.header .info {
			  padding: 0.5rem 0;
			}
			.header .info .data {
			  font-size: 14px;
			  display: inline-block;
			  font-weight: 400;
			  padding: 0.2rem;
			  width: 49%;
			}
			.header .info .data.right {
			  padding-left: 10rem;
			}
		</style>
	</head>
	<body>
		<header class="header">
		    <div class="logo">
		        @if (isset($settings->sidebar_logo->url))
		            <img src="{{ asset('storage/'.$settings->estimate_logo->url) }}" alt="{{ $settings->title }}" class="img">
		        @else
		            <img src="{{ asset('img/logo_cotizacion.png') }}" alt="{{ $settings->title }}" class="img">
		        @endif
		    </div>
		    <!-- /.logo -->
		    <div class="info">
		        <span class="data left"><b>Orden de pedido</b></span>
		        <span class="data right"><b>Fecha:</b> {{ ucfirst(\Date::today()->format('d/m/Y')) }}</span>
		        <span class="data left"><b>Atención:</b> {{ $estimate->client->name }}</span>
		        <span class="data right"><b>Teléfono:</b> {{ $estimate->client->phone }}</span>
		        <span class="data left"><b>E-mail:</b> {{ $estimate->client->email }}</span>
		        <span class="data right"><b>Vendedor:</b> {{ $estimate->user->name }}</span>
		    </div>
		    <!-- /.info -->
		</header>
		<!-- /.header -->
	</body>
</html>
