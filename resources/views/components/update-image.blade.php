<div class="input_bx">
    <!-- start input box -->
    <label class="">{{$title}}</label>
    <input tabindex="25" type="file" name="pimage" id="pimage"
           class="inputs_up form-control" accept=".png,.jpg,.jpeg"
           style="width: 100px !important; background-color: #eee; border:none; box-shadow: none !important; display: none;">
    <span id="pimage_error_msg" style="font-size: 18px;" class="validate_sign text-danger">
                                    </span>

    <div class="db">

        <div class="db">
            <label id="image1"
                   style="display: none; cursor:pointer; color:blue; text-decoration:underline;">
                <i style=" color:#04C1F3" class="fa fa-window-close"></i>
            </label>
        </div>
        <div>
            <img id="imagePreview1"
                 style="border-radius:50%; position:relative; cursor:pointer;  width: 100px; height: 100px;"
                 src="{{ isset($image) && !empty($image) ? $image : asset('public/src/upload_btn.jpg') }}" />
        </div>
    </div>
</div><!-- end input box -->

    <script>
        jQuery("#imagePreview1").click(function () {
            jQuery("#pimage").click();
        });
        var image1RemoveBtn = document.querySelector("#image1");
        var imagePreview1 = document.querySelector("#imagePreview1");

        $(document).ready(function () {
            $('#pimage').change(function () {
                var file = this.files[0],
                    val = $(this).val().trim().toLowerCase();
                if (!file || $(this).val() === "") {
                    return;
                }

                var fileSize = file.size / 130 / 130,
                    regex = new RegExp("(.*?)\.(jpeg|png|jpg)$"),
                    errors = 0;

                if (fileSize > 2) {
                    errors = 1;

                    document.getElementById("pimage_error_msg").innerHTML =
                        "Only png.jpg,jpeg files & max size:180 kb";
                    document.getElementById("pimage_error_msg").innerHTML =
                        "Only png.jpg,jpeg files & max size:180 kb";
                }
                if (!(regex.test(val))) {
                    errors = 1;

                    document.getElementById("pimage_error_msg").innerHTML =
                        "Only png.jpg,jpegs files & max size:180 kb";
                }

                var fileInput = document.getElementById('pimage');
                var reader = new FileReader();

                if (errors == 1) {
                    $(this).val('');

                    image1RemoveBtn.style.display = "none";
                    document.getElementById("imagePreview1").src = 'public/src/upload_btn.jpg';

                } else {

                    image1RemoveBtn.style.display = "block";
                    imagePreview1.style.display = "block";

                    reader.onload = function (e) {
                        document.getElementById("imagePreview1").src = e.target.result;
                    };
                    reader.readAsDataURL(fileInput.files[0]);

                    document.getElementById("pimage_error_msg").innerHTML = "";
                }
                // document.getElementById("").innerHTML = "";
            });
        });


        image1RemoveBtn.onclick = function () {

            var pimage = document.querySelector("#pimage");
            pimage.value = null;
            var pimagea = document.querySelector("#imagePreview1");
            pimagea.value = null;
            image1RemoveBtn.style.display = "none";
            //imagePreview1.style.display = "none";
            document.getElementById("imagePreview1").src = "public/src/upload_btn.jpg";

        }

    </script>

