@extends('layouts.free')

@section('title', 'Login')

@section('extra-css')

@endsection

@section('content')
<div class="container">
	<div class="row" style="margin-top: 80px">
		<div class="col-md-4 col-md-offset-4">
			<div class="card">
				<div class="card-header" data-background-color="blue">
					<h4 class="title">Acceder</h4>
				</div>
				<div class="card-content table-responsive">
                    {{ Form::open(['url' => 'login', 'method' => 'POST']) }}
						<fieldset>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="usuario" name="email" required>
							</div>
							<div class="form-group">
								<input type="password" class="form-control" placeholder="contraseña" name="password" required>
                            </div>
                            <div class="align-center">
                                @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade in">
                                    @foreach ($errors->all() as $error)
                                    <p style="margin: 0;">{{ $error }}</p>
                                    @endforeach
                                </div>
                                @endif
                            </div>
							<input class="btn btn-primary btn-block" type="submit" value="Iniciar Sesion">
						</fieldset>
                    {{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('extra-js')

@endsection
