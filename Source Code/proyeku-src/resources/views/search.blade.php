<!-- Custom CSS -->
<link href="{{url('/assets/css/search.css')}}" rel="stylesheet">

@extends('layouts.header')
@section('header')
@parent
@stop

@section('content')

<!--Result Box -->
<div class="container" style="margin-top: 130px;">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Search Result of {{$search}}</div>
                
                <div class="panel-body">
                    <form class="col-md-10 col-md-offset-1" role="search" style="margin-bottom: 170px;" action="{{url('/searchredirect')}}">
            			<div class="input-group">
                			<input type="text" class="form-control" placeholder="Search" style="height: 40px;" name="search">
                			<div class="input-group-btn">
                    			<button class="btn btn-default" type="submit" style="background-color: #F26151; color: white; height: 40px;"><strong>Cari Freelancer</strong></button>
                			</div>
            			</div>
       				</form>

                    @if(isset($message))
                    <div class="bg-warning" style='padding: 20px; margin-top: 50px;'>{{$message}}</div>
                    
                    @else
                    <div class="bg-warning" style='padding: 20px'>{{$search}}</div>

                    <div>
                        @foreach ($jobs as $job)
                            <a href="">{{ $job->name }}</a>
                            <br/>
                            {{ $job->judul }}
                            <br/>
                            {{ $job->alamat }}
                            <br/>
                            {{ $job->deskripsi }}
                            <br/>
                            {{ $job->upah_max }}
                            {{ $job->upah_min }}
                            <br/>
                            <br/>
                        @endforeach
                        {!! $jobs->links() !!}
                    </div>

                    @endif


                </div>
            </div>
        </div>
    </div>
</div>
@stop
