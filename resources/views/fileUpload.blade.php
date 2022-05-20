<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PDF Manager</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
            .bi-upload
            {
                cursor: pointer;
            }

            .bd-callout {
            padding: 1.25rem;
            margin-top: 1.25rem;
            margin-bottom: 1.25rem;
            border: 1px solid #eee;
            border-left-width: 0.40rem;
            border-radius: .25rem;
            margin-left: 10px;
            }

            .bd-callout h4 {
            margin-top: 0;
            margin-bottom: .25rem
            }

            .bd-callout p:last-child {
            margin-bottom: 0
            }

            .bd-callout code {
            border-radius: .25rem
            }

            .bd-callout+.bd-callout {
            margin-top: -.25rem
            }

            .bd-callout-primary{
            border-left-color: #007bff
            }

            .bd-callout-primaryh4 {
            color: #007bff
            }


            .bd-callout-default{
                border: 0px;
            border-left-width: 0.40rem;
            }

            .bd-callout-defaulth4 {
            color: #6c757d
            }
            .list-group-item
            {
                cursor: pointer;
            }
        </style>


        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

        <!-- Styles -->

        <script type="text/javascript">
            $(document).ready(function(){
            $("#file").change(function () {
                var fileExtension = ['pdf'];
                    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                        alert("Only formats are allowed : "+fileExtension.join(', '));
                    }
                    else
                    {
                        $( "#file-upload" ).submit();
                    }
                    
            });


            $(".list-group-item-action").click(function (e) {
                let file_id = $(this).attr('data-href');
                $(".list-group-item-action").removeClass("bd-callout-primary shadow p-3 mb-5 bg-white rounded");
                $(".list-group-item-action").addClass("bd-callout-default shadow-none p-3 mb-5 bg-light rounded");
                $(".file_preview_div").addClass("hide");
                $(".file_preview_div").removeClass("show active");  
                $(this).removeClass("bd-callout-default shadow-none p-3 mb-5 bg-light rounded");
                $(this).addClass("bd-callout-primary shadow p-3 mb-5 bg-white rounded");
                $(file_id).removeClass('hide');
                $(file_id).addClass('show active');


            });
        });
        </script>

    </head>
    <body class="antialiased">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <strong>{{ $message }}</strong>
            </div>
          @endif


        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
          <div class="col-3 bg-light">
            <div class="d-flex border-bottom" style="margin-left: 10px;">
                    <div class="p-2 flex-grow-1 font-weight-bold">FILES</div>
                <form action="{{ route('file.store') }}" method="POST" id="file-upload" enctype="multipart/form-data">
                @csrf
                      <div class="p-2" for="file">
                                    Upload&nbsp;&nbsp;&nbsp;
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload upload_file_button" viewBox="0 0 16 16" id="upload_file_button" onclick="$('#file').trigger('click'); return false;">
                                  <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                  <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                                </svg>

                                <input type="file" id="file" style="display: none" name="file" accept="application/pdf" multiple="" data-original-title="upload files">
                      </div>
                  </form>
            </div>


            <div class="list-group">
                @foreach($filedata as $key => $files)
                <div class="bd-callout list-group-item list-group-item-action <?= $key == 0 ? 'bd-callout-primary shadow p-3 mb-5 bg-white rounded': 'bd-callout-default shadow-none p-3 mb-5 bg-light rounded' ?>" id="v-pills-home-<?=$key+1;?>-tab" role="tab" aria-controls="v-pills-home-<?=$key+1;?>" aria-selected="true" data-toggle="pill" data-href="#v-pills-home-<?=$key+1;?>">
                      <h4 class="font-weight-bold">Document #{{$key+1}}</h4>
                      {{$files->name}}
                </div>
                @endforeach
            </div>
          </div>
          <div class="col-9">
            <div class="tab-content" id="v-pills-tabContent">
                @foreach($filedata as $key => $files)
                <div class="tab-pane fade file_preview_div <?= $key == 0 ? 'show active': 'hide' ?>" id="v-pills-home-<?=$key+1;?>" role="tabpanel" aria-labelledby="v-pills-home-<?=$key+1;?>-tab">

                    <div class="d-flex p-2 p-3 mb-2 bg-primary text-white font-weight-bold">Document #{{$key+1}}</div>


                    <?php if (trim($files->name) != "") 
                         { 
                            $file_path = "uploads/" . $files->name;
                            
                            if(file_exists($file_path)) 
                            {?>
                    <iframe class="doc" src="{{URL('uploads/')}}/{{$files->name}}" style="width: 100%;height: 800px;"></iframe>
                            <?php } else { ?>
                            File not found
                            <?php }  } else { ?>
                            File not found
                            <?php } ?>

                </div>
                @endforeach
            </div>
          </div>
        </div>
    </body>
</html>
