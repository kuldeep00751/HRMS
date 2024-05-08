<x-base-layout>
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="pull-left">
                    <a href="/payment_descriptions" class="btn btn-sm btn-secondary btn-active-light-primary"><i class="fa-solid fa-chevron-left"></i> Payment Descriptions</a>
                </div>
                <div class="pull-right">
                    <h4 class="mt-5 mb-5">Create New Payment Description</h4>
                </div>

            </div>
            <form method="POST" action="{{ route('payment_descriptions.payment_description.store') }}" accept-charset="UTF-8" class="form fv-plugins-bootstrap5 fv-plugins-framework">
                <div class="card-body">

                    @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    @endif

                    {{ csrf_field() }}
                    @include ('pages.settings.payment_descriptions.form', [
                    'paymentDescription' => null,
                    ])


                </div>
                <div class="card-footer">
                    <div class="form-group">
                        <input class="btn btn-success" type="submit" value="Save">
                        <a href="{{ route('payment_descriptions.payment_description.index') }}" >
                            Cancel
                        </a>
                    </div>
                </div>
            </form>

        </div>
    </div>
</x-base-layout>