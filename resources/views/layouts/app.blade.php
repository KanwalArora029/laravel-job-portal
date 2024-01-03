<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Weby Job Portal</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Filepond stylesheet -->
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-dark shadow-lg" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Weby Tech Jobs</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
                    </li>
                    @if (!auth()->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('create.seeker') }}">Job Seeker</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('create.employer') }}">Employer</a>
                        </li>
                    @endif
                    @if (auth()->check())
                        <li class="dropdown nav-item">
                            <button class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
                                style="border: none; background:transparent;">
                                <img src="{{ Storage::url(auth()->user()->profile_pic ?? '') }}" width="40"
                                    class="rounded-circle" alt="">
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('seeker.profile') }}">Profile</a></li>
                                <li><a class="dropdown-item" id="logout" href="#">Logout</a></li>
                            </ul>
                        </li>
                    @endif
                    <form action="{{ route('logout') }}" method="post" id="logout-form">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')


    <script>
        const logout = document.getElementById('logout');
        const form = document.getElementById('logout-form');
        logout.addEventListener('click', function(e) {
            e.preventDefault();
            form.submit();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        // Get a reference to the file input element
        const inputElement = document.querySelector('input[type="file"]');

        // Create a FilePond instance
        const pond = FilePond.create(inputElement);

        pond.setOptions({
            server: {
                url: '/resume/upload',
                process: {
                    method: 'POST',
                    withCredentials: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    ondata: (formData) => {
                        formData.append('file', pond.getFile().file, pond.getFile().file.name);
                        return formData;
                    },
                    onload: (response) => {
                        document.getElementById('btnApply').removeAttribute('disabled');
                    },
                    onerror: (response) => {
                        console.log('error while uploading file.....', response);
                    },
                },
            },
        })
    </script>
</body>

</html>
