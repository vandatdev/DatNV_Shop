@extends('admin.layouts.app')

@section('title')
    Edit Category
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('admin-assets/css/dropzone.min.css')}}">
@endsection

@section('content')
    
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('admin.category.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="categoryForm" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-body">	
                        <p id="success" class="text-center alert"></p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{$category->name}}">	
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="{{$category->slug}}" readonly>	
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input id="image" type="hidden" name="image" value="">
                                    <label for="image">Image</label>
                                    <div id="imageDZ" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            Click or Drop files here to upload
                                        </div>
                                    </div>
                                </div>
                                @empty(!$category->image)
                                    <img width="200px" src="{{asset('uploads/categories/'.$category->image)}}" alt="">
                                @endempty
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{ ($category->status == 1) ? 'selected' : '' }} value="1">Active</option>
                                        <option {{ ($category->status == 0) ? 'selected' : '' }} value="0">Block</option>
                                    </select>
                                </div>
                            </div>									
                        </div>
                    </div>							
                </div>
                <div class="pb-5 pt-3">
                    <button id="submit-all" type="submit" class="btn btn-primary">Edit</button>
                    <a href="{{route('admin.category.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
            
        </div>
    </section>
@endsection

@section('js')
    <script src="{{asset('admin-assets/js/dropzone.min.js')}}"></script>
    <script>

        $('#categoryForm').submit(function(even){
            even.preventDefault();
            let element = $(this);

            $.ajax({
                url: "{{route('admin.category.update', $category->slug)}}",
                type: 'PUT',
                data: element.serializeArray(),
                dataType: 'json',

                success: function(response){
                    let errors = response['errors'];

                    if(response['status']){
                        window.location.href = "{{route('admin.category.index')}}";
                        
                        // $('#success').addClass('alert-success')
                        //     .html(response['message']);

                        // $('#name').removeClass('is-invalid')
                        //     .siblings('p')
                        //     .removeClass('invalid-feedback').html('');

                        // $('#slug').removeClass('is-invalid')
                        //     .siblings('p')
                        //     .removeClass('invalid-feedback').html('');

                        // $("input[type=text]").val("");

                        
                    }else{
                        if(errors['name']){
                            $('#name').addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback').html(errors['name']);
                        }else{
                            $('#name').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html('');
                        };

                        if(errors['slug']){
                            $('#slug').addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback').html(errors['slug']);
                        }else{
                            $('#slug').removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html('');
                        }
                    };
                },

                error: function(jqXHR, exception){
                    console.log('Something went wrong');
                }
            });
        });

        $('#name').change(function(){
            let element = $(this);
            
            $.ajax({
                url: "{{route('admin.category.slug')}}",
                type: 'GET',
                data: {
                    title: element.val()
                },
                success: function(response){
                    if(response['status'] == true){
                        $('#slug').val(response['slug']);
                    }
                }
            });
        });

        Dropzone.autoDiscover = false;

        const dropzone = $('#imageDZ').dropzone({

            init: function(){
                this.on('addedfile', function(file){
                    if(this.files.length > 1){
                        this.removeFile(this.files[0]);
                    }
                });
            },

            url: "{{route('admin.category.upload-image')}}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/*",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(file, response){
                $('#image').val(response.image)
            },
            error: function(){
                console.log($('meta[name="csrf-token"]').attr('content'));
            }
        });

    </script>
@endsection