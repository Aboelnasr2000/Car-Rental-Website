@extends('layouts.app')

@section('content')
<div>
    @foreach($MyCourses as $MyCourse)
    <h1 class="container myContainer p-4">

        <div class='col-md-12 p-2 d-flex'>
            <img src="{{ asset('uploads/Courses/'.$MyCourse->Image) }}" width="200px" height="200px " alt="Image"
                class="myimg2">
            <div style="font-size: 1.5rem; color: black; padding-top: 20px;">
                Start date : {{$MyCourse->Start_date}}
                <br>
                End date : {{$MyCourse->End_Date}}
                <br>
                City : {{$MyCourse->City}}
                <br>
                Rental Id : {{$MyCourse->registeredid}}
                <br>
                @if($MyCourse->Paid == "No")
                <div style="text-align: left; align-self: end; padding-left: 400px;">
                    <form action="/Pay/{{$MyCourse->registeredid}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <button type="submit" class="btn btn-primary mt-md-3 "
                            style="border-radius: 15px;font-size:1.4rem; box-sizing: 15px">
                            Pay
                        </button>
                    </form>
                </div>
                @endif
                <div style="text-align: left; align-self: end; padding-left: 30px;">
                    <form action="/Cancel/{{$MyCourse->registeredid}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <button type="submit" class="btn btn-primary mt-md-3 "
                            style="border-radius: 15px;font-size:1.4rem; box-sizing: 15px">
                            Cancel Reservation
                        </button>
                    </form>
                </div>
            </div>

    </h1>
    @endforeach
</div>
@endsection