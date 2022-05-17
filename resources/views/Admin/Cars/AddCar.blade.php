@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-edit bg-blue"></i>
                    <div class="d-inline">
                        <h5>Car</h5>
                        <span>Add Car</span>
                    </div>
                </div>
            </div>


            <div class="role justify-content-center">
                <div class="col-lg-10">
                    @if(Session::has('status'))
                    <div class="alert bg-success alert-success text-white" role="alert">
                        {{Session::get('status')}}
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h3 style="color: black;">Add Car</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('AdminAddCar') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div>
                                    <label for="">Brand</label>
                                    <select class="form-control" name="PLanguage" required focus>
                                        <option value="" disabled selected>Programming Language</option>
                                        @foreach($PLanguages as $PLanguage)
                                        <option value="{{$PLanguage->PLanguage}}">{{ $PLanguage->PLanguage}}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <div>

                                        <div class="form-group mb-3">
                                            <label for="">Model</label>
                                            <input type="text" name="Model" class="form-control">
                                        </div>
                                        <div>
                                            <label for="">Office</label>
                                            <select class="form-control" name="City" required focus>
                                                <option value="" disabled selected>Select Office</option>
                                                @foreach($Offices as $Office)
                                                <option value="{{$Office->City}}">{{$Office->City}} ,
                                                    {{$Office->Country}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="">Course Image</label>
                                            <input type="file" name="Image" class="form-control">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="">Cost/Day</label>
                                            <input type="text" name="Cost" class="form-contro">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="">Details</label>
                                            <textarea class="form-control" id="textArea" rows="4" name="Details">
                                </textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <button class="btn btn-primary">Add Car</button>
                                        </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection