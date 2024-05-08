<x-base-layout>
    <div class="col-md-6 mx-auto">
        <div class="card">

            <div class="card-header">

                <div class="pull-left">
                    <h4 class="mt-5 mb-5">{{ !empty($space->name) ? $space->name : 'Space' }}</h4>
                </div>
               
            </div>
            <form method="POST" action="{{ route('spaces.space.update', $space->id) }}" id="edit_space_form" name="edit_space_form" accept-charset="UTF-8" class="form-horizontal">

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
                    @include ('pages.settings.spaces.form', [
                    'space' => $space,
                    ])


                </div>
                <div class="card-footer">

                    <div class="form-group">
                        <input class="btn btn-success" type="submit" value="Update">
                        <a href="{{ route('spaces.space.index') }}">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-base-layout>