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
                            <h4>All Slides</h4>
                         </div>
                         <div class="col-md-6">
                            <a href="{{ route('admin.addhomeslider') }}" class="btn btn-success pull-right">Add New Slide</a>
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
                                    <th>Title</th>
                                    <th>Subtitle</th>
                                    <th>Price</th>
                                    <th>Link</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sliders as $slider)
                                    <tr>
                                        <td>{{ $slider->id }}</td>
                                        <td><img src="{{ asset('assets/images/sliders')}}/{{ $slider->image }}" alt="{{ $slider->title }}" width="120px"/></td>
                                        <td>{{ $slider->title }}</td>
                                        <td>{{ $slider->subtitle }}</td>
                                        <td>{{ $slider->price }}</td>
                                        <td>{{ $slider->link }}</td>
                                        <td>{{ $slider->status == 1 ? 'Active':'Inactive'}}</td>
                                        <td>{{ $slider->created_at }}</td>
                                        <td><a href="{{ route('admin.edithomeslider', ['slide_id' => $slider->id])}}"><i class="fa fa-edit fa-2x"></i></a></td>
                                        <td><a href="#" wire:click.prevent="deleteHomeSlide({{ $slider->id }})"><i class="fa fa-trash-o fa-2x" style="color:red"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>                            
                        </table>
                        {{ $sliders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
