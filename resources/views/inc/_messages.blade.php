{{--@if (count($errors) > 0)

    <script>
        Swal.fire({
            title: "<i>Errors</i>",
            html: "<ul class=\"alert alert-danger\">\n" +
                "        @foreach ($errors->all() as $error)\n" +
                "            <li>\n" +
                "                {{ $error }}\n" +
                "            </li>\n" +
                "            <br>\n" +
                "        @endforeach\n" +
                "    </ul>",
        });
    </script>
@endif--}}

@if (Session::get('success'))

    <script>
        $(document).ready(function () {
                swal.fire({
                    title: '{{ Session::get('success') }}',
                    text: false,
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonClass: 'btn btn-success',
                    timer: 4000
                });
        });
    </script>

@endif

@if (Session::get('fail'))
    <script>
        $(document).ready(function () {
            swal.fire({
                type: 'error',
                title: 'Oops...',
                text: '{{ Session::get('fail') }}',
                showCancelButton: false,
                confirmButtonClass: 'btn btn-success',
                timer: 4000
            });
        });
    </script>
@endif

@if (Session::get('info'))
    <script>
        $(document).ready(function () {
            swal.fire({
                type: 'info',
                title: '{{ Session::get('info') }}',
                showCancelButton: false,
                confirmButtonClass: 'btn btn-success',
                timer: 4000
            });
        });
    </script>
@endif


