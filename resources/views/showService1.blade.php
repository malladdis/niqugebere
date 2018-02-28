@extends('layouts.app')
@section('content')
    <style>
        img{
            z-index: 0;
        }
        #posted-content{
            min-height: 20em;
        }
    </style>
    <div class="row">
        <div class="container">
            <div class="card">
                <div class="card-title green darken-1 center white-text" style="padding: 2%;">
                    {{$title}}
                </div>
            </div>
            <div class="col l3 m3 s12">
                <div class="card">
                    <div class="card-content no-padding">
                        <ul class="collection">
                            @foreach($services as $service)
                                <li class="collection-item"><a href='{{url("cfc/service/$service->id")}}' class="green-text">{{$service->title}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col l9 m9 s12">
                <div class="card">
                    <div class="card-title" style="padding: 2%; padding-bottom: 0;">
                        {{$ser[0]->title}}
                        <br> <label class="right">posted by {{$ser[0]->company}}</label>
                        <br> <label class="right">{{\Carbon\Carbon::createFromTimeStamp(strtotime($ser[0]->created_at))->diffForHumans()}}</label>
                    </div>
                    <div class="card-content" id="posted-content">
                        {!! $ser[0]->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection