<?php
$booking = true;
?>

@extends('layouts.main')

@section('breadcrumbs')
    <li>Booking Form</li>
@endsection

@section('content')
    <div class="row">
        @if (isset($response->Status->Errors))
            <div class="alert alert-danger">
                {{ $response->Status->Errors->Error->Message }}
            </div>
        @else

        @endif
    </div><!--End row -->
@endsection

@section('footer_javascript')
    <script src="js/icheck.js"></script>
    <script>
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-grey',
            radioClass: 'iradio_square-grey'
        });
    </script>


@endsection