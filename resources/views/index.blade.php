@extends('layout.defaultNav')

@section('content')
    @include('message.message')
    @include('message.error')
    {!! Form::open(['route'=>'matriz.store', 'method'=>'POST']) !!}
    <div class = "form-group">
        <div>
            {!! Form::label('Seleccione un archivo:') !!}
            <input type = "file" class = "file-loading" id = "fileUpload" name = "fileUpload" accept = "text/plain">
            {!! Form::hidden('hdNameFile','') !!}
            <br>
            {!! Form::submit('Iniciar',['class'=>'btn btn-primary']) !!}
        </div>
    </div>

    {!! Form::close() !!}

    <div class = "container">
        <table class = "table">
            @foreach($arrResp as $resp)
                <tr>
                    <td>{{$resp['operacion']}}</td>
                    <td>{{$resp['resp']}}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <script>
        $(document).on('ready', function () {
            $("#fileUpload").fileinput({
                language: "es",
                previewFileType: "text",
                allowedFileExtensions: ["txt", "text"],
                previewClass: "bg-warning",
                uploadUrl: 'file/uploadFile.php'
            });

            $('#fileUpload').on('filepreupload', function (event, data, previewId, index) {
                var files = data.files;
                $.each(files, function (index, value) {
                    $("[name='hdNameFile']").val(value.name);
                });
            });

            $('#fileUpload').on('fileclear', function (event) {
                $("[name='hdNameFile']").val(null);
            });
        });
    </script>
@endsection

