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