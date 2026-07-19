@extends('app')

@section('pagetitle', 'LOGIN')

{{-- ###################----SECTION START----######## --}}
@section('content')
<body>
    <div class="account-pages"></div>
    <div class="clearfix"></div>
    <div class="wrapper-page">
        <div style="box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;" class=" card-box">
            <div class="panel-heading">
                <h3 class="text-center"><strong class="text-danger">I D C</strong> </h3>
            </div>

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    @php
                        flash()->addWarning($error);

                    @endphp
                @endforeach
            @endif



            <div class="panel-body">
                <form class="form-horizontal m-t-20" action="{{ route('Page.login_auth') }}" method="post">
                    @csrf

                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" name="Username" type="text" required placeholder="Username">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" name="Password" type="password" required placeholder="Password">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <select name="Role" required class="form-control">
                                <option selected disabled>Select Role</option>
                                <option value="1">Admin</option>
                                <option value="2">Laboratory Technician</option>
                                <option value="3">Pathologist </option>
                            </select>
                        </div>
                    </div>



                    <div class="form-group text-center m-t-40">
                        <div class="col-xs-12">
                            <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light"
                                type="submit">Log
                                In</button>
                        </div>
                    </div>

                    <div class="form-group m-t-30 m-b-0">
                        <div class="col-sm-12">
                            {{-- <a href="page-recoverpw.html" class="text-dark"><i class="fa fa-lock m-r-5"></i> Forgot your
                                password?</a> --}}
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>

</body>

    {{-- ###################----SECTION END----######## --}}
@endsection
