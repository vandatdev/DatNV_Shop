@extends('admin.layouts.app')

@section('title')
    Edit Sub Category
@endsection

@section('content')
    
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Sub Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('admin.subCat.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="subCatForm" name="subCatForm">
                <div class="card">
                    <div class="card-body">								
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name">Category</label>
                                    <input type="text" readonly name="category" id="category" class="form-control" value="{{$subCategory->catName}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{$subCategory->name}}">	
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug" value="{{$subCategory->slug}}">	
                                    <p></p>
                                </div>
                            </div>	
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{($subCategory->status == 1) ? 'selected' : ''}} value="1">Active</option>
                                        <option {{($subCategory->status == 0) ? 'selected' : ''}} value="0">Block</option>
                                    </select>
                                </div>
                            </div>							
                        </div>
                    </div>							
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{route('admin.subCat.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('js')
    <script>
        $('#subCatForm').submit(function(even){
            even.preventDefault();
            let element = $('#subCatForm');
            $("button[type='submit']").prop('disable', true);

            $.ajax({
                url: "{{route('admin.subCat.update', $subCategory->id)}}",
                type: 'PUT',
                data: element.serializeArray(),
                dataType: 'json',

                success: function(response){
                    let errors = response['errors'];

                    if(response['status']){

                        window.location.href = "{{route('admin.subCat.index')}}";
                    }
                    else{
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

    </script>
@endsection