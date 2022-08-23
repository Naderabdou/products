@extends('dashboard.layout.master')
@section('content')
    @if(session()->has('message'))
        <div class="alert alert-success" id="alert-message" onclick="alert()">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main sidebar -->
            <!-- /main sidebar -->


            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Page header -->
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">

                    <!-- Detached content -->
                    <div class="container-detached">
                        <div class="content-detached">

                            <!-- List -->
                            <ul class="media-list">
                                @foreach($products as $product)
                                    <li  class="media panel panel-body stack-media-on-mobile">
                                        <a href="{{route('admin.products.show',$product->id)}}" class="media-left" data-popup="lightbox">
                                            <img src="storage/{{$product->img}}" width="300" alt="" height="200">
                                        </a>

                                        <div class="media-body">
                                            <h6 class="media-heading text-semibold">
                                                <a href="{{route('admin.products.show',$product->id)}}">{{$product->name}}</a>
                                            </h6>



                                            <p class="content-group-sm">{{$product->desc}}</p>


                                        </div>

                                        <div class="media-right text-center">
                                            <h3 class="no-margin text-semibold">{{$product->price}}$</h3>

                                            <div class="text-nowrap">
                                                @if(count($product->rate) > 0 )
                                                    @if(count($product->rate->where('rate','=','5'))  >= count($product->rate->where('rate','=','4')) && count($product->rate->where('rate','=','5'))  >= count($product->rate->where('rate','=','3')) &&count($product->rate->where('rate','=','5'))  >= count($product->rate->where('rate','=','2')) && count($product->rate->where('rate','=','5'))  >= count($product->rate->where('rate','=','1')) )
                                                     @for($i=0; $i<5; $i++)
                                                            <i class="icon-star-full2 text-size-base text-warning-300"></i>

                                                        @endfor

                                                    @elseif(count($product->rate->where('rate','=','4'))  >= count($product->rate->where('rate','=','3')) && count($product->rate->where('rate','=','4'))  >= count($product->rate->where('rate','=','2')) && count($product->rate->where('rate','=','4'))  >= count($product->rate->where('rate','=','1')))
                                                        @for($i=0; $i<4; $i++)
                                                            <i class="icon-star-full2 text-size-base text-warning-300"></i>

                                                        @endfor

                                                    @elseif(count($product->rate->where('rate','=','3'))  >= count($product->rate->where('rate','=','2')) && count($product->rate->where('rate','=','3'))  >= count($product->rate->where('rate','=','1')))
                                                        @for($i=0; $i<3; $i++)
                                                            <i class="icon-star-full2 text-size-base text-warning-300"></i>

                                                        @endfor
                                                    @elseif(count($product->rate->where('rate','=','2'))  >= count($product->rate->where('rate','=','1')))
                                                        @for($i=0; $i<2; $i++)
                                                            <i class="icon-star-full2 text-size-base text-warning-300"></i>

                                                        @endfor

                                                    @else
                                                        <h5> تقييم المنتج: <span>لايوجد تقيم</span></h5>  </h1>
                                                    @endif
                                                @else
                                                    <h5> تقييم المنتج: <span>لايوجد تقيم</span></h5>  </h1>
                                                @endif

                                            </div>

                                           <a href="{{route('admin.payment',['product_id'=>$product->id, 'user_id'=>auth()->user()->id])}}">
                                               <button type="button" class="btn bg-teal-400 mt-15"><i class="icon-cart-add position-left"></i> Buy Now</button>
                                           </a>
                                            <form action="{{route('admin.cart')}}" method="post">
                                              @csrf
                                                <input type="hidden" name="product_id" value="{{$product->id}}" id="product_id" >
                                               <input type="hidden" name="user_id" value="{{auth()->user()->id}}" id="user_id">
                                                <button type="submit" class="btn bg-teal-400 mt-15 cart" ><i class="icon-cart-add position-left"></i> Add to cart</button>

                                            </form>

                                        </div>
                                    </li>
                                @endforeach

                            </ul>
                            <!-- /list -->


                            <!-- Pagination -->
                            <div class="text-center content-group-lg pt-20">
                                <ul class="pagination">
                                    {{$products->links()}}
                                </ul>
                            </div>
                            <!-- /pagination -->

                        </div>
                    </div>
                    <!-- /detached content -->


                    <!-- Detached sidebar -->
                    <!-- /detached sidebar -->



                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
@endsection
@section('js')
    <script>
        function alert() {
            let ele=  document.getElementById('alert-message');

            ele.style.display='none'
        }
    </script>
    @endsection

