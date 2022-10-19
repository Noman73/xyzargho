 <!-- Content Wrapper. Contains page content -->
 @extends('layouts.master')
 @section('link')
 <link rel="stylesheet" href="{{('storage/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{('storage/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  
 @endsection
 @section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">জমা</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">হোম</a></li>
              <li class="breadcrumb-item active">জমা</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card ">
            <div class="card-header bg-dark">
              <div class="row">
                <div class="col-6">
                  <div class="card-title">জমা</div>
                </div>
                <div class="col-6">
                  <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modal" data-whatever="@mdo">নতুন</button>
                </div>
              </div>
            </div>
            <div class="card-body">
              <table class="table text-center table-bordered" id="datatable">
                <thead>
                  <tr>
                    <th>আইডি</th>
                    <th>জমার তারিখ</th>
                    <th>টাকা</th>
                    <th>এ্যাকশন</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
      </div><!-- /.container-fluid -->

      <div id="statement">

      </div>
    </section>
  @endsection

  @section('script')
  <script src="{{('storage/adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{('storage/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{('storage/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{('storage/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
  <script src="{{('storage/adminlte/dist/js/printThis.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.0/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  @include('backend.submission_list.internal-assets.js.script')
  @endsection