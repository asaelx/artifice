<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>Footer</title>
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
			.wrapper{
				padding: 0 2rem 2rem 2rem;
			}

			.notes,
			.observations {
			  margin-bottom: 0.5rem;
			}
			.notes .left,
			.observations .left {
			  display: inline-block;
			  width: 80%;
			}
			.notes .right,
			.observations .right {
			  display: inline-block;
			  width: 19%;
			}
			.notes .title,
			.observations .title {
			  font-size: 14px;
			  font-weight: 600;
			}
			.notes .content,
			.observations .content {
			  font-size: 12px;
			  line-height: 1.5;
			}

			.signature {
			  font-size: 13px;
			  text-align: center;
			}

			.footer {
			  font-size: 12px;
			  margin-top: 1rem;
			  text-align: center;
			}
			.footer .address {
			  width: 100%;
			}
			.footer .contact span {
			  display: inline-block;
			  padding: 0 2rem;
			}
		</style>
	</head>
	<body>
		<section class="wrapper">
			@if ($estimate->notes != '')
			    <div class="notes">
			        <h3 class="title">Notas:</h3>
			        <!-- /.title -->
			        <div class="content">{{ $estimate->notes }}</div>
			        <!-- /.content -->
			    </div>
			    <!-- /.notes -->
			@endif
			<div class="observations">
			    <div class="left">
			        <h3 class="title">Observaciones:</h3>
			        <!-- /.title -->
			        <div class="content">
			            {!! nl2br($settings->observations) !!}
			        </div>
			        <!-- /.content -->
			    </div>
			    <!-- /.left -->
			    <div class="right">
			        <div class="signature">
			            <p>Atte.</p>
			            <p>{{ $estimate->user->name }}</p>
			            <p>{{ $settings->title }}</p>
			        </div>
			        <!-- /.signature -->
			    </div>
			    <!-- /.right -->

			</div>
			<!-- /.observations -->
			<footer class="footer">
			    <div class="address">{{ $settings->address }}</div>
			    <div class="contact">
			        <span class="phone">Tel. {{ $settings->phone }}</span>
			        <span class="email">{{ $settings->email }}</span>
			        <span class="store">{{ $settings->store_url }}</span>
			    </div>
			    <!-- /.contact -->
			    <!-- /.address -->
			</footer>
			<!-- /.footer -->
		</section><!-- /.wrapper -->
	</body>
</html>