@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12 mt-3">
                <img src="{{ asset('assets/images/login-image.png') }}" alt="" class="img-fluid">
            </div>
            <div class="col-md-6 col-sm-12 mt-5">
                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                @include('message')
                <div class="card" id="card">
                    <div class="card-header">Register</div>
                    <form action="#" method="POST" id="registrationForm">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Enter your name" required>
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control"
                                    placeholder="Enter your email" required>
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button id="btnRegister" class="btn btn-primary mt-3">Register</button>
                            </div>
                        </div>
                    </form>
                    <div id="message"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var url = "{{ route('store.seeker') }}";
        document.getElementById('btnRegister').addEventListener('click', function(event) {
            var form = document.getElementById('registerationForm');
            var messageDiv = document.getElementById('message');
            var card = document.getElementById('card');
            messageDiv.innerHTML = '';
            var formData = new FormData(form);

            var button = event.target;
            button.disabled = true;
            button.innerText = 'Sending Email...';

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            }).then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Something went wrong');
                }
            }).then(data => {
                button.innerHTML = 'Register'
                button.disabled = false;
                messageDiv.innerHTML =
                    '<div class="alert alert-success">Registration was successful. Please check your email</div>';
                card.style.display = 'none';
            }).catch(error => {
                button.innerHTML = 'Register'
                button.disabled = false;
                messageDiv.innerHTML =
                    '<div class="alert alert-danger">Something went wrong. Please try again</div>';
            })
        })
    </script>
@endsection
