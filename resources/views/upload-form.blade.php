@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div id="output" class="container"></div>
                    <div class="card-header" style="margin-bottom: 10px;"> UPLOAD FORM</div>
                    <form role="form" class="form" onsubmit="return false;">

                        <div class="form-control ">
                            <label for="uploadFile">Select file </label>
                            <input type="file" id="uploadFile" class="form-control" style="margin-top: 15px;">
                            <button type="submit" id="uploadBtn" class="btn btn-success mx-auto" style="margin-top: 10px;">Upload</button>
                        </div>
                    </form>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        (function () {
            var output = document.getElementById('output');
            document.getElementById('uploadBtn').onclick = function () {
                var data = new FormData();
                data.append('foo', 'bar');
                data.append('uploadFile', document.getElementById('uploadFile').files[0]);

                var config = {
                    headers : { 'Content-Type': 'multipart/form-data' },
                    onUploadProgress: function(progressEvent) {
                        var percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                    }
                };

                axios.put('/upload/server', data, config)
                    .then(function (res) {
                        output.innerHTML = res.data;
                    })
                    .catch(function (err) {
                        output.className = 'text-danger';
                        output.innerHTML = err.message;
                    });
            };
        })();
    </script>

@endsection
