@extends('layouts.app')
@section('PageTitle')Aqar -{{$page_title}} posts @endsection
@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $inputBorder= str_replace('_', '-', app()->getLocale()) =='ar' ? 'border-left-0' : 'border-right-0';
    $buttonBorder=  str_replace('_', '-', app()->getLocale()) =='ar' ? 'border-right-0' : 'border-left-0';
@endphp
@section('content')

    <div class="main-form-container ">
        <div class="container">
            <h2 class="text-center text-uppercase text-white"><strong>{{ __('frontend.discover_your_city') }}</strong></h2>
            <br>
            <br>
            <div class="text-center row align-items-center">

                <div class="col-md-5 m-auto btn-group" role="group" aria-label="First group">
                    <br>
                    <a href="{{route('filterPosts',['type'=>'rent'])}}" type="button" class="text-uppercase serch-filtering btn btn-secondary" filter-type="rent">{{ __('frontend.rent') }}</a>
                    <a href="{{route('filterPosts',['type'=>'selling'])}}" type="button" class="text-uppercase serch-filtering btn btn-secondary" filter-type="selling">{{ __('frontend.sel') }}</a>
                    <a href="{{url('/')}}" type="button" class="text-uppercase serch-filtering btn btn-secondary" filter-type="">{{ __('frontend.all_news') }}</a>

                </div>
            </div>
            <div class="text-center row align-items-center">
                <div class="col-md-5 m-auto">
                    <form method="post" action="{{route('search')}}" class="form-row">
                        @csrf
                        <div class="form-group col-10 p-0">
                            <input type="hidden" name="searchOption" value="all" id="searchOption">
                            <input type="text" autocomplete="off" placeholder="{{ __('frontend.search') }}" name="filterType" class="form-control rounded-0 {{$inputBorder}} form-control-lg">
                        </div>
                        <div class="form-group col-2 p-0">
                            <button type="submit" class="form-control bg-primary rounded-0 {{$buttonBorder}} form-control-lg p-0">
                                <i class="fas fa-lg fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <div class="main-news-container">
        <div class="container-fluid">
            <h2 class="text-center text-capitalize"><a href="#">{{ __('frontend.new_posts') }}</a></h2>

            <div class="multi-slider" dir="ltr">
                <div class="row no-flow m-auto">
                    <div class=" slider-controler text-center slider-controler-right" id="next-slider"> &gt; </div>
                    <div class=" slider-container col-sm-10 offset-md-1">
                        <ul class="list-slider" style="transform: translate(368px);">
                            @php
                                $fullOpacity='full-opacity';
                            @endphp
                            @foreach($randomPosts as $postItem)
                            <li class="slider-list-item multislider-item {{$fullOpacity}}">
                                <div class="card rounded-0">
                                    <img class="card-img-top" height="270" src="{{asset($postItem->mainImage)}}">
                                    <div class="card-block">
                                        <h4 class="card-title text-center"><a href="{{route('postDetails',['post_id'=>$postItem->id])}}">{{$postItem->post_name}}</a></h4>
                                        <div class="text-right card-text">
                                            {{$postItem->desc}}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-right"><i class="far fa-calendar-check"></i> {{$postItem->created_at}}</span>
                                        <span><i class=""></i><i class="fas fa-images"></i> {{$postItem->imgCount}} </span>
                                    </div>
                                </div>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                    <div class=" slider-controler text-center slider-controler-left" id="pre-slider"> &lt; </div>

                </div>
            </div>
        </div>
        <div class="container">
            <h2 class="text-center text-capitalize"><a href="#">{{ __('frontend.'.$page_title) }}</a></h2>
            <div class="row border">
                @foreach($posts as $postItem)
                    <div data-aos="fade-right"   data-aos-duration="500" class="col-sm-6 col-md-4 col-lg-3 mt-4">
                        <div class="card rounded-0">
                            <img height="270" class="card-img-top" src="{{asset($postItem->mainImage)}}">
                            <div class="card-block">
                                <h4 class="card-title text-center"><a href="{{route('postDetails',['post_id'=>$postItem->id])}}">{{$postItem->post_name}}</a></h4>
                                <div class="card-text">
                                    {{$postItem->desc}}
                                </div>
                            </div>
                            <div class="card-footer">
                                <span class="float-right"><i class="far fa-calendar-check"></i> {{$postItem->created_at}}</span>
                                <span><i class=""></i><i class="fas fa-images"></i> {{$postItem->imgCount}} </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection





