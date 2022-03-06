<div class="box-body">
   <div class="row my-3">
       <div class="col-lg-2"></div>
        <div class="col-lg-10 col-lg-offset-1">
            <div class="alert alert-warning">
                Note : You need to have 0777 permission to all folders of the project.
            </div>
        </div>
    </div>
    <!-- Module Name -->
   <div class="row my-3">
        {{ Form::label('name', trans('api-generator::labels.apis.form.name'), ['class' => 'col-lg-2 control-label text-right required']) }}

        <div class="col-lg-10">
            {{ Form::text('name', null, ['class' => 'form-control box-size', 'placeholder' => 'e.g., user', 'required' => 'required']) }}
            <span class="name_name" role="alert"></span>
        </div><!--col-lg-10-->
    </div>

    <div class="row my-3">
        {{ Form::label('operations', 'AUTH', ['class' => 'col-lg-2 control-label text-right','data-value'=>'false']) }}
        <div class="col-lg-4">
            <label class="control control--checkbox">
                <!-- For Create Operation of CRUD -->
                {{ Form::checkbox('auth', '1', false) }} &nbsp;Authendtication
                <div class="control__indicator"></div>
            </label>
        </div>
        {{ Form::label('folder', 'Add Folder', ['class' => 'col-lg-2 control-label text-right']) }}
        <div class="col-lg-4">
            {{ Form::text('folder', null, ['class' => 'form-control box-size', 'placeholder' => 'e.g., User']) }}

        </div>
     </div>

    <!-- Directory -->
   <div class="row my-3">
        {{ Form::label('api_path', trans('api-generator::labels.apis.form.api_path'), ['class' => 'col-lg-2 control-label text-right required']) }}

        <div class="col-lg-10">
            {{ Form::text('api_path', null, ['class' => 'form-control box-size', 'placeholder' => 'e.g., Api/V1/', 'required' => true]) }}
        </div><!--col-lg-10-->
    </div>
    <!-- End Directory -->

    <!-- Model Name -->
   <div class="row my-3">
        {{ Form::label('model_class', trans('api-generator::labels.apis.form.model_class'), ['class' => 'col-lg-2 control-label text-right required']) }}

        <div class="col-lg-10">
            {{ Form::text('model_class', null, ['class' => 'form-control box-size only-text', 'placeholder' => 'e.g., App\Models\User', 'required' => true]) }}
            <div class="model-messages"></div>
        </div>
    </div>
    <!-- End Model Name -->
    <div class="row my-3">
        <label class="col-lg-2 control-label text-right">Crud Api Generated</label>
        <div class="col-lg-10">
            <textarea name="url" class="form-control box-size crud_api" contenteditable="true" rows=8 readonly="">
            </textarea>
        </div>
    </div>

    <!-- To Show the generated File -->
    <div class="box-body">
        <!--All Files -->
       <div class="row my-3">
            <label class="col-lg-2 control-label text-right">Files To Be Generated</label>
            <div class="col-lg-10">
                <textarea name="controller_path" class="form-control box-size files" contenteditable="true" rows=8 readonly="">
                </textarea>
            </div>
        </div>
        <!-- All Files -->
    </div>
    <!-- End The File Generated Textbox -->

    <!-- Override CheckBox -->
   <div class="row my-3">
        <div class="col-lg-2"></div>
        <div class="col-lg-10">
            <p><strong>Note : </strong> The Files would be overwritten, if already exists. Please look at files (and their respective paths) carefully before creating.</p>
        </div><!--form control-->
    </div>
    <!-- end Override Checkbox -->
</div>
@section("bottom-scripts")
    {!! Html::script('backend/js/pluralize.js') !!}
<script>
 $( document ).ready(function() {
    sessionStorage.removeItem("apiauth");
    //  event on name tag
     $("#name").on('input',function(){
       let prefix = '/api/v1';
       let apiname = $(this).val();
        if(apiname.match(" ")){
            apiname = apiname.replace(' ','');
            $(this).val(apiname);
        }
        apiname = apiname.toLowerCase();
        var auth = sessionStorage.getItem("apiauth");
        if(auth != 'auth'){
            $("#api_path").val(prefix+"/"+apiname);
        }
        else{
            $("#api_path").val(prefix+'/auth/'+apiname);
        }
        crudApi();
     });
    // event on auth
     $("input[name='auth']").click(function(){
       let prefix = '/api/v1';
       let apiname = $("#name").val();
       apiname = apiname.replace(' ','');
       apiname = apiname.toLowerCase();
        var auth = sessionStorage.getItem("apiauth");
        if(auth == 'auth'){
            sessionStorage.removeItem("apiauth");
            $("#api_path").val(prefix+"/"+apiname);
        }
        else{
            sessionStorage.setItem("apiauth",'auth');
            $("#api_path").val(prefix+'/auth/'+apiname);
        }
        crudApi();
     });

    //  start add folder
    $("#folder").on('input',function(){
            crudApi();
    });
    //  end add folder
     function crudApi(){
       var filetext = $(".files").val("");
       var folderName = $("#folder").val();
       var auth = sessionStorage.getItem("apiauth");
       let apiname = $("#name").val();
       apiname = apiname.replace(' ','');
       apiname = apiname.charAt(0).toUpperCase() + apiname.slice(1).toLowerCase();
       folderName = folderName.replace(' ','');
       folderName = folderName.charAt(0).toUpperCase() + folderName.slice(1).toLowerCase();
       if(folderName != '')
            var controllerfile = 'App\\Http\\Controllers\\Api\\V1\\'+folderName+'\\'+apiname+'Controller.php';
       else
       var controllerfile = 'App\\Http\\Controllers\\Api\\V1\\'+apiname+'Controller.php';

       $(".files").val(controllerfile);
       crud_api();
     }

     function crud_api(){
        var api_path = $("#api_path").val();
        var data = api_path+" (GET)\n"+api_path+"/{id} (GET)\n"+api_path+" (POST)\n"+api_path+"/{id} (PUT)\n"+api_path+"/{id} (DELETE)\n";
        $(".crud_api").val(data);
     }
 });
        //For only characters
        // $( document ).on('keyup', ".only-text", function(e) {
        //     var val = $(this).val();
        //     if (val.match(/[^a-zA-Z]/g)) {
        //        $(this).val(val.replace(/[^a-zA-Z]/g, ''));
        //     }
        // });
$("#name").on('change',function(){
    var name = $('#name').val();
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type : 'POST',
            url : "{{route('admin.apis.check.route')}}",
            cache : true,
            data : {
            name : name
            },
            beforeSend : function(){
                $("#apisubmit").attr('disabled','disabled');
                $(".name_name").html('please wait...');
            },
            success : function(res){
                $(".name_name").html('<strong class="text-success">'+res.message+'</strong>');

                $("#apisubmit").removeAttr('disabled');
            },
            error : function(xhr){
                $("#apisubmit").attr('disabled','disabled');
                $(".name_name").html('<strong class="text-danger">'+xhr.responseJSON.message+'</strong>');
            }
        });


});

</script>
@endsection
