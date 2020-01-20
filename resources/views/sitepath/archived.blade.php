@extends('layouts.site')

@section('content')

    <!-- ОСНОВНАЯ ЧАСТЬ BEGIN -->

    <div class="container mt-3" style="min-height: 900px;">
        <div class="row justify-content-between">
            @csrf
            <div class="col-md-12 nc-col position-relative">

                <div id="post_data" class="post_data"></div>

            </div>
        </div>
    </div>
    <!-- ОСНОВНАЯ ЧАСТЬ END -->


    <script>
        $(document).ready(function(){

            var _token = $('input[name="_token"]').val();
            var data = {};
            load_data('', _token, null, data);

            function load_data(id="", _token, obj=null, data) {
                data.id = id
                data.archived = true
                data._token = _token

                if(obj !== null) {
                    for (var i in obj) {
                        data[i] = obj[i]
                    }
                }

                console.log(data);

                $.ajax({
                    url:"{{ route('loadmore.load_data') }}",
                    method:"POST",
                    data:data,
                    success:function(data)
                    {
                        $('.load_more_button').remove();
                        $('#post_data').append(data);
                    }
                })
            }

            $(document).on('click', '#load_more_button', function(){
                var id = $(this).data('id');
                $('#load_more_button').html('<b>Загружаю...</b>');
                load_data(id, _token, null, data);
            });

        });
    </script>
@endsection
