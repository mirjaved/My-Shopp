<div>
    <style>
        nav svg{
            height: 20px;
        }
        nav .hidden {
            display: block !important;
        }
    </style>
    <div class="container" style="padding: 30px 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>All Products</h4>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('admin.addproducts') }}" class="btn btn-success pull-right">Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                        @endif
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Image</th>
                                    <th>Name</th>                                    
                                    <th>Price</th>
                                    <th>Sale Price</th>
                                    <th>Stock</th>
                                    <th>Quantity</th>                         
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td><img src="{{ asset('assets/images/products/') }}/{{$product->image}}" alt="{{ $product->name }}" width="60px"></td>
                                        <td>{{ $product->name }}</td>  
                                        <td>{{ $product->regular_price }}</td>                                      
                                        <td>{{ $product->sale_price }}</td>
                                        <td>{{ $product->stock_status }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td><a href="{{ route('admin.editproduct', ['product_slug' => $product->slug])}}"><i class="fa fa-edit fa-2x"></i></a></td>
                                        <td><a href="#" onclick="confirm('Are you sure you want to delete this product?') || event.stopImmediatePropagation()" wire:click.prevent="deleteProduct({{ $product->id }})"><i class="fa fa-trash-o fa-2x" style="color:red"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
