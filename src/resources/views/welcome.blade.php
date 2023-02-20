<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">

        <div class="my-5">
            <div class="card">
                <div class="card-header">
                    Convert format shopee file
                </div>
                <div class="card-body">
                    <h5 class="card-title">Upload Shopee file...</h5>
                    <form action="{{ route('import.shopee-to-lazada') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row mb-2">
                            <div class="form-group col-md-6">
                                <label for="start_col">Start generate columns to rows</label>
                                <input type="number" class="form-control" id="start_col" placeholder="Start generate columns to rows" name="start_col">
                            </div>
                        </div>
                        <div class="mb-2">
                            <input class="form-control form-control-lg" id="file" type="file" name="file">
                        </div>
                        <div class="mb-2">
                            <button type="submit" class="btn btn-primary mb-3">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>