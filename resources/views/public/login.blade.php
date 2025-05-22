<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TFG</title>
        <x-layout.head />
    </head>
    <body class="bg-light">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header text-center bg-primary text-white">
                            <h4>Login</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                @error('login_error')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                @if (session('redirect_error'))
                                    <div class="alert alert-warning">
                                        {{ session('redirect_error') }}
                                    </div>
                                @endif

                                @if(session('redirect_route_name'))
                                    <input type="hidden" name="redirect_route_name"
                                           value={{ session('redirect_route_name') }} />
                                @endif

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button class="btn btn-primary w-100">Login</button>

                                <div class="text-center mt-3">
                                    <a href="{{ route('register') }}">Don't have an account? Register</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-layout.scripts />
    </body>
</html>