@extends('layouts.master')

@section('content')

        <div class="card border-0 border-start border-bottom border-5 radius-15 border-secondary">
            <div class="card-header ">
                <h4 class="mt-3 mb-3">Create Report</h4>
            </div>
            <form method="post" action="{{route('report.store')}}" enctype="multipart/form-data">
                @csrf
            <div class="card-body">
                <label for="formFileSm" class="form-label">Title</label>
                <input type="text" name="title" required class="form-control mb-3">

                <div class="mt-4">
                    <label class="form-label">Category</label>
                    <select class="single-select" name="cat" id="Category">
                        <option value="">Select Category</option>
                        <div class="fieldCat"></div>
                        <option value="addCat">Add Category</option>

                    </select>
                </div>

                <div class="mt-4">
                    <label class="form-label">Action</label>
                    <select class="single-select" name="action_id" >
                        <option value="">Select Action</option>
                        <div class="fieldCat"></div>
                        <option value="1">Create</option>
                        <option value="2">Update</option>
                        <option value="3">Delete</option>

                    </select>
                </div>
{{--                <div class="mt-4 select2-sm">--}}
{{--                    <label class="form-label">Sub Category</label>--}}
{{--                    <select class="single-select" name="sub" id="SubCategory">--}}
{{--                    </select>--}}
{{--                </div>--}}

                <label for="formFileSm" class="form-label mt-3">Link</label>
                <input type="url" name="link" required class="form-control mb-3">

                

                <div class="mb-3">
                    <label for="formFileSm" class="form-label">Date</label><br>
                    <input class="form-control form-control-sm" name="created" type="date">
                    <small class="text-danger">Isi Jika Upload Report Bukan Hari ini</small>
                </div>


            </div>

            <div class="card-footer pt-3 pb-3">
                <div class="d-grid">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="bx bx-upload"></i> &nbsp; Upload</button>
                </div>
            </div>
        </form>
        </div>

@endsection

@push('head')
    <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/select2/css/select2-bootstrap4.css')}}" rel="stylesheet" />
@endpush

@push('js')
    <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            loadCategory()
        })

        function loadCategory() {
            $.get(window.location.pathname, function (data) {
                data.map(function (v) {
                    $('#Category').append('<option value="' + v.id + '">' + v.name + '</option>');
                });
            });
        }
    </script>
    <script>

        $('#Category').on('change', function(){
            var category = this.value;
            if( category == 'addCat'){
                document.getElementById('prn').value=''
                $('#modalCategory').modal('show');
                $('#titleAddCat').html('Add Category')
            } else {
                $.get("{{url('sub_cat')}}/"+category, function (data) {
                    $('#SubCategory').html('');
                    $('#SubCategory').append('<option value="">Select Sub Category</option>\n' +
                        '                        <option value="addSubCat">Add Sub Category</option>');
                    data.map(function (v) {
                        $('#SubCategory').append('<option value="' + v.id + '">' + v.name + '</option>');
                    });
                });
                document.getElementById('prn').value = category;
            }

        });

        $('#SubCategory').on('change', function(){
            var sub_category = this.value;
            if(sub_category == 'addSubCat'){
                $('#modalCategory').modal('show');
                $('#titleAddCat').html('Add Sub Category')
            }
        })




        $('#formAddSubCat').on('submit', function (event) {
            event.preventDefault();
            $.ajax({
                data: $('#formAddSubCat').serialize(),
                url: "{{route('addCategory')}}",
                method: "post",
                success: function (data) {
                    console.log(data)
                    $('#modalCategory').modal('hide');
                    if (data.parent == null){
                        $('#Category').append(' <option selected value="'+data.id+'">'+data.name+'</option>')
                    } else {
                        $('#SubCategory').append(' <option selected value="'+data.id+'">'+data.name+'</option>')
                    }
                    // $('#formAddSubCat')[0].reset();
                    //
                    // if(data[0].type == 'parent'){
                    //     $('#parent_id').append('<option value="' + data[1].id + '">' + data[1].cat_name + '</option>');
                    // } else {
                    //     $('#category').append('<option value="' + data[1].id + '">' + data[1].cat_name + '</option>');
                    // }

                }
            });
        });
    </script>
    <script>
        $('.single-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
        $('.multiple-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
    </script>


@endpush


<div class="modal" id="modalCategory" tabindex="-1" aria-modal="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-dark">
                <h5 class="modal-title text-dark" id="titleAddCat">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{route('addCategory')}}" id="formAddSubCat">
                @csrf
            <div class="modal-body text-dark">
                <input type="text" class="form-control" placeholder="Name" name="name" required id="name">
                <input type="hidden" class="form-control" name="parent" value="" id="prn">
            </div>
            <div class="modal-footer border-dark">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-dark">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
