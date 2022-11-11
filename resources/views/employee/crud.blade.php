@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title">{{ @$actionHeading }}</h4>
                        </div>
                        <div class="card-body">
                            <form class="form-label-left input_mask text-form" action="javascript:;" id=""
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <hr class="mt-1 mb-2">
                                            <input type="text" class="form-control" name="name"
                                                value="{{ @$model->name }}" placeholder="Name" id="name">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <hr class="mt-1 mb-2">
                                            <input type="text" class="form-control" name="email"
                                                value="{{ @$model->email }}" placeholder="Email" id="email">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Initial Holiday Count <span class="text-danger">*</span></label>
                                            <hr class="mt-1 mb-2">
                                            <input type="text" class="form-control" type="number"
                                                name="init_holiday_count" value="{{ @$model->init_holiday_count }}"
                                                placeholder="Initial Holiday Count " id="init_holiday_count">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Manager</label>
                                            <hr class="mt-1 mb-2">
                                            <select name="manager_id" id="manager_id" class="form-control">
                                                <option value="">Please select</option>
                                                @if (!empty($managers))
                                                    @foreach ($managers as $manager)
                                                        <option
                                                            {{ @$model->manager_id == $manager->id ? 'selected="selected"' : '' }}
                                                            value="{{ $manager->id }}">{{ $manager->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> <span class="text-danger"></span></label>
                                            <hr class="mt-1 mb-2">
                                            <input type="hidden" name="action_id" value="{{ @$model->id }}">
                                            @if ($formMode == 'edit')
                                                <button class="text-form-submit btn btn-success pull-right float-right"
                                                    data-url="{{ $updateUrl }}">Update</button>
                                            @elseif($formMode == 'create')
                                                <button class="text-form-submit btn btn-success pull-right float-right"
                                                    data-url="{{ $saveUrl }}">Save</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr>
                        </div>
                    </div>
                </div><!-- end col-->
            </div>
        </div>
    </div>
@endsection
@section('page_js')
    <script>
        $(document).ready(function() {
            $('.text-form .text-form-submit').on('click', function(e) {
                e.preventDefault();
                var elem = $(this);
                var url = elem.data('url');
                var postData = elem.closest('form').serializeArray();
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: url,
                    data: $.param(postData),
                    success: function(response) {
                        notification_handler(response.notify)
                    }
                });
            });
        });
    </script>
@endsection
