@extends('layouts.dashboard-layout')

@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Questions</h3>
              @if(Auth::guard('admin')->user()->admin_type == config('examapp.user_role.admin'))
              <a href="{{ route('admin.question.create')}}"><button class="btn btn-primary float-right">Create New Question</button></a>
              @endif
            </div>
            
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Question</th>
                  <th>Score</th>
                  @if(Auth::guard('admin')->user()->admin_type == config('examapp.user_role.admin'))
                  <th>Edit</th>
                  <th>Delete</th>
                  @endif
                </tr>
                </thead>
                <tbody>
                @if(count($questions) != 0)
                    @foreach($questions as $question)
                        <tr>
                            <td>{{ $question->question}}</td>
                            <td>{{ $question->score }}</td>
                            @if(Auth::guard('admin')->user()->admin_type == config('examapp.user_role.admin'))
                            <td><a href="{{ route('admin.question.edit', $question->_id)}}" title="Edit" >Edit</a></td>
                            <td><a href="javascript:;" class="js_delete_question" data-id={{$question->_id}}>Delete</a></td>
                            @endif
                        </tr>
                        @endforeach
                    @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
@push('script')
<script type="text/javascript" src="{{asset('assets/js/admin/question/index.js')}}"></script>
<script>
  var QUESTION_DELETE_URL = '{{ route('admin.question.delete')}}'
  var QUESTION_LIST_URL = '{{ route('admin.question.index') }}'
    $(document).ready( function () {
      deleteQuestion.init();
        $('#table_id').DataTable();
    } );
</script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
@endpush