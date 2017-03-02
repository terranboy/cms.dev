@extends('admin.master')

@section('page_title','All '.$post_type->display_name_plural)

@section('page_header')
    <h1 class="page-title">
        <i class="{{$post_type->icon}}"></i> {{$post_type->display_name_plural}}
        <a href="{{ route($post_type->slug.'.create') }}" class="btn btn-success">
            <i class="voyager-plus"></i> Add New
        </a>
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <table id="dataTable" class="table table-hover">
                            <thead>
                            <tr>
                                @if($post_type->name == 'products')
                                    <th>Product image</th>
                                @endif
                                <th style="width:300px;">Title</th>
                                <th>Slug</th>
                                @if($post_type->name !== 'pages')
                                    <th>Category</th>
                                @endif
                                <th>Status</th>
                                <th style="width:150px;">Created_at</th>
                                <th class="actions" style="width:200px;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr id="p-{{$post->id}}">
                                    @if($post_type->name == 'products')
                                        <td>
                                            @if($post->image)
                                                <ul class="img-thumb">
                                                    @foreach(explode(',', $post->image) as $img)
                                                        <li><img width="30" height="30" src="/product-images/{{ $img }}_100x100.jpg" /></li>
                                                    @endforeach

                                                </ul>
                                            @endif
                                        </td>
                                    @endif
                                    <td>
                                        {{ $post->title }}
                                    </td>
                                    <td>
                                        {{ $post->slug }}
                                    </td>
                                    @if($post_type->name !== 'pages')
                                        <td>
                                            @if($post->category_id)
                                                {{ \App\Category::whereId($post->category_id)->first()->name }}
                                            @endif
                                        </td>
                                    @endif
                                    <td>
                                        {{ $post->status }}
                                    </td>
                                    <td>
                                        {{ $post->created_at }}
                                    </td>
                                    <td class="no-sort no-click">
                                        <div class="btn-sm btn-danger pull-right delete" data-id="{{ $post->id }}">
                                            <i class="voyager-trash"></i> Delete
                                        </div>
                                        <a href="{{ route($post_type->slug.'.edit', $post->id) }}" class="btn-sm btn-primary pull-right edit">
                                            <i class="voyager-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="pull-left">

                        <div class="pull-right">
                           
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-trash"></i> Are you sure you want to delete this profuct?</h4>
                    </div>
                    <div class="modal-footer">
                        <button id="delete-confirm" type="submit" class="btn btn-danger pull-right delete-confirm"
                                data-token="{{ csrf_token() }}">Yes, Delete This Product</button>
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <input type="hidden" id="mdata" value="">
@stop

@section('javascript')
    {{-- DataTables --}}
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({ "order": [] });
        });

        $('#delete_modal').on('hidden.bs.modal', function () {
            $(this).find("input,textarea,select").val('').end();
            $('#mdata').val('').end();
        });

        $('td').on('click', '.delete', function(e) {
            id = $(e.currentTarget).data('id');
            //$('#delete-confirm').attr('data-id',id);
            $('#mdata').val(id);
            $('#delete_modal').modal('show');
        });

        $('#delete_modal').on('click', '#delete-confirm', function(e) {

            var token = $(e.currentTarget).data('token');
            var id = $('#mdata').val();
            //console.log(id);
            $.ajax({
                url:'/admin/{{$post_type->slug}}/'+id,
                type: 'post',
                data: {_method: 'delete', _token :token},
                success:function() {
                    $("#p-" + id).remove();
                    toastr.success('Successfully deleted product');
                },
                error:function(xhr, status, error) {
                    toastr.error(xhr.responseText);
                }
            });

            $('#delete_modal').modal('hide');

        });
    </script>
@stop
