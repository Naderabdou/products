@extends('dashboard.layout.Master')
@section('title')
    PRODUCT
@endsection
@section('js')
    <!-- Theme JS files -->
    <script src="/admin/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/admin/global_assets/js/plugins/forms/selects/select2.min.js"></script>

    <script src="/admin/global_assets/js/demo_pages/datatables_basic.js"></script>
    <script>
              function alert() {
                  let ele=  document.getElementById('alert-message');

                  ele.style.display='none'
              }
    </script>
    <!-- /theme JS files -->
@endsection

@section('content')
    <!-- Trigger the modal with a button -->

    <div style="margin: 10px; ">
        <button style="border-radius: 50px" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">create new product  <i class="icon-plus2"></i></button>

    </div>


    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        {!! Form::open(['route' => 'admin.products.store' , 'method'=>'post','class'=>'form-horizontal','enctype'=>'multipart/form-data']) !!}

        @csrf

        @include('dashboard.product.form')

        {!! Form::close() !!}

    </div>
    @if(session()->has('message'))
        <div class="alert alert-success" id="alert-message" onclick="alert()">
            {{ session()->get('message') }}
        </div>
    @endif

    <!-- Basic datatable -->
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title"> Interested</h5>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>



        <table class="table datatable-basic">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>

                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @php
                $i=0
            @endphp
            @foreach($products as $product)
                <tr>


                    <td>{{++$i}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->desc}}</td>
                    <td>{{$product->price}}</td>
                    <td><img src="storage/{{$product->img}}" style="height: 100px; width: 100px;"></td>
                    <td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">

                                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <button type="button"class="btn btn-danger"style="width:100px ;" data-toggle="modal" data-target="#edit{{$product->id}}"> Edit <i class="icon-database-edit2"></i></button></li>
                                    <li>
                                        <form action="{{route('admin.products.destroy',$product->id)}}" method="POST">
                                            @method('delete')
                                            @csrf

                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit"class="btn btn-danger"style="width:100px ;">Delete</button>
                                        </form>

                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </td>

                </tr>
                <div id="edit{{$product->id}}" class="modal fade" role="dialog">
                    {!! Form::model($product, ['route' => ['admin.products.update', $product->id],'class'=>'form-horizontal','method'=>'PATCH','enctype'=>'multipart/form-data','file'=>true]) !!}

                    @csrf

                    @include('dashboard.product.form')

                    {!! Form::close() !!}

                </div>
            @endforeach


            </tbody>
        </table>
    </div>
    <!-- /basic datatable -->
@endsection
