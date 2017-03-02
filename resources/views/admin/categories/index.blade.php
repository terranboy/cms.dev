@extends('admin.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{!! asset('/css/nestable.css') !!}">
    <style>
        .dd-handle{color:#999;}
        .dd-handle:hover { color: #666; background: #fff; }
    </style>
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-list"></i>Categories
        <a class="btn btn-success add_item" href="{{ route('categories.create') }}"><i class="voyager-plus"></i> Add New</a>
    </h1>

@stop

@section('content')

    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">

                    <div class="panel-heading">

                    </div>

                    <div class="panel-body" style="padding:30px;">

                        <div class="dd">
                            <ol class="dd-list">
                                @foreach(\App\Category::whereNull('parent_id')->orderBy('order', 'asc')->get() as $root_cate)
                                    <li class="dd-item" id="c-{{$root_cate->id}}">
                                        <div class="pull-right item_actions">
                                            <div class="btn-sm btn-danger pull-right delete" data-id="{{$root_cate->id}}">
                                                <i class="voyager-trash"></i> Delete
                                            </div>
                                            <a class="btn-sm btn-primary pull-right edit" href="{{ route('categories.edit', $root_cate->id) }}">
                                                <i class="voyager-edit"></i> Edit
                                            </a>
                                        </div>
                                        <div class="dd-handle">{{ $root_cate->{'name:cn'} }} ({{ $root_cate->{'name:en'} }}) <small class="url">/{{ $root_cate->slug }}</small></div>
                                        @if($root_cate->child)
                                            <ol class="dd-list">
                                                @foreach($root_cate->child as $child_one)
                                                    <li class="dd-item" id="c-{{$child_one->id}}">
                                                        <div class="pull-right item_actions">
                                                            <div class="btn-sm btn-danger pull-right delete" data-id="{{$child_one->id}}">
                                                                <i class="voyager-trash"></i> Delete
                                                            </div>
                                                            <a class="btn-sm btn-primary pull-right edit" href="{{ route('categories.edit', $child_one->id) }}">
                                                                <i class="voyager-edit"></i> Edit
                                                            </a>
                                                        </div>
                                                        <div class="dd-handle">{{ $child_one->{'name:cn'} }} ({{ $child_one->{'name:en'} }}) <small class="url">/{{ $child_one->slug }}</small></div>
                                                    </li>
                                                @endforeach
                                            </ol>
                                        @endif

                                    </li>
                                @endforeach

                            </ol>
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
                    <h4 class="modal-title"><i class="voyager-trash"></i> Are you sure you want to delete this category?</h4>
                </div>
                <div class="modal-footer">
                    <button id="delete-confirm" type="submit" class="btn btn-danger pull-right delete-confirm"
                            data-token="{{ csrf_token() }}">Yes, Delete This Category</button>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <input type="hidden" id="mdata" value="">
@stop

@section('javascript')
    <script>
        $(document).ready(function () {

            $('#delete_modal').on('hidden.bs.modal', function () {
                $(this).find("input,textarea,select").val('').end();
                $('#mdata').val('').end();
            });

            $('.item_actions').on('click', '.delete', function (e) {
                id = $(e.currentTarget).data('id');
                //$('#delete-confirm').attr('data-id',id);
                $('#mdata').val(id);
                $('#delete_modal').modal('show');
                //console.log($('#mdata').val());
            });

            $('#delete_modal').on('click', '#delete-confirm', function(e) {

                var token = $(e.currentTarget).data('token');
                var id = $('#mdata').val();
                //console.log(id);
                $.ajax({
                    url:'/admin/categories/'+id,
                    type: 'post',
                    data: {_method: 'delete', _token :token},
                    success:function() {
                        $('.dd').find("#c-" + id).remove();
                        toastr.success('Successfully deleted category');
                    },
                    error:function(xhr, status, error) {
                        toastr.error(xhr.responseText);
                    }
                });

                $('#delete_modal').modal('hide');

            });


        });
    </script>
@stop
