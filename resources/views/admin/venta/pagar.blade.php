@extends('layouts.admin-pro')
@include('alerts.errors')
@section('content')







           <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor"><i class="mdi mdi-bank font-red"></i>
                  <span class="caption-subject font-red sbold uppercase">Realizar el Pago</span></h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{!! URL::to('/') !!}">Home</a></li>
                            <li class="breadcrumb-item active "><a href="#">Pagar Factura </a></li>
                        </ol>
                    </div>
                </div>





                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">



        <h4 class="card-title"></h4>


      <h6 class="card-subtitle"></h6>
    <div class="text-center">
    <iframe src="<?php echo $preference['response']['init_point']; ?>" name="MP-Checkout" width="800" height="800" frameborder="0"></iframe>
    </div>
<script type="text/javascript" src="//resources.mlstatic.com/mptools/render.js"></script>




                            </div>
                        </div>
                    </div>
                </div>





@endsection
