@extends('client.layout.client_layout')
@section('content')
    
@endsection
@push('scripts')

    <script type="text/javascript">
        var url = "{{ url('/') }}";
        $(document).ready(function () {

        });            
    </script>
    
@endpush('scripts')
