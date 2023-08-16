@extends('admin.layouts.app')

@section('title')
    List Products
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('admin-assets/css/dropzone.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin-assets/css/summernote-bs4.min.css')}}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('admin.product.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" enctype="multipart/form-data" name="productForm" id="productForm">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">								
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="title">Title</label>
                                                        <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                                                        <p class="error"></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="title">Slug</label>
                                                        <input type="text" readonly name="slug" id="slug" class="form-control">
                                                        <p class="error"></p>
                                                    </div>
                                                </div>   
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" class="summernote" placeholder="Description"></textarea>
                                        </div>
                                    </div>                                            
                                </div>
                            </div>	                                                                      
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Image</h2>								
                                <div id="imageDZ" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">    
                                        <br>Drop image here or click to upload.<br><br>                                            
                                    </div>
                                </div>
                                <input type="hidden" name="image" id="image">
                            </div>	                                                                      
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Inventory</h2>								
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku" class="mb-3">SKU (Stock Keeping Unit)</label>
                                            <input type="text" name="sku" id="sku" class="form-control" placeholder="sku">	
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="hidden" name="track_qty" value="0">
                                                <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" checked value="1">
                                                <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="number" min="0" name="quantity" id="qty" class="form-control" placeholder="Qty">	
                                            <p class="error"></p>
                                        </div>
                                    </div>   
                                </div>
                            </div>	                                                                      
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">	
                                <h2 class="h4  mb-3">Product category</h2>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="" disabled selected>Select a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="category">Sub category</label>
                                    <select name="sub_category_id" id="sub_category_id" class="form-control">
                                        <option value="">Select a Sub Category</option>
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>								
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input type="text" name="price" id="price" class="form-control" placeholder="Price">	
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="compare_price">Compare at Price</label>
                                            <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price">
                                            <p class="text-muted mt-3">
                                                To show a reduced price, move the product&#39;s original price into Compare at price. Enter a lower value into Price.
                                            </p>	
                                        </div>
                                    </div>                                            
                                </div>
                            </div>	                                                                      
                        </div>
                    </div>
                </div>
                
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{route('admin.product.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('js')
    <script src="{{asset('admin-assets/js/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('admin-assets/js/dropzone.min.js')}}"></script>

    <script>
        $('#productForm').submit(function(even){
            even.preventDefault();
            let formArr = $(this).serializeArray();

            $.ajax({
                url: "{{route('admin.product.create')}}",
                type: 'POST',
                data: formArr,
                dataType: 'json',

                success: function(response){
                    let errors = response['errors'];

                    if(response['status']){
                        window.location.href = "{{route('admin.product.index')}}";
                        
                    }else{
                        $('.error').removeClass('invalid-feedback').html('');
                        $("input[type='text'], select").removeClass('is-invalid');

                        $.each(errors, function(key, value){
                            $(`#${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(value);
                        });
                    };
                },

                error: function(jqXHR, exception){
                    console.log('Something went wrong');
                }
            });
        });


        $('#category').change(function(){
            let category_id = $(this).val();
            
            $.ajax({
                url: '{{route("admin.product.sub-cat")}}',
                type: 'post',
                data: {'category_id' : category_id},
                dataType: 'json',
                success: function(response){

                    if(response['status']){
                        $('#sub_category_id').find('option').not(":first").remove();
                        $.each(response['subCats'], function(key,item){
                            $('#sub_category_id').append(`<option value='${item.id}'>${item.name}</option>`);
                        });
                    }
                }
            });
        });
        

        $('#title').change(function(){
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