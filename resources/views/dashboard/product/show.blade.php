@extends('dashboard.layout.master')
@section('css')
    <style>





        label {

            cursor: pointer;
            display: inline-flex;
            transition: color 0.5s;
        }

        svg {
            -webkit-text-fill-color: transparent;
            filter:drop-shadow(5px 1px 3px rgba(198, 206, 237, 1));
        }

        input {
            height: 100%;
            width: 100%;
        }

        input {
            display: none;
        }

        label:hover,
        label:hover ~ ,
        input:checked ~   {
        }

        label:hover,
        label:hover ~ label,
        input:checked ~ label  {
            color: yellow;
        }

    </style>


@endsection
@section('content')

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

                    <!-- Post grid -->
                    <div class="row">
                        @if(isset($product))
                                <div class="col-md-12">
                                    <div class="panel panel-flat">
                                        <div class="panel-body">
                                            <div class="thumb content-group">
                                                <img src="/storage/{{$product->img}}" alt="" class="img-responsive">
                                                <div class="caption-overflow">
											<span>
												<a  class="btn btn-flat border-white text-white btn-rounded btn-icon"><i class="icon-arrow-right8"></i></a>
											</span>
                                                </div>
                                            </div>

                                            <h5 class="text-semibold mb-5">
                                                <a href="#" class="text-default">{{$product->name}}</a>
                                            </h5>

                                            <ul class="list-inline list-inline-separate text-muted content-group">
                                                <li>By <a href="#" class="text-muted">Eugene</a></li>
                                                <li>{{\Carbon\Carbon::parse($product->created_at)->translatedFormat('l j F Y ')}}</li>
                                            </ul>

                                            {{$product->desc}}                                </div>

                                        <div class="panel-footer panel-footer-condensed">
                                            <div class="heading-elements not-collapsible">
                                                <ul class="list-inline list-inline-separate heading-text text-muted">
                                                    <li><a  class="text-muted"> $ Price : {{$product->price}} </a></li>
                                                </ul>


                                            </div>
                                        </div>
                                        <div class="panel-footer panel-footer-condensed">
                                            <div class="heading-elements not-collapsible">


                                                <a href="#" class="heading-text pull-left">Buy Now <i class="icon-coin-dollar position-right"></i></a>

                                            </div>
                                        </div>
                                        <div class="panel-footer panel-footer-condensed">
                                            <div class="heading-elements not-collapsible">


                                                <a href="#" class="heading-text pull-center">Add cart <i class="icon-cart-add position-right"></i></a>

                                            </div>
                                        </div>

                                        <div class="panel-footer panel-footer-condensed">
                                            <div class="heading-elements not-collapsible">


                                                <a href="#" class="heading-text pull-left">Rate <i class="icon-rating3 position-right"></i></a>


                                                <div class="form-group " id="rate_div" >


                                              @if(count($rate) == 0)
                                                    <div class="pull-right" id="add_rate">
                                                        <input type="hidden" name="product_id" value="{{$product->id}}" id="product_id" >
                                                        <input type="hidden" name="user_id" value="{{auth()->user()->id}}" id="user_id">

                                                        <input type="radio" id="5-star-rating" name="rate" value="5" class="rate" >
                                                        <label for="5-star-rating" class="star-rating">
                                                            <i class="fas fa-star d-inline-block"></i>
                                                        </label>


                                                        <!-- star 4 -->
                                                        <input type="radio" id="4-star-rating" name="rate" value="4" class="rate">
                                                        <label for="4-star-rating" class="star-rating star">
                                                            <i class="fas fa-star d-inline-block"></i>
                                                        </label>

                                                        <!-- star 3 -->
                                                        <input type="radio" id="3-star-rating" name="rate" value="3" class="rate">
                                                        <label for="3-star-rating" class="star-rating star">
                                                            <i class="fas fa-star d-inline-block"></i>
                                                        </label>

                                                        <!-- star 2 -->
                                                        <input type="radio" id="2-star-rating" name="rate" value="2" class="rate" >
                                                        <label for="2-star-rating" class="star-rating star">
                                                            <i class="fas fa-star d-inline-block"></i>
                                                        </label>

                                                        <!-- star 1 -->
                                                        <input type="radio" id="1-star-rating" name="rate" value="1" class="rate">
                                                        <label for="1-star-rating" class="star-rating star">
                                                            <i class="fas fa-star d-inline-block"></i>
                                                        </label>
                                                    </div>
                                                    @else

                                                    <div class="pull-right"  >

                                                        <li class="rating" data-toggle="tooltip" data-placment="top" title=" تقييمك للمنتج" style=" margin-top: 10px; list-style: none" id="rating">
                                                            <ul  >
                                                                @foreach($rate as $rat)
                                                                    @for($i=0; $i<$rat->rate ; $i++)
                                                                        <i class="fas fa-star d-inline-block" style="color:yellow;"></i>
                                                                    @endfor
                                                                    @endforeach


                                                            </ul>

                                                        </li>


                                                    </div>

                                               @endif
                                                    <div class="pull-right" id="show_rate"style="display: none" >

                                                        <li class="rating" data-toggle="tooltip" data-placment="top" title=" تقييمك للمنتج" style=" margin-top: 10px; list-style: none" id="rating">
                                                            <ul id="rate_list" >



                                                            </ul>

                                                        </li>


                                                    </div>


                                                </div>

                                            </div>
                                        </div>

                                    </div>




                                </div>
                        @endif
                    </div>
                    <!-- /post grid -->


                    <!-- Pagination -->


                    <!-- /pagination -->


                    <!-- Footer -->
                    <div class="footer text-muted">
                        &copy; 2015. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
                    </div>
                    <!-- /footer -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
@endsection
@section('js')

    <script src="https://use.fontawesome.com/releases/v5.0.2/js/all.js"></script>


    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.rate').on('click',function() {
                var user = $('#user_id').attr('value');
                var product = $('#product_id').attr('value');
                var query = $(this).attr('value');
                console.log(product)

                $.ajax({
                    url:"{{ route('admin.rate') }}",
                    method:"GET",
                    data:{'rate':query,
                        'user_id':user,
                        'product_id':product,


                    },

                    success:function (data) {
                        $('#add_rate').css('display','none');
                        $('#show_rate').css('display','block');
                        $('#rate_list').html(data);
                        console.log(data);

                    }
                })
                // end of ajax call
            });
        })
    </script>




@endsection
