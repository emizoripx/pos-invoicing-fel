@if($file->state == 'observed' && !is_null($file->error_report_path))
  @if(auth()->user())
    <a href="{{ route('contingency.download_report', $file->id) }}" class="btn btn-sm bg-info text-white" value="Reporte" /> <i class="fa fa-download fs-6 align-middle"></i> Reporte</a>
  @endif
@endif