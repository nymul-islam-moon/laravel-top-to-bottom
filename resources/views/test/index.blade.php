<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  </head>
  <body>

    <h1>This is the header</h1>

    <form action="{{ route('test.submit') }}" method="post" id="submit-form">
        @csrf
        <input type="text" name="name">
        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
    </form>


    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <script>
        $(document).ready( function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#submit-form').submit( function (e) {
                e.preventDefault();
                // $('.submit-btn').prop('type', 'button'); // both are working
                // $('.submit-btn').attr('type', 'button'); // both are working
                var url = $(this).attr('action');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        // alert(data);
                        $('#submit-form')[0].reset();
                        success(data)
                        // $('.submit-btn').prop('type', 'submit'); // not working
                        // alert('Successfully');
                        // $('.submit-btn').attr('type', 'button'); // not working
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });

        });
    </script>
  </body>
</html>
