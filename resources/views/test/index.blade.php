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

    <div class="container">
        <div class="row">
            <div class="col-md-2">

            </div>
            <div class="col-md-8">
                <h3 class="my-5 text-center">Laravel 9 Ajax CRUD</h3>
                <a href="" class="btn btn-success my-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Product</a>
                <div class="table-data">
                    <table class="table table-dark table-striped table-bordered" id="data-table">

                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Action</th>
                                <th scope="col">Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tests as $key=> $item)
                                <tr>
                                    <th scope="row">{{ $key+1 }}</th>
                                    <td>
                                        <a href="" class="btn btn-success" id="edit_data">Edit</a>
                                        <a href="{{ route('test.destroy', $item->id) }}" class="btn btn-danger" id="delete_data">Delete</a>
                                    </td>
                                    <td>{{ $item->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="errorMsgContainer">

            </div>
            <div class="modal-body">
                <form class="row g-3" action="{{ route('test.submit') }}" method="POST" id="submit-form">
                    @csrf
                    <div class="row g-3 form-floating">
                        <div class="col">
                          <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" aria-label="Full Name">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary submit-btn">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>

    <form id="deleted_form" action="" method="post">
        @method('DELETE')
        @csrf
    </form>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    {{-- Sweet alert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready( function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            /**
             * author : Nymul Islam Moon
             * submit form
             *
             * */

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
                        $("#exampleModal").modal('hide');
                        $('#submit-form')[0].reset();
                        $( "#data-table" ).load(window.location.href + " #data-table" );
                        // $('.submit-btn').prop('type', 'submit'); // not working
                        // alert('Successfully');
                        // $('.submit-btn').attr('type', 'button'); // not working
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });


            $(document).on('click', '#delete_data', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');

                var x = $('#deleted_form').attr('action', url);

                alert(x);

            });

        });
    </script>
  </body>
</html>
