@extends('layouts.app')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok"></span>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <div class="panel panel-default">

        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">Qualification Study Modes</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('qualification_study_modes.qualification_study_mode.create') }}" class="btn btn-success" title="Create New Qualification Study Mode">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($qualificationStudyModes) == 0)
            <div class="panel-body text-center">
                <h4>No Qualification Study Modes Available.</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Qualification</th>
                            <th>Study Mode</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($qualificationStudyModes as $qualificationStudyMode)
                        <tr>
                            <td>{{ optional($qualificationStudyMode->qualification)->qualification_name }}</td>
                            <td>{{ optional($qualificationStudyMode->studyMode)->id }}</td>

                            <td>

                                <form method="POST" action="{!! route('qualification_study_modes.qualification_study_mode.destroy', $qualificationStudyMode->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('qualification_study_modes.qualification_study_mode.show', $qualificationStudyMode->id ) }}" class="btn btn-info" title="Show Qualification Study Mode">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('qualification_study_modes.qualification_study_mode.edit', $qualificationStudyMode->id ) }}" class="btn btn-primary" title="Edit Qualification Study Mode">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Qualification Study Mode" onclick="return confirm(&quot;Click Ok to delete Qualification Study Mode.&quot;)">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                        </button>
                                    </div>

                                </form>
                                
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div class="panel-footer">
            {!! $qualificationStudyModes->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection