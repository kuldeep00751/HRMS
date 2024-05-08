<x-base-layout>
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">

            <div class="card-header">

                <div class="pull-left">
                    <h4 class="mt-5 mb-5">{{ !empty($markType->mark_type) ? $markType->mark_type : 'Mark Type' }}</h4>
                </div>
            </div>
            <form method="POST" action="{{ route('mark_types.mark_type.update', $markType->id) }}" id="edit_mark_type_form" name="edit_mark_type_form" accept-charset="UTF-8" class="form-horizontal">
                <div class="card-body">

                    @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif


                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="PUT">
                    @include ('pages.settings.mark_types.form', [
                    'markType' => $markType,
                    ])



                </div>
                <div class="card-footer">
                    <div class="form-group">
                        <input class="btn btn-success" type="submit" value="Update">
                        <a href="{{ route('mark_types.mark_type.index') }}" title="Show All Mark Types">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-base-layout>